<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'customer_name',
        'cruise_name',
        'booking_date',
        'booking_time',
        'booking_status',
        'action',
        'performed_by',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'booking_time' => 'datetime:H:i',
        ];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}