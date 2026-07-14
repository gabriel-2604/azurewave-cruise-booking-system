<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cruise extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Mass Assignable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'cruise_name',

        'destination',

        'departure_port',

        'description',

        'image',

        'capacity',

        'available_slots',

        'departure_date',

        'departure_time',

        'arrival_date',

        'ticket_price',

        'status',

    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [

            'departure_date' => 'date',

            'arrival_date' => 'date',

            'departure_time' => 'datetime:H:i',

            'ticket_price' => 'decimal:2',

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * One Cruise has many Bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if cruise is fully booked.
     */
    public function isFullyBooked(): bool
    {
        return $this->available_slots <= 0;
    }

    /**
     * Check if cruise is available.
     */
    public function isAvailable(): bool
    {
        return $this->status === 'Available';
    }

    /**
     * Check if cruise has limited slots.
     */
    public function hasLimitedSlots(): bool
    {
        return $this->status === 'Limited Slots';
    }

    /**
     * Check if cruise is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'Cancelled';
    }

    /**
     * Calculate booked passengers.
     */
    public function bookedPassengers()
    {
        return $this->bookings()
            ->where('booking_status', 'Approved')
            ->sum('passenger_count');
    }

    /**
     * Remaining available slots.
     */
    public function remainingSlots()
    {
        return $this->capacity - $this->bookedPassengers();
    }

}