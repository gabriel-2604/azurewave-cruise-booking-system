<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCruiseRequest;
use App\Http\Requests\UpdateCruiseRequest;
use App\Models\Cruise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CruiseController extends Controller
{
    /**
     * Display cruise list with search, statistics, and pagination.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $cruises = Cruise::query()
            ->when($search, function ($query) use ($search) {
                $query->where('cruise_name', 'like', "%{$search}%")
                    ->orWhere('destination', 'like', "%{$search}%")
                    ->orWhere('departure_port', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.cruises.index', [
            'cruises' => $cruises,
            'search' => $search,
            'totalCruises' => Cruise::count(),
            'availableCruises' => Cruise::where('status', 'Available')->count(),
            'limitedCruises' => Cruise::where('status', 'Limited Slots')->count(),
            'fullyBookedCruises' => Cruise::where('status', 'Fully Booked')->count(),
            'cancelledCruises' => Cruise::where('status', 'Cancelled')->count(),
        ]);
    }

    /**
     * Show create cruise form.
     */
    public function create()
    {
        return view('admin.cruises.create');
    }

    /**
     * Store new cruise.
     */
    public function store(StoreCruiseRequest $request)
    {
        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Automatically set available slots
        |--------------------------------------------------------------------------
        */

        $data['available_slots'] = $data['capacity'];

        /*
        |--------------------------------------------------------------------------
        | Upload cruise image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('cruises', 'public');
        }

        Cruise::create($data);

        return redirect()
            ->route('cruises.index')
            ->with('success', 'Cruise created successfully.');
    }

    /**
     * Show cruise details.
     */
    public function show(Cruise $cruise)
    {
        $cruise->load('bookings');

        return view('admin.cruises.show', compact('cruise'));
    }

    /**
     * Show edit cruise form.
     */
    public function edit(Cruise $cruise)
    {
        return view('admin.cruises.edit', compact('cruise'));
    }

    /**
     * Update cruise.
     */
    public function update(UpdateCruiseRequest $request, Cruise $cruise)
    {
        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Prevent available slots from exceeding capacity
        |--------------------------------------------------------------------------
        */

        if (isset($data['available_slots']) && $data['available_slots'] > $data['capacity']) {
            return back()
                ->withErrors([
                    'available_slots' => 'Available slots cannot be greater than the cruise capacity.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Replace cruise image if uploaded
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {
            if ($cruise->image) {
                Storage::disk('public')->delete($cruise->image);
            }

            $data['image'] = $request
                ->file('image')
                ->store('cruises', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Auto-update status based on slots, unless Cancelled
        |--------------------------------------------------------------------------
        */

        if (($data['status'] ?? $cruise->status) !== 'Cancelled') {
            $availableSlots = $data['available_slots'] ?? $cruise->available_slots;

            if ($availableSlots <= 0) {
                $data['available_slots'] = 0;
                $data['status'] = 'Fully Booked';
            } elseif ($availableSlots <= 10) {
                $data['status'] = 'Limited Slots';
            } else {
                $data['status'] = 'Available';
            }
        }

        $cruise->update($data);

        return redirect()
            ->route('cruises.index')
            ->with('success', 'Cruise updated successfully.');
    }

    /**
     * Delete cruise.
     */
    public function destroy(Cruise $cruise)
    {
        /*
        |--------------------------------------------------------------------------
        | Prevent deleting cruises with bookings
        |--------------------------------------------------------------------------
        */

        if ($cruise->bookings()->exists()) {
            return redirect()
                ->route('cruises.index')
                ->with('error', 'This cruise cannot be deleted because it already has bookings.');
        }

        /*
        |--------------------------------------------------------------------------
        | Delete cruise image
        |--------------------------------------------------------------------------
        */

        if ($cruise->image) {
            Storage::disk('public')->delete($cruise->image);
        }

        $cruise->delete();

        return redirect()
            ->route('cruises.index')
            ->with('success', 'Cruise deleted successfully.');
    }
}