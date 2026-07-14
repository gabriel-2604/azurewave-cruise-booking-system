<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AzureWave | @yield('title', 'Cruise Booking')</title>

    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f4f9ff;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /*
        |--------------------------------------------------------------------------
        | Customer Sidebar
        |--------------------------------------------------------------------------
        */

        .customer-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 285px;
            height: 100vh;
            background:
                linear-gradient(180deg, rgba(2, 62, 138, 0.98), rgba(0, 119, 182, 0.96)),
                url("{{ asset('images/hero.jpg') }}");
            background-size: cover;
            background-position: center;
            color: white;
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            box-shadow: 12px 0 35px rgba(15, 23, 42, 0.18);
        }

        .customer-sidebar-brand {
            margin-bottom: 22px;
        }

        .customer-brand-link {
            display: flex;
            align-items: center;
            gap: 14px;
            color: white;
            text-decoration: none;
        }

        .customer-brand-link:hover {
            color: white;
        }

        .customer-logo-wrap {
            width: 62px;
            height: 62px;
            border-radius: 22px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.18);
        }

        .customer-logo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .customer-logo-fallback {
            width: 100%;
            height: 100%;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 34px;
        }

        .customer-brand-text h4 {
            font-weight: 900;
            margin: 0;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .customer-brand-text small {
            color: rgba(255, 255, 255, 0.82);
            font-weight: 600;
        }

        .sidebar-user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(10px);
            margin-bottom: 24px;
        }

        .user-avatar {
            width: 46px;
            height: 46px;
            border-radius: 17px;
            background: rgba(255, 255, 255, 0.22);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .sidebar-user-card h6 {
            font-weight: 800;
            color: white;
        }

        .sidebar-user-card small {
            color: rgba(255, 255, 255, 0.78);
            font-size: 12px;
        }

        .sidebar-menu-label {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.3px;
            color: rgba(255, 255, 255, 0.65);
            margin: 0 0 12px 12px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex: 1;
        }

        .sidebar-menu li {
            margin-bottom: 8px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 14px;
            border-radius: 18px;
            color: rgba(255, 255, 255, 0.86);
            text-decoration: none;
            font-weight: 700;
            transition: 0.22s ease;
        }

        .sidebar-menu a i {
            width: 24px;
            font-size: 20px;
            text-align: center;
        }

        .sidebar-menu a:hover {
            color: white;
            background: rgba(255, 255, 255, 0.14);
            transform: translateX(5px);
        }

        .sidebar-menu a.active {
            color: #023e8a;
            background: #ffffff;
            box-shadow: 0 14px 30px rgba(255, 255, 255, 0.18);
        }

        .sidebar-menu a.active i {
            color: #0077b6;
        }

        .sidebar-footer {
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.16);
        }

        .logout-btn {
            width: 100%;
            border: none;
            border-radius: 18px;
            padding: 13px 14px;
            background: rgba(220, 53, 69, 0.92);
            color: white;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: 0.22s ease;
        }

        .logout-btn:hover {
            background: #dc3545;
            transform: translateY(-2px);
        }

        /*
        |--------------------------------------------------------------------------
        | Main Content
        |--------------------------------------------------------------------------
        */

        .main-content {
            margin-left: 285px;
            min-height: 100vh;
            padding: 26px;
        }

        .content-wrapper {
            max-width: 1600px;
            margin: 0 auto;
        }

        .topbar {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid #edf2f7;
            border-radius: 24px;
            padding: 18px 22px;
            margin-bottom: 24px;
            box-shadow: 0 14px 35px rgba(15, 23, 42, 0.06);
            backdrop-filter: blur(10px);
        }

        .topbar h5 {
            color: #023e8a;
            font-weight: 900;
        }

        .customer-badge {
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-avatar {
            width: 45px;
            height: 45px;
            border-radius: 16px;
            background: linear-gradient(135deg, #0077b6, #00b4d8);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            flex-shrink: 0;
        }

        /*
        |--------------------------------------------------------------------------
        | Old Customer Cards Compatibility
        |--------------------------------------------------------------------------
        */

        .customer-welcome-card {
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            border: none;
            color: white;
            border-radius: 18px;
            overflow: hidden;
            position: relative;
        }

        .customer-welcome-card::after {
            content: "🚢";
            position: absolute;
            right: 35px;
            bottom: -20px;
            font-size: 7rem;
            opacity: 0.18;
        }

        .quick-action-card {
            transition: 0.25s ease;
            border-radius: 16px;
        }

        .quick-action-card:hover {
            transform: translateY(-4px);
        }

        /*
        |--------------------------------------------------------------------------
        | SweetAlert Popup Style
        |--------------------------------------------------------------------------
        */

        .swal2-popup {
            border-radius: 24px !important;
            font-family: 'Poppins', sans-serif !important;
        }

        .swal2-title {
            font-weight: 900 !important;
        }

        .swal2-html-container,
        .swal2-content {
            font-weight: 500 !important;
        }

        .swal2-confirm,
        .swal2-cancel {
            border-radius: 14px !important;
            padding: 10px 20px !important;
            font-weight: 800 !important;
        }

        /*
        |--------------------------------------------------------------------------
        | Footer
        |--------------------------------------------------------------------------
        */

        .customer-footer {
            color: #64748b;
            font-weight: 500;
        }

        /*
        |--------------------------------------------------------------------------
        | Responsive
        |--------------------------------------------------------------------------
        */

        @media (max-width: 991px) {
            .customer-sidebar {
                position: relative;
                width: 100%;
                height: auto;
                border-radius: 0 0 28px 28px;
            }

            .sidebar-menu {
                flex: unset;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .customer-sidebar {
                padding: 20px 14px;
            }

            .customer-brand-link {
                justify-content: center;
                text-align: center;
                flex-direction: column;
            }

            .sidebar-user-card {
                justify-content: center;
                text-align: center;
            }

            .sidebar-menu a {
                justify-content: center;
            }

            .topbar {
                align-items: flex-start !important;
                gap: 15px;
                flex-direction: column;
            }

            .topbar-user {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <aside class="customer-sidebar">

        <div class="customer-sidebar-brand">

            <a href="{{ route('customer.dashboard') }}" class="customer-brand-link">

                <div class="customer-logo-wrap">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="AzureWave Logo"
                         class="customer-logo"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                    <div class="customer-logo-fallback">
                        🚢
                    </div>
                </div>

                <div class="customer-brand-text">
                    <h4>AzureWave</h4>
                    <small>Cruise Booking</small>
                </div>

            </a>

        </div>

        <div class="sidebar-user-card">

            <div class="user-avatar">
                <i class="bi bi-person"></i>
            </div>

            <div>
                <h6 class="mb-0">
                    {{ auth()->user()->name }}
                </h6>

                <small>
                    Customer Account
                </small>
            </div>

        </div>

        <div class="sidebar-menu-label">
            MAIN MENU
        </div>

        <ul class="sidebar-menu">

            <li>
                <a href="{{ route('customer.dashboard') }}"
                   class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">

                    <i class="bi bi-speedometer2"></i>

                    <span>
                        Dashboard
                    </span>

                </a>
            </li>

            <li>
                <a href="{{ route('customer.calendar.index') }}"
                   class="{{ request()->routeIs('customer.calendar.*') ? 'active' : '' }}">

                    <i class="bi bi-calendar3"></i>

                    <span>
                        My Event Calendar
                    </span>

                </a>
            </li>

            <li>
                <a href="{{ route('customer.bookings.create') }}"
                   class="{{ request()->routeIs('customer.bookings.create') ? 'active' : '' }}">

                    <i class="bi bi-calendar-plus"></i>

                    <span>
                        Create Booking
                    </span>

                </a>
            </li>

            <li>
                <a href="{{ route('customer.bookings.index') }}"
                   class="{{ request()->routeIs('customer.bookings.index') || request()->routeIs('customer.bookings.show') || request()->routeIs('customer.bookings.edit') || request()->routeIs('customer.bookings.receipt') ? 'active' : '' }}">

                    <i class="bi bi-list-check"></i>

                    <span>
                        My Bookings
                    </span>

                </a>
            </li>

            <li>
                <a href="{{ route('customer.profile.index') }}"
                   class="{{ request()->routeIs('customer.profile.*') ? 'active' : '' }}">

                    <i class="bi bi-person-circle"></i>

                    <span>
                        My Profile
                    </span>

                </a>
            </li>

        </ul>

        <div class="sidebar-footer">

            <form method="POST"
                  action="{{ route('logout') }}"
                  class="confirm-action"
                  data-title="Logout?"
                  data-text="You will be signed out from your customer account."
                  data-icon="question"
                  data-confirm-text="Yes, Logout"
                  data-confirm-color="#dc3545">

                @csrf

                <button type="submit" class="logout-btn">

                    <i class="bi bi-box-arrow-right"></i>

                    <span>
                        Logout
                    </span>

                </button>

            </form>

        </div>

    </aside>

    <main class="main-content">

        <div class="content-wrapper">

            <div class="topbar d-flex justify-content-between align-items-center">

                <div>
                    <h5 class="fw-bold mb-0">
                        @yield('title')
                    </h5>

                    <small class="text-muted">
                        AzureWave Cruise Booking System
                    </small>
                </div>

                <div class="topbar-user">

                    <div class="topbar-avatar">
                        <i class="bi bi-person"></i>
                    </div>

                    <div class="text-end">
                        <strong>
                            {{ auth()->user()->name }}
                        </strong>

                        <br>

                        <span class="customer-badge">
                            Customer
                        </span>
                    </div>

                </div>

            </div>

            @yield('content')

            <footer class="customer-footer text-center mt-5 pt-3 border-top">
                © 2026 AzureWave Cruise Booking System
            </footer>

        </div>

    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const successMessage = @json(session('success'));
            const errorMessage = @json(session('error'));
            const validationErrors = @json($errors->all());

            if (successMessage) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: successMessage,
                    confirmButtonText: 'Okay',
                    confirmButtonColor: '#0077b6',
                    background: '#ffffff',
                    color: '#1f2937',
                    timer: 2500,
                    timerProgressBar: true
                });
            }

            if (errorMessage) {
                Swal.fire({
                    icon: 'error',
                    title: 'Action Failed',
                    text: errorMessage,
                    confirmButtonText: 'Okay',
                    confirmButtonColor: '#dc3545',
                    background: '#ffffff',
                    color: '#1f2937'
                });
            }

            if (validationErrors.length > 0) {
                let errorList = '<div style="text-align:left;"><ul style="margin-bottom:0;">';

                validationErrors.forEach(function (error) {
                    errorList += '<li>' + error + '</li>';
                });

                errorList += '</ul></div>';

                Swal.fire({
                    icon: 'warning',
                    title: 'Please Check Your Input',
                    html: errorList,
                    confirmButtonText: 'Fix Now',
                    confirmButtonColor: '#ffc107',
                    background: '#ffffff',
                    color: '#1f2937'
                });
            }

            document.querySelectorAll('.confirm-action').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const title = form.dataset.title || 'Are you sure?';
                    const text = form.dataset.text || 'This action cannot be undone.';
                    const icon = form.dataset.icon || 'warning';
                    const confirmText = form.dataset.confirmText || 'Yes, continue';
                    const confirmColor = form.dataset.confirmColor || '#dc3545';

                    Swal.fire({
                        title: title,
                        text: text,
                        icon: icon,
                        showCancelButton: true,
                        confirmButtonColor: confirmColor,
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: confirmText,
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        background: '#ffffff',
                        color: '#1f2937'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            HTMLFormElement.prototype.submit.call(form);
                        }
                    });
                });
            });

        });
    </script>

    @stack('scripts')

</body>

</html>