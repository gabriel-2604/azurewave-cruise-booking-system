<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cruise_id',
        'passenger_count',
        'booking_date',
        'booking_time',
        'contact_number',
        'email',
        'confirmation_file',
        'booking_status',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'booking_time' => 'datetime:H:i',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cruise()
    {
        return $this->belongsTo(Cruise::class);
    }

    public function logs()
    {
    return $this->hasMany(BookingLog::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Status Helpers
    |--------------------------------------------------------------------------
    */

    public function isPending(): bool
    {
        return $this->booking_status === 'Pending';
    }

    public function isApproved(): bool
    {
        return $this->booking_status === 'Approved';
    }

    public function isRejected(): bool
    {
        return $this->booking_status === 'Rejected';
    }

    public function isCancelled(): bool
    {
        return $this->booking_status === 'Cancelled';
    }

    public function isCompleted(): bool
    {
        return $this->booking_status === 'Completed';
    }
}