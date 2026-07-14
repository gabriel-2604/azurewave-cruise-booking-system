<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
    return [
        'user_id' => 'nullable|exists:users,id',

        'cruise_id' => 'required|exists:cruises,id',

        'passenger_count' => 'required|integer|min:1',

        'booking_date' => 'required|date|after_or_equal:today',

        'booking_time' => 'required',

        'contact_number' => 'required|string|max:20',

        'email' => 'required|email|max:255',

        'confirmation_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

        'booking_status' => 'nullable|in:Pending,Approved,Rejected,Cancelled,Completed',
    ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Please select a customer.',
            'cruise_id.required' => 'Please select a cruise.',
            'passenger_count.required' => 'Please enter the number of passengers.',
            'passenger_count.min' => 'Passenger count must be at least 1.',
            'booking_date.after_or_equal' => 'Booking date cannot be in the past.',
            'email.email' => 'Please enter a valid email address.',
            'confirmation_file.mimes' => 'The confirmation file must be PDF, JPG, JPEG, or PNG.',
            'confirmation_file.max' => 'The confirmation file must not exceed 2MB.',
        ];
    }
}