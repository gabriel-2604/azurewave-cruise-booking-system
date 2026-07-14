<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Booking;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Mass Assignable Fields
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'password',
    ];

    /**
     * Hidden Fields
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute Casting
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Eloquent Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * One User can have many Bookings
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
     * Check if the user is an Administrator.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is a Customer.
     */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }
}