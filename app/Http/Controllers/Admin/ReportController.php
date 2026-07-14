<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Cruise;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        $totalBookings = Booking::count();

        $pendingBookings = Booking::where('booking_status', 'Pending')->count();

        $approvedBookings = Booking::where('booking_status', 'Approved')->count();

        $rejectedBookings = Booking::where('booking_status', 'Rejected')->count();

        $cancelledBookings = Booking::where('booking_status', 'Cancelled')->count();

        $completedBookings = Booking::where('booking_status', 'Completed')->count();

        $totalCustomers = User::where('role', 'customer')->count();

        $totalCruises = Cruise::count();

        /*
        |--------------------------------------------------------------------------
        | Estimated Revenue
        |--------------------------------------------------------------------------
        | We count Approved and Completed bookings only.
        */

        $estimatedRevenue = Booking::with('cruise')
            ->whereIn('booking_status', ['Approved', 'Completed'])
            ->get()
            ->sum(function ($booking) {
                return $booking->passenger_count * ($booking->cruise->ticket_price ?? 0);
            });

        /*
        |--------------------------------------------------------------------------
        | Top Booked Cruises
        |--------------------------------------------------------------------------
        */

        $topCruises = Cruise::withCount('bookings')
            ->orderByDesc('bookings_count')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Recent Bookings
        |--------------------------------------------------------------------------
        */

        $recentBookings = Booking::with(['user', 'cruise'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reports.index', compact(
            'totalBookings',
            'pendingBookings',
            'approvedBookings',
            'rejectedBookings',
            'cancelledBookings',
            'completedBookings',
            'totalCustomers',
            'totalCruises',
            'estimatedRevenue',
            'topCruises',
            'recentBookings'
        ));
    }
}