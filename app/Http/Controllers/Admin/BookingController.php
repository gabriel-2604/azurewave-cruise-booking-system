<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\Cruise;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $bookings = Booking::with(['user', 'cruise'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('cruise', function ($cruiseQuery) use ($search) {
                    $cruiseQuery->where('cruise_name', 'like', "%{$search}%")
                        ->orWhere('destination', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('booking_status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'search' => $search,
            'status' => $status,
            'totalBookings' => Booking::count(),
            'pendingBookings' => Booking::where('booking_status', 'Pending')->count(),
            'approvedBookings' => Booking::where('booking_status', 'Approved')->count(),
            'cancelledBookings' => Booking::where('booking_status', 'Cancelled')->count(),
        ]);
    }

    public function create()
    {
        $customers = User::where('role', 'customer')
            ->orderBy('name')
            ->get();

        $cruises = Cruise::where('status', '!=', 'Cancelled')
            ->whereDate('departure_date', '>=', today())
            ->orderBy('departure_date')
            ->get();

        return view('admin.bookings.create', compact('customers', 'cruises'));
    }

    public function unavailableDates(Request $request)
    {
        $cruiseId = $request->cruise_id;

        if (!$cruiseId) {
            return response()->json([]);
        }

        $bookings = Booking::with(['user', 'cruise'])
            ->where('cruise_id', $cruiseId)
            ->whereIn('booking_status', ['Pending', 'Approved', 'Completed'])
            ->get();

        $events = $bookings->map(function ($booking) {
            $statusColor = match ($booking->booking_status) {
                'Pending' => '#ffc107',
                'Approved' => '#198754',
                'Completed' => '#0d6efd',
                default => '#6c757d',
            };

            return [
                'id' => $booking->id,
                'title' => $booking->booking_status . ' - ' . Carbon::parse($booking->booking_time)->format('h:i A'),
                'start' => Carbon::parse($booking->booking_date)->format('Y-m-d'),
                'backgroundColor' => $statusColor,
                'borderColor' => $statusColor,
                'extendedProps' => [
                    'customer' => $booking->user->name ?? 'Deleted User',
                    'time' => Carbon::parse($booking->booking_time)->format('h:i A'),
                    'passengers' => $booking->passenger_count,
                    'status' => $booking->booking_status,
                ],
            ];
        });

        return response()->json($events);
    }

    public function store(StoreBookingRequest $request)
    {
        $data = $request->validated();

        $cruise = Cruise::findOrFail($data['cruise_id']);

        if ($this->cruiseHasDeparted($cruise)) {
            $this->updateCruiseStatus($cruise);

            return back()
                ->withErrors([
                    'cruise_id' => 'This cruise has already departed. Please choose another available cruise.',
                ])
                ->withInput();
        }

        if ($cruise->status === 'Cancelled') {
            return back()
                ->withErrors([
                    'cruise_id' => 'This cruise has been cancelled. Please choose another cruise.',
                ])
                ->withInput();
        }

        if ($cruise->status === 'Fully Booked' || $cruise->available_slots <= 0) {
            return back()
                ->withErrors([
                    'cruise_id' => 'This cruise schedule is no longer available. Please choose another available date or time.',
                ])
                ->withInput();
        }

        $duplicateBooking = Booking::where('cruise_id', $data['cruise_id'])
            ->whereDate('booking_date', $data['booking_date'])
            ->where('booking_time', $data['booking_time'])
            ->whereIn('booking_status', ['Pending', 'Approved', 'Completed'])
            ->exists();

        if ($duplicateBooking && $this->consumesSlots($data['booking_status'])) {
            return back()
                ->withErrors([
                    'booking_date' => 'This cruise schedule is no longer available. Please choose another available date or time.',
                ])
                ->withInput();
        }

        if ($this->consumesSlots($data['booking_status'])) {
            if ($data['passenger_count'] > $cruise->available_slots) {
                return back()
                    ->withErrors([
                        'passenger_count' => 'Not enough available slots for this cruise.',
                    ])
                    ->withInput();
            }
        }

        if ($request->hasFile('confirmation_file')) {
            $data['confirmation_file'] = $request
                ->file('confirmation_file')
                ->store('booking_confirmations', 'public');
        }

        DB::transaction(function () use ($data, $cruise) {
            $booking = Booking::create($data);

            $this->createBookingLog($booking, 'Booking Created');

            if ($this->consumesSlots($booking->booking_status)) {
                $cruise->decrement('available_slots', $booking->passenger_count);

                $cruise->refresh();

                $this->updateCruiseStatus($cruise);
            }
        });

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'cruise']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $customers = User::where('role', 'customer')
            ->orderBy('name')
            ->get();

        $cruises = Cruise::where(function ($query) use ($booking) {
                $query->whereDate('departure_date', '>=', today())
                    ->orWhere('id', $booking->cruise_id);
            })
            ->orderBy('departure_date')
            ->get();

        return view('admin.bookings.edit', compact(
            'booking',
            'customers',
            'cruises'
        ));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $data = $request->validated();

        $oldCruise = $booking->cruise;
        $newCruise = Cruise::findOrFail($data['cruise_id']);

        if (
            $this->consumesSlots($data['booking_status']) &&
            $this->cruiseHasDeparted($newCruise)
        ) {
            $this->updateCruiseStatus($newCruise);

            return back()
                ->withErrors([
                    'cruise_id' => 'This cruise has already departed. You cannot assign an active booking to this cruise.',
                ])
                ->withInput();
        }

        $duplicateBooking = Booking::where('id', '!=', $booking->id)
            ->where('cruise_id', $data['cruise_id'])
            ->whereDate('booking_date', $data['booking_date'])
            ->where('booking_time', $data['booking_time'])
            ->whereIn('booking_status', ['Pending', 'Approved', 'Completed'])
            ->exists();

        if ($duplicateBooking && $this->consumesSlots($data['booking_status'])) {
            return back()
                ->withErrors([
                    'booking_date' => 'This cruise schedule is no longer available. Please choose another available date or time.',
                ])
                ->withInput();
        }

        if ($newCruise->status === 'Cancelled' && $this->consumesSlots($data['booking_status'])) {
            return back()
                ->withErrors([
                    'cruise_id' => 'This cruise has been cancelled. Please choose another cruise.',
                ])
                ->withInput();
        }

        $availableSlots = $newCruise->available_slots;

        if (
            $this->consumesSlots($booking->booking_status) &&
            $booking->cruise_id == $newCruise->id
        ) {
            $availableSlots += $booking->passenger_count;
        }

        if (
            $this->consumesSlots($data['booking_status']) &&
            $data['passenger_count'] > $availableSlots
        ) {
            return back()
                ->withErrors([
                    'passenger_count' => 'Not enough available slots for this cruise.',
                ])
                ->withInput();
        }

        if ($request->hasFile('confirmation_file')) {
            if ($booking->confirmation_file) {
                Storage::disk('public')->delete($booking->confirmation_file);
            }

            $data['confirmation_file'] = $request
                ->file('confirmation_file')
                ->store('booking_confirmations', 'public');
        }

        DB::transaction(function () use ($booking, $data, $oldCruise, $newCruise) {
            if ($this->consumesSlots($booking->booking_status)) {
                $oldCruise->increment('available_slots', $booking->passenger_count);
            }

            $booking->update($data);

            $this->createBookingLog($booking, 'Booking Updated');

            if ($this->consumesSlots($booking->booking_status)) {
                $newCruise->decrement('available_slots', $booking->passenger_count);
            }

            $oldCruise->refresh();
            $newCruise->refresh();

            $this->updateCruiseStatus($oldCruise);
            $this->updateCruiseStatus($newCruise);
        });

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $cruise = $booking->cruise;

        DB::transaction(function () use ($booking, $cruise) {
            if ($this->consumesSlots($booking->booking_status)) {
                $cruise->increment('available_slots', $booking->passenger_count);
            }

            if ($booking->confirmation_file) {
                Storage::disk('public')->delete($booking->confirmation_file);
            }

            $this->createBookingLog($booking, 'Booking Deleted');

            $booking->delete();

            $cruise->refresh();

            $this->updateCruiseStatus($cruise);
        });

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    public function approve(Booking $booking)
    {
        if ($booking->booking_status === 'Approved') {
            return redirect()
                ->route('bookings.index')
                ->with('success', 'Booking is already approved.');
        }

        $booking->load('cruise');

        $cruise = $booking->cruise;

        if (!$cruise) {
            return redirect()
                ->route('bookings.index')
                ->with('error', 'Cannot approve booking because the cruise record no longer exists.');
        }

        if ($this->cruiseHasDeparted($cruise)) {
            $this->updateCruiseStatus($cruise);

            return redirect()
                ->route('bookings.index')
                ->with('error', 'Cannot approve booking because the cruise departure date has already passed.');
        }

        if ($cruise->status === 'Cancelled') {
            return redirect()
                ->route('bookings.index')
                ->with('error', 'Cannot approve booking because the cruise is cancelled.');
        }

        if (!$this->consumesSlots($booking->booking_status)) {
            if ($booking->passenger_count > $cruise->available_slots) {
                return redirect()
                    ->route('bookings.index')
                    ->with('error', 'Cannot approve booking. Not enough available slots.');
            }

            DB::transaction(function () use ($booking, $cruise) {
                $booking->update([
                    'booking_status' => 'Approved',
                ]);

                $this->createBookingLog($booking, 'Booking Approved');

                $cruise->decrement('available_slots', $booking->passenger_count);

                $cruise->refresh();

                $this->updateCruiseStatus($cruise);
            });

            return redirect()
                ->route('bookings.index')
                ->with('success', 'Booking approved successfully.');
        }

        $booking->update([
            'booking_status' => 'Approved',
        ]);

        $this->createBookingLog($booking, 'Booking Approved');

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking approved successfully.');
    }

    public function reject(Booking $booking)
    {
        if ($booking->booking_status === 'Rejected') {
            return redirect()
                ->route('bookings.index')
                ->with('success', 'Booking is already rejected.');
        }

        $cruise = $booking->cruise;

        if ($cruise && $this->consumesSlots($booking->booking_status)) {
            DB::transaction(function () use ($booking, $cruise) {
                $cruise->increment('available_slots', $booking->passenger_count);

                $booking->update([
                    'booking_status' => 'Rejected',
                ]);

                $this->createBookingLog($booking, 'Booking Rejected');

                $cruise->refresh();

                $this->updateCruiseStatus($cruise);
            });

            return redirect()
                ->route('bookings.index')
                ->with('success', 'Booking rejected successfully.');
        }

        $booking->update([
            'booking_status' => 'Rejected',
        ]);

        $this->createBookingLog($booking, 'Booking Rejected');

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking rejected successfully.');
    }

    public function cancel(Booking $booking)
    {
        if ($booking->booking_status === 'Cancelled') {
            return redirect()
                ->route('bookings.index')
                ->with('success', 'Booking is already cancelled.');
        }

        $cruise = $booking->cruise;

        if ($cruise && $this->consumesSlots($booking->booking_status)) {
            DB::transaction(function () use ($booking, $cruise) {
                $cruise->increment('available_slots', $booking->passenger_count);

                $booking->update([
                    'booking_status' => 'Cancelled',
                ]);

                $this->createBookingLog($booking, 'Booking Cancelled');

                $cruise->refresh();

                $this->updateCruiseStatus($cruise);
            });

            return redirect()
                ->route('bookings.index')
                ->with('success', 'Booking cancelled successfully.');
        }

        $booking->update([
            'booking_status' => 'Cancelled',
        ]);

        $this->createBookingLog($booking, 'Booking Cancelled');

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }

    private function consumesSlots(string $status): bool
    {
        return in_array($status, ['Pending', 'Approved', 'Completed']);
    }

    private function cruiseHasDeparted(Cruise $cruise): bool
    {
        $departureDateTime = Carbon::parse($cruise->departure_date . ' ' . $cruise->departure_time);

        return $departureDateTime->isPast();
    }

    private function updateCruiseStatus(Cruise $cruise): void
    {
        if ($cruise->status === 'Cancelled') {
            return;
        }

        if ($this->cruiseHasDeparted($cruise)) {
            $cruise->update([
                'status' => 'Completed',
            ]);

            return;
        }

        if ($cruise->available_slots <= 0) {
            $cruise->update([
                'available_slots' => 0,
                'status' => 'Fully Booked',
            ]);

            return;
        }

        if ($cruise->available_slots <= 10) {
            $cruise->update([
                'status' => 'Limited Slots',
            ]);

            return;
        }

        $cruise->update([
            'status' => 'Available',
        ]);
    }

    private function createBookingLog(Booking $booking, string $action): void
    {
        $booking->load(['user', 'cruise']);

        BookingLog::create([
            'booking_id' => $booking->id,
            'customer_name' => $booking->user->name ?? 'Deleted User',
            'cruise_name' => $booking->cruise->cruise_name ?? 'Deleted Cruise',
            'booking_date' => $booking->booking_date,
            'booking_time' => $booking->booking_time,
            'booking_status' => $booking->booking_status,
            'action' => $action,
            'performed_by' => auth()->user()->name ?? 'System',
        ]);
    }
}