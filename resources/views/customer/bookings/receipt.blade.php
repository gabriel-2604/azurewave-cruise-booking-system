@extends('customer.layouts.app')

@section('title', 'Booking Receipt')

@section('content')

<style>

    .receipt-logo {
    width: 76px;
    height: 76px;
    border-radius: 25px;
    background: rgba(255, 255, 255, 0.16);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
    }

.receipt-logo-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    }

.receipt-logo-fallback {
    width: 100%;
    height: 100%;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 42px;
    }
    .receipt-hero {
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 30px;
        color: white;
        background:
            radial-gradient(circle at top right, rgba(255, 214, 10, 0.22), transparent 28%),
            linear-gradient(135deg, rgba(3, 4, 94, 0.96), rgba(2, 62, 138, 0.93), rgba(0, 119, 182, 0.82)),
            url("{{ asset('images/hero.jpg') }}");
        background-size: cover;
        background-position: center;
        box-shadow: 0 24px 65px rgba(3, 4, 94, 0.28);
    }

    .receipt-hero .card-body {
        position: relative;
        z-index: 2;
    }

    .receipt-badge {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 9px 16px;
        border-radius: 50px;
        background: rgba(255, 255, 255, 0.16);
        backdrop-filter: blur(8px);
        font-weight: 700;
        font-size: 13px;
        margin-bottom: 16px;
    }

    .receipt-paper {
        max-width: 950px;
        margin: 0 auto;
        border: none;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 22px 60px rgba(15, 23, 42, 0.12);
        background: white;
    }

    .receipt-header {
        padding: 34px;
        background:
            radial-gradient(circle at top right, rgba(255, 214, 10, 0.18), transparent 30%),
            linear-gradient(135deg, #023e8a, #0077b6);
        color: white;
    }

    .receipt-logo {
        width: 76px;
        height: 76px;
        border-radius: 25px;
        background: rgba(255, 255, 255, 0.16);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        flex-shrink: 0;
    }

    .receipt-body {
        padding: 34px;
    }

    .section-title {
        font-weight: 900;
        color: #023e8a;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        width: 42px;
        height: 42px;
        border-radius: 15px;
        background: #e7f1ff;
        color: #0d6efd;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .info-box {
        padding: 16px;
        border-radius: 18px;
        background: #f8fbff;
        border: 1px solid #edf2f7;
        margin-bottom: 14px;
    }

    .info-label {
        color: #64748b;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .info-value {
        color: #1f2937;
        font-weight: 800;
        word-break: break-word;
    }

    .status-pill {
        border-radius: 50px;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-pending {
        background: #fff8e1;
        color: #9a6a00;
    }

    .status-approved {
        background: #e8fff3;
        color: #137a42;
    }

    .status-rejected {
        background: #fff0f0;
        color: #b42318;
    }

    .status-cancelled {
        background: #f1f5f9;
        color: #475569;
    }

    .status-completed {
        background: #e7f1ff;
        color: #0d6efd;
    }

    .amount-card {
        border-radius: 24px;
        padding: 26px;
        background:
            radial-gradient(circle at top right, rgba(255, 214, 10, 0.22), transparent 30%),
            linear-gradient(135deg, #023e8a, #0077b6);
        color: white;
        box-shadow: 0 18px 45px rgba(0, 119, 182, 0.22);
    }

    .amount-number {
        font-size: 42px;
        font-weight: 900;
    }

    .receipt-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        border-radius: 20px;
        border: 1px solid #edf2f7;
    }

    .receipt-table th {
        background: #f8fbff;
        color: #64748b;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding: 16px;
    }

    .receipt-table td {
        padding: 16px;
        border-top: 1px solid #edf2f7;
        font-weight: 700;
        color: #1f2937;
    }

    .receipt-footer {
        padding: 24px 34px;
        background: #f8fbff;
        border-top: 1px solid #edf2f7;
        color: #64748b;
        font-weight: 600;
    }

    .action-btn {
        height: 46px;
        border-radius: 16px;
        padding: 10px 16px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
    }

    @media print {
        body {
            background: white !important;
        }

        .customer-sidebar,
        .customer-topbar,
        .receipt-hero,
        .no-print,
        .sidebar,
        .topbar {
            display: none !important;
        }

        .customer-content,
        .main-content,
        .content-wrapper {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        .receipt-paper {
            box-shadow: none !important;
            border-radius: 0 !important;
            max-width: 100% !important;
        }
    }

    @media (max-width: 768px) {
        .receipt-header,
        .receipt-body,
        .receipt-footer {
            padding: 22px;
        }

        .amount-number {
            font-size: 32px;
        }

        .action-btn {
            width: 100%;
        }
    }
</style>

@php
    $statusClass = match($booking->booking_status) {
        'Pending' => 'status-pending',
        'Approved' => 'status-approved',
        'Rejected' => 'status-rejected',
        'Cancelled' => 'status-cancelled',
        'Completed' => 'status-completed',
        default => 'status-cancelled',
    };

    $statusIcon = match($booking->booking_status) {
        'Pending' => 'bi-clock-history',
        'Approved' => 'bi-check-circle',
        'Rejected' => 'bi-x-circle',
        'Cancelled' => 'bi-slash-circle',
        'Completed' => 'bi-flag',
        default => 'bi-info-circle',
    };

    $ticketPrice = $booking->cruise->ticket_price ?? 0;
    $totalAmount = $ticketPrice * $booking->passenger_count;
@endphp

<div class="card receipt-hero mb-4 no-print">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="receipt-badge">
                    <i class="bi bi-printer"></i>
                    Printable Receipt
                </div>

                <h2 class="fw-bold mb-3">
                    Booking Receipt
                </h2>

                <p class="mb-4 opacity-75">
                    Print or review your official cruise booking receipt.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-light fw-bold">
                        <i class="bi bi-arrow-left"></i>
                        Back to Booking
                    </a>

                    <button type="button" onclick="window.print()" class="btn btn-warning fw-bold">
                        <i class="bi bi-printer"></i>
                        Print Receipt
                    </button>

                </div>

            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <div class="display-1">
                    🧾
                </div>

                <h5 class="fw-bold mb-0">
                    Receipt #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                </h5>

            </div>

        </div>

    </div>

</div>

<div class="receipt-paper">

    <div class="receipt-header">

        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

            <div class="d-flex align-items-center gap-3">

                <div class="receipt-logo">
            <img src="{{ asset('images/logo.png') }}"
              alt="AzureWave Logo"
                class="receipt-logo-img"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                <div class="receipt-logo-fallback">
                  🚢
            </div>
            </div>

                <div>
                    <h2 class="fw-bold mb-1">
                        AzureWave Cruises
                    </h2>

                    <p class="mb-0 opacity-75">
                        Cruise Ship Booking Management System
                    </p>
                </div>

            </div>

            <div class="text-lg-end">

                <h4 class="fw-bold mb-1">
                    BOOKING RECEIPT
                </h4>

                <p class="mb-0 opacity-75">
                    Receipt No. #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                </p>

            </div>

        </div>

    </div>

    <div class="receipt-body">

        <div class="row g-4 mb-4">

            <div class="col-lg-8">

                <h5 class="section-title">
                    <i class="bi bi-person"></i>
                    Customer Information
                </h5>

                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="info-box">
                            <div class="info-label">Customer Name</div>
                            <div class="info-value">{{ $booking->user->name ?? auth()->user()->name }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">{{ $booking->email }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <div class="info-label">Contact Number</div>
                            <div class="info-value">{{ $booking->contact_number }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <div class="info-label">Booking Status</div>
                            <div class="info-value">
                                <span class="status-pill {{ $statusClass }}">
                                    <i class="bi {{ $statusIcon }}"></i>
                                    {{ $booking->booking_status }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="amount-card h-100">

                    <p class="mb-1 opacity-75 fw-semibold">
                        Estimated Total
                    </p>

                    <div class="amount-number">
                        ₱{{ number_format($totalAmount, 2) }}
                    </div>

                    <p class="mb-0 opacity-75">
                        {{ $booking->passenger_count }} passenger(s) × ₱{{ number_format($ticketPrice, 2) }}
                    </p>

                </div>

            </div>

        </div>

        <h5 class="section-title">
            <i class="bi bi-ship"></i>
            Cruise Information
        </h5>

        <div class="row g-3 mb-4">

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Cruise Name</div>
                    <div class="info-value">{{ $booking->cruise->cruise_name ?? 'Deleted Cruise' }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Destination</div>
                    <div class="info-value">{{ $booking->cruise->destination ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Departure Port</div>
                    <div class="info-value">{{ $booking->cruise->departure_port ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Ticket Price</div>
                    <div class="info-value">₱{{ number_format($ticketPrice, 2) }}</div>
                </div>
            </div>

        </div>

        <h5 class="section-title">
            <i class="bi bi-calendar-check"></i>
            Booking Schedule
        </h5>

        <table class="receipt-table mb-4">

            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Passengers</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>#{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</td>
                    <td>{{ $booking->passenger_count }}</td>
                    <td>₱{{ number_format($totalAmount, 2) }}</td>
                </tr>
            </tbody>

        </table>

        <div class="row g-3">

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Confirmation File</div>
                    <div class="info-value">
                        {{ $booking->confirmation_file ? 'Uploaded' : 'No file uploaded' }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Date Generated</div>
                    <div class="info-value">
                        {{ now()->format('M d, Y h:i A') }}
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="receipt-footer">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

            <div>
                This receipt is system-generated by AzureWave Cruises.
            </div>

            <div>
                Thank you for booking with us.
            </div>

        </div>

    </div>

</div>

@endsection