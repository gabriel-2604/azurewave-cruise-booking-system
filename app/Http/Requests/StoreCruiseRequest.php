<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCruiseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cruise_name' => 'required|string|max:255',

            'destination' => 'required|string|max:255',

            'departure_port' => 'required|string|max:255',

            'description' => 'nullable|string',

            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'capacity' => 'required|integer|min:1',

            'departure_date' => 'required|date|after_or_equal:today',

            'departure_time' => 'required',

            'arrival_date' => 'required|date|after_or_equal:departure_date',

            'ticket_price' => 'required|numeric|min:0',

            'status' => 'required|in:Available,Limited Slots,Fully Booked,Cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'cruise_name.required' => 'Please enter the cruise name.',

            'destination.required' => 'Please enter the destination.',

            'departure_port.required' => 'Departure port is required.',

            'capacity.required' => 'Please enter the cruise capacity.',

            'capacity.integer' => 'Capacity must be a valid number.',

            'capacity.min' => 'Capacity must be at least 1.',

            'departure_date.required' => 'Please select the departure date.',

            'departure_date.after_or_equal' => 'Departure date cannot be in the past.',

            'departure_time.required' => 'Please select the departure time.',

            'arrival_date.required' => 'Please select the arrival date.',

            'arrival_date.after_or_equal' => 'Arrival date must be after or equal to the departure date.',

            'ticket_price.required' => 'Please enter the ticket price.',

            'ticket_price.numeric' => 'Ticket price must be a valid amount.',

            'ticket_price.min' => 'Ticket price cannot be negative.',

            'status.required' => 'Please select the cruise status.',

            'status.in' => 'Invalid cruise status selected.',

            'image.image' => 'Please upload a valid image file.',

            'image.mimes' => 'The cruise image must be JPG, JPEG, or PNG.',

            'image.max' => 'The image must not exceed 2 MB.',
        ];
    }
}