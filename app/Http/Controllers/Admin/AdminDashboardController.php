<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\Cruise;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();

        $totalCustomers = User::where('role', 'customer')->count();

        $totalCruises = Cruise::count();

        $totalBookings = Booking::count();

        $bookedDates = Booking::whereIn('booking_status', ['Pending', 'Approved', 'Completed'])
            ->distinct('booking_date')
            ->count('booking_date');

        $pendingBookings = Booking::where('booking_status', 'Pending')->count();

        $approvedBookings = Booking::where('booking_status', 'Approved')->count();

        $rejectedBookings = Booking::where('booking_status', 'Rejected')->count();

        $cancelledBookings = Booking::where('booking_status', 'Cancelled')->count();

        $completedBookings = Booking::where('booking_status', 'Completed')->count();

        $activeBookings = Booking::whereIn('booking_status', ['Pending', 'Approved'])->count();

        $availableCruises = Cruise::where('status', 'Available')->count();

        $limitedCruises = Cruise::where('status', 'Limited Slots')->count();

        $fullyBookedCruises = Cruise::where('status', 'Fully Booked')->count();

        $cancelledCruises = Cruise::where('status', 'Cancelled')->count();

        $todayBookings = Booking::whereDate('created_at', today())->count();

        $estimatedRevenue = Booking::with('cruise')
            ->whereIn('booking_status', ['Approved', 'Completed'])
            ->get()
            ->sum(function ($booking) {
                return $booking->passenger_count * ($booking->cruise->ticket_price ?? 0);
            });

        $recentBookings = Booking::with(['user', 'cruise'])
            ->latest()
            ->take(8)
            ->get();

        $recentLogs = BookingLog::latest()
            ->take(6)
            ->get();

        $topCruise = Cruise::withCount('bookings')
            ->orderByDesc('bookings_count')
            ->first();

        $upcomingBookings = Booking::with(['user', 'cruise'])
            ->whereIn('booking_status', ['Pending', 'Approved'])
            ->whereDate('booking_date', '>=', today())
            ->orderBy('booking_date')
            ->orderBy('booking_time')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'totalCustomers',
            'totalCruises',
            'totalBookings',
            'bookedDates',
            'pendingBookings',
            'approvedBookings',
            'rejectedBookings',
            'cancelledBookings',
            'completedBookings',
            'activeBookings',
            'availableCruises',
            'limitedCruises',
            'fullyBookedCruises',
            'cancelledCruises',
            'todayBookings',
            'estimatedRevenue',
            'recentBookings',
            'recentLogs',
            'topCruise',
            'upcomingBookings'
        ));
    }
}