<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CruiseController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\BookingLogController;
use App\Http\Controllers\Admin\CalendarController as AdminCalendarController;
use App\Http\Controllers\Admin\CustomerController;

use App\Http\Controllers\Customer\CalendarController as CustomerCalendarController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

/*
|--------------------------------------------------------------------------
| Customer Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'customerLogin'])
    ->name('customer.login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('customer.login.store');

Route::get('/register', [AuthController::class, 'customerRegister'])
    ->name('customer.register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('customer.register.store');

/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthController::class, 'adminLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AuthController::class, 'adminAuthenticate'])
    ->name('admin.login.store');

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'customer'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Customer Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/customer/dashboard', function () {
        return view('customer.dashboard.index');
    })->name('customer.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Customer Event Calendar
    |--------------------------------------------------------------------------
    */

    Route::get('/customer/calendar', [CustomerCalendarController::class, 'index'])
        ->name('customer.calendar.index');

    Route::get('/customer/calendar/events', [CustomerCalendarController::class, 'events'])
        ->name('customer.calendar.events');

    /*
    |--------------------------------------------------------------------------
    | Customer Bookings
    |--------------------------------------------------------------------------
    */

    Route::get('/customer/bookings', [CustomerBookingController::class, 'index'])
        ->name('customer.bookings.index');

    Route::get('/customer/bookings/create', [CustomerBookingController::class, 'create'])
        ->name('customer.bookings.create');

    Route::post('/customer/bookings', [CustomerBookingController::class, 'store'])
        ->name('customer.bookings.store');

    /*
    |--------------------------------------------------------------------------
    | Important:
    | Keep unavailable-dates above /customer/bookings/{booking}
    |--------------------------------------------------------------------------
    */

    Route::get('/customer/bookings/unavailable-dates', [CustomerBookingController::class, 'unavailableDates'])
        ->name('customer.bookings.unavailable_dates');
        
    Route::get('/customer/bookings/{booking}/receipt', [CustomerBookingController::class, 'receipt'])
    ->name('customer.bookings.receipt');

    Route::get('/customer/bookings/{booking}', [CustomerBookingController::class, 'show'])
        ->name('customer.bookings.show');

    Route::get('/customer/bookings/{booking}/edit', [CustomerBookingController::class, 'edit'])
        ->name('customer.bookings.edit');

    Route::put('/customer/bookings/{booking}', [CustomerBookingController::class, 'update'])
        ->name('customer.bookings.update');

    Route::patch('/customer/bookings/{booking}/cancel', [CustomerBookingController::class, 'cancel'])
        ->name('customer.bookings.cancel');

    /*
    |--------------------------------------------------------------------------
    | Customer Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/customer/profile', [CustomerProfileController::class, 'index'])
        ->name('customer.profile.index');

    Route::put('/customer/profile', [CustomerProfileController::class, 'update'])
        ->name('customer.profile.update');

    Route::put('/customer/profile/password', [CustomerProfileController::class, 'updatePassword'])
        ->name('customer.profile.password');

});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/reports', [ReportController::class, 'index'])
    ->name('reports.index');

    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Cruise Management
    |--------------------------------------------------------------------------
    */

    Route::resource('cruises', CruiseController::class);

    /*
    |--------------------------------------------------------------------------
    | Booking Status Actions
    |--------------------------------------------------------------------------
    */

    Route::patch('/bookings/{booking}/approve', [BookingController::class, 'approve'])
        ->name('bookings.approve');

    Route::patch('/bookings/{booking}/reject', [BookingController::class, 'reject'])
        ->name('bookings.reject');

    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
        ->name('bookings.cancel');

    /*
    |--------------------------------------------------------------------------
    | Booking Management
    |--------------------------------------------------------------------------
    | Keep unavailable-dates above Route::resource('bookings')
    |--------------------------------------------------------------------------
    */

    Route::get('/bookings/unavailable-dates', [BookingController::class, 'unavailableDates'])
        ->name('bookings.unavailable_dates');

    Route::resource('bookings', BookingController::class);

    /*
    |--------------------------------------------------------------------------
    | Booking Logs
    |--------------------------------------------------------------------------
    */

    Route::get('/booking-logs', [BookingLogController::class, 'index'])
        ->name('booking_logs.index');

    /*
    |--------------------------------------------------------------------------
    | Customer Management
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/customers', [CustomerController::class, 'index'])
        ->name('customers.index');

    Route::get('/admin/customers/{customer}', [CustomerController::class, 'show'])
        ->name('customers.show');

    /*
    |--------------------------------------------------------------------------
    | Admin Event Calendar
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/calendar', [AdminCalendarController::class, 'index'])
        ->name('calendar.index');

    Route::get('/admin/calendar/events', [AdminCalendarController::class, 'events'])
        ->name('calendar.events');

}); 