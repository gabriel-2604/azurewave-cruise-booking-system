<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingLog;
use Illuminate\Http\Request;

class BookingLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $logs = BookingLog::when($search, function ($query) use ($search) {
                $query->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('cruise_name', 'like', "%{$search}%")
                    ->orWhere('booking_status', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%")
                    ->orWhere('performed_by', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.booking_logs.index', [
            'logs' => $logs,
            'search' => $search,
            'totalLogs' => BookingLog::count(),
            'createdLogs' => BookingLog::where('action', 'Booking Created')->count(),
            'updatedLogs' => BookingLog::where('action', 'Booking Updated')->count(),
            'deletedLogs' => BookingLog::where('action', 'Booking Deleted')->count(),
        ]);
    }
}