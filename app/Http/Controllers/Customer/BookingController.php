<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\Cruise;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('cruise')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('customer.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $cruises = Cruise::whereNotIn('status', ['Cancelled', 'Completed'])
            ->where('available_slots', '>', 0)
            ->whereDate('departure_date', '>=', today())
            ->orderBy('departure_date')
            ->get();

        return view('customer.bookings.create', compact('cruises'));
    }

    public function store(StoreBookingRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();
        $data['booking_status'] = 'Pending';

        $cruise = Cruise::findOrFail($data['cruise_id']);

        if ($this->bookingDateIsAfterDeparture($data['booking_date'], $cruise)) {
            return back()
                ->withErrors([
                    'booking_date' => 'You cannot book a date after the cruise departure date. This cruise departs on ' . Carbon::parse($cruise->departure_date)->format('M d, Y') . '.',
                ])
                ->withInput();
        }

        if ($this->cruiseHasDeparted($cruise)) {
            $this->updateCruiseStatus($cruise);

            return back()
                ->withErrors([
                    'cruise_id' => 'This cruise has already departed. Please choose another available cruise.',
                ])
                ->withInput();
        }

        if ($cruise->status === 'Completed') {
            return back()
                ->withErrors([
                    'cruise_id' => 'This cruise is already completed. Please choose another available cruise.',
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
                    'cruise_id' => 'This cruise schedule is no longer available.',
                ])
                ->withInput();
        }

        $duplicateBooking = Booking::where('cruise_id', $data['cruise_id'])
            ->whereDate('booking_date', $data['booking_date'])
            ->where('booking_time', $data['booking_time'])
            ->whereIn('booking_status', ['Pending', 'Approved', 'Completed'])
            ->exists();

        if ($duplicateBooking) {
            return back()
                ->withErrors([
                    'booking_date' => 'This cruise schedule is already booked. Please choose another date or time.',
                ])
                ->withInput();
        }

        if ($data['passenger_count'] > $cruise->available_slots) {
            return back()
                ->withErrors([
                    'passenger_count' => 'Not enough available slots for this cruise.',
                ])
                ->withInput();
        }

        if ($request->hasFile('confirmation_file')) {
            $data['confirmation_file'] = $request
                ->file('confirmation_file')
                ->store('booking_confirmations', 'public');
        }

        DB::transaction(function () use ($data, $cruise) {
            $booking = Booking::create($data);

            $cruise->decrement('available_slots', $booking->passenger_count);

            $cruise->refresh();

            $this->updateCruiseStatus($cruise);

            $this->createBookingLog($booking, 'Customer Booking Created');
        });

        return redirect()
            ->route('customer.bookings.index')
            ->with('success', 'Your booking has been submitted successfully and is now pending approval.');
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['cruise', 'user']);

        return view('customer.bookings.show', compact('booking'));
    }

    public function receipt(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['cruise', 'user']);

        return view('customer.bookings.receipt', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->booking_status !== 'Pending') {
            return redirect()
                ->route('customer.bookings.index')
                ->with('error', 'Only pending bookings can be edited.');
        }

        $cruises = Cruise::where(function ($query) use ($booking) {
                $query->where(function ($availableQuery) {
                    $availableQuery->whereNotIn('status', ['Cancelled', 'Completed'])
                        ->where('available_slots', '>', 0)
                        ->whereDate('departure_date', '>=', today());
                })
                ->orWhere('id', $booking->cruise_id);
            })
            ->orderBy('departure_date')
            ->get();

        $booking->load(['cruise', 'user']);

        return view('customer.bookings.edit', compact('booking', 'cruises'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->booking_status !== 'Pending') {
            return redirect()
                ->route('customer.bookings.index')
                ->with('error', 'Only pending bookings can be edited.');
        }

        $data = $request->validated();

        $data['user_id'] = auth()->id();
        $data['booking_status'] = 'Pending';

        $oldCruise = $booking->cruise;
        $newCruise = Cruise::findOrFail($data['cruise_id']);

        if ($this->bookingDateIsAfterDeparture($data['booking_date'], $newCruise)) {
            return back()
                ->withErrors([
                    'booking_date' => 'You cannot book a date after the cruise departure date. This cruise departs on ' . Carbon::parse($newCruise->departure_date)->format('M d, Y') . '.',
                ])
                ->withInput();
        }

        if ($this->cruiseHasDeparted($newCruise)) {
            $this->updateCruiseStatus($newCruise);

            return back()
                ->withErrors([
                    'cruise_id' => 'This cruise has already departed. Please choose another available cruise.',
                ])
                ->withInput();
        }

        if ($newCruise->status === 'Completed') {
            return back()
                ->withErrors([
                    'cruise_id' => 'This cruise is already completed. Please choose another available cruise.',
                ])
                ->withInput();
        }

        if ($newCruise->status === 'Cancelled') {
            return back()
                ->withErrors([
                    'cruise_id' => 'This cruise has been cancelled. Please choose another cruise.',
                ])
                ->withInput();
        }

        $duplicateBooking = Booking::where('id', '!=', $booking->id)
            ->where('cruise_id', $data['cruise_id'])
            ->whereDate('booking_date', $data['booking_date'])
            ->where('booking_time', $data['booking_time'])
            ->whereIn('booking_status', ['Pending', 'Approved', 'Completed'])
            ->exists();

        if ($duplicateBooking) {
            return back()
                ->withErrors([
                    'booking_date' => 'This cruise schedule is already booked. Please choose another date or time.',
                ])
                ->withInput();
        }

        $availableSlots = $newCruise->available_slots;

        if ($booking->cruise_id == $newCruise->id) {
            $availableSlots += $booking->passenger_count;
        }

        if ($data['passenger_count'] > $availableSlots) {
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
            if ($oldCruise) {
                $oldCruise->increment('available_slots', $booking->passenger_count);
            }

            $booking->update($data);

            if ($newCruise) {
                $newCruise->decrement('available_slots', $booking->passenger_count);
            }

            if ($oldCruise) {
                $oldCruise->refresh();
                $this->updateCruiseStatus($oldCruise);
            }

            if ($newCruise) {
                $newCruise->refresh();
                $this->updateCruiseStatus($newCruise);
            }

            $this->createBookingLog($booking, 'Customer Booking Updated');
        });

        return redirect()
            ->route('customer.bookings.index')
            ->with('success', 'Your pending booking has been updated successfully.');
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if (in_array($booking->booking_status, ['Cancelled', 'Rejected', 'Completed'])) {
            return redirect()
                ->route('customer.bookings.index')
                ->with('error', 'This booking can no longer be cancelled.');
        }

        $cruise = $booking->cruise;

        DB::transaction(function () use ($booking, $cruise) {
            if ($cruise && in_array($booking->booking_status, ['Pending', 'Approved'])) {
                $cruise->increment('available_slots', $booking->passenger_count);
            }

            $booking->update([
                'booking_status' => 'Cancelled',
            ]);

            if ($cruise) {
                $cruise->refresh();
                $this->updateCruiseStatus($cruise);
            }

            $this->createBookingLog($booking, 'Customer Booking Cancelled');
        });

        return redirect()
            ->route('customer.bookings.index')
            ->with('success', 'Your booking has been cancelled successfully.');
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
                    'time' => Carbon::parse($booking->booking_time)->format('h:i A'),
                    'passengers' => $booking->passenger_count,
                    'status' => $booking->booking_status,
                ],
            ];
        });

        return response()->json($events);
    }

    private function cruiseHasDeparted(Cruise $cruise): bool
    {
        $departureDate = Carbon::parse($cruise->departure_date)->format('Y-m-d');
        $departureTime = Carbon::parse($cruise->departure_time)->format('H:i:s');

        $departureDateTime = Carbon::parse($departureDate . ' ' . $departureTime);

        return $departureDateTime->isPast();
    }

    private function bookingDateIsAfterDeparture(string $bookingDate, Cruise $cruise): bool
    {
        $selectedBookingDate = Carbon::parse($bookingDate)->format('Y-m-d');
        $cruiseDepartureDate = Carbon::parse($cruise->departure_date)->format('Y-m-d');

        return $selectedBookingDate > $cruiseDepartureDate;
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
            'performed_by' => auth()->user()->name ?? 'Customer',
        ]);
    }
}