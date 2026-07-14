<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        return view('customer.calendar.index');
    }

    public function events()
    {
        $bookings = Booking::with(['cruise'])
            ->where('user_id', auth()->id())
            ->get();

        $events = $bookings->map(function ($booking) {
            $statusColor = match ($booking->booking_status) {
                'Pending' => '#ffc107',
                'Approved' => '#198754',
                'Rejected' => '#dc3545',
                'Cancelled' => '#6c757d',
                'Completed' => '#0d6efd',
                default => '#212529',
            };

            return [
                'id' => $booking->id,

                'title' => $booking->cruise->cruise_name . ' - ' . $booking->booking_status,

                'start' => Carbon::parse($booking->booking_date)->format('Y-m-d') . 'T' .
                           Carbon::parse($booking->booking_time)->format('H:i:s'),

                'backgroundColor' => $statusColor,

                'borderColor' => $statusColor,

                'extendedProps' => [
                    'cruise' => $booking->cruise->cruise_name,
                    'destination' => $booking->cruise->destination,
                    'date' => Carbon::parse($booking->booking_date)->format('M d, Y'),
                    'time' => Carbon::parse($booking->booking_time)->format('h:i A'),
                    'passengers' => $booking->passenger_count,
                    'status' => $booking->booking_status,
                ],
            ];
        });

        return response()->json($events);
    }
}