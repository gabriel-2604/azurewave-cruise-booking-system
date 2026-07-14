<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class CalendarController extends Controller
{
    public function index()
    {
        return view('admin.calendar.index');
    }

    public function events()
    {
        $bookings = Booking::with(['user', 'cruise'])
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

                'title' => $booking->cruise->cruise_name . ' - ' . $booking->user->name,

                'start' => $booking->booking_date->format('Y-m-d') . 'T' . $booking->booking_time->format('H:i:s'),

                'backgroundColor' => $statusColor,

                'borderColor' => $statusColor,

                'extendedProps' => [
                    'customer' => $booking->user->name,
                    'email' => $booking->email,
                    'cruise' => $booking->cruise->cruise_name,
                    'destination' => $booking->cruise->destination,
                    'date' => $booking->booking_date->format('M d, Y'),
                    'time' => $booking->booking_time->format('h:i A'),
                    'passengers' => $booking->passenger_count,
                    'status' => $booking->booking_status,
                ],
            ];
        });

        return response()->json($events);
    }
}