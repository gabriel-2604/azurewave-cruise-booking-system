<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $customers = User::where('role', 'customer')
            ->withCount([
                'bookings',
                'bookings as pending_bookings_count' => function ($query) {
                    $query->where('booking_status', 'Pending');
                },
                'bookings as approved_bookings_count' => function ($query) {
                    $query->where('booking_status', 'Approved');
                },
                'bookings as cancelled_bookings_count' => function ($query) {
                    $query->where('booking_status', 'Cancelled');
                },
            ])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($customerQuery) use ($search) {
                    $customerQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.customers.index', [
            'customers' => $customers,
            'search' => $search,
            'totalCustomers' => User::where('role', 'customer')->count(),
            'customersWithBookings' => User::where('role', 'customer')
                ->whereHas('bookings')
                ->count(),
            'totalCustomerBookings' => Booking::whereHas('user', function ($query) {
                $query->where('role', 'customer');
            })->count(),
            'pendingCustomerBookings' => Booking::where('booking_status', 'Pending')
                ->whereHas('user', function ($query) {
                    $query->where('role', 'customer');
                })
                ->count(),
        ]);
    }

    public function show(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $customer->load([
            'bookings' => function ($query) {
                $query->with('cruise')->latest();
            },
        ]);

        return view('admin.customers.show', [
            'customer' => $customer,
            'totalBookings' => $customer->bookings->count(),
            'pendingBookings' => $customer->bookings
                ->where('booking_status', 'Pending')
                ->count(),
            'approvedBookings' => $customer->bookings
                ->where('booking_status', 'Approved')
                ->count(),
            'cancelledBookings' => $customer->bookings
                ->where('booking_status', 'Cancelled')
                ->count(),
        ]);
    }
}