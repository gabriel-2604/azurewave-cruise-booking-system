<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AzureWave Cruise Booking System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .home-logo-wrap {
    width: 46px;
    height: 46px;
    border-radius: 16px;
    background: white;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.15);
    flex-shrink: 0;
}

.home-logo {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.home-logo-fallback {
    width: 100%;
    height: 100%;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

        body {
            margin: 0;
            min-height: 100vh;
            background: #f4f9ff;
            overflow-x: hidden;
        }

        .hero-section {
            min-height: 100vh;
            background:
                linear-gradient(120deg, rgba(2, 62, 138, 0.88), rgba(0, 180, 216, 0.65)),
                url("{{ asset('images/hero.jpg') }}");
            background-size: cover;
            background-position: center;
            position: relative;
            color: white;
            display: flex;
            align-items: center;
        }

        .hero-section::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 170px;
            background: linear-gradient(to top, #f4f9ff, transparent);
        }

        .navbar-custom {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 10;
            padding: 24px 0;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
        }

        .brand-icon {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            backdrop-filter: blur(8px);
        }

        .brand-text h4 {
            font-weight: 800;
            margin: 0;
        }

        .brand-text small {
            opacity: 0.9;
        }

        .nav-actions .btn {
            border-radius: 50px;
            padding: 10px 18px;
            font-weight: 700;
        }

        .hero-content {
            position: relative;
            z-index: 5;
            padding-top: 80px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(8px);
            font-weight: 600;
            margin-bottom: 22px;
        }

        .hero-title {
            font-size: clamp(42px, 6vw, 78px);
            font-weight: 900;
            line-height: 1.08;
            margin-bottom: 20px;
        }

        .hero-title span {
            color: #ffd60a;
        }

        .hero-subtitle {
            font-size: 18px;
            max-width: 650px;
            opacity: 0.95;
            margin-bottom: 35px;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn-main {
            border: none;
            border-radius: 18px;
            padding: 14px 24px;
            font-weight: 800;
            color: #023e8a;
            background: #ffd60a;
            box-shadow: 0 14px 30px rgba(255, 214, 10, 0.35);
        }

        .btn-main:hover {
            color: #023e8a;
            background: #ffea00;
        }

        .btn-glass {
            border: 1px solid rgba(255, 255, 255, 0.45);
            border-radius: 18px;
            padding: 14px 24px;
            font-weight: 800;
            color: white;
            background: rgba(255, 255, 255, 0.16);
            backdrop-filter: blur(8px);
        }

        .btn-glass:hover {
            color: #023e8a;
            background: white;
        }

        .hero-card {
            position: relative;
            z-index: 5;
            background: rgba(255, 255, 255, 0.94);
            color: #1f2937;
            border-radius: 30px;
            padding: 30px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.28);
        }

        .hero-card-icon {
            width: 70px;
            height: 70px;
            border-radius: 22px;
            background: linear-gradient(135deg, #0077b6, #00b4d8);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            margin-bottom: 20px;
        }

        .feature-list {
            margin-top: 22px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .feature-item i {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #e6f7ff;
            color: #0077b6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stats-section {
            position: relative;
            z-index: 6;
            margin-top: -95px;
            padding-bottom: 60px;
        }

        .stat-card {
            border: none;
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 18px 45px rgba(2, 62, 138, 0.12);
            height: 100%;
        }

        .stat-card i {
            font-size: 34px;
            color: #0077b6;
        }

        .stat-card h3 {
            font-weight: 900;
            margin: 12px 0 5px;
            color: #023e8a;
        }

        .stat-card p {
            color: #6b7280;
            margin: 0;
            font-weight: 500;
        }

        @media (max-width: 991px) {
            .hero-section {
                padding: 130px 0 170px;
            }

            .navbar-custom {
                padding: 18px 0;
            }

            .nav-actions {
                margin-top: 15px;
            }

            .hero-card {
                margin-top: 45px;
            }

            .stats-section {
                margin-top: -70px;
            }
        }

        @media (max-width: 576px) {
            .nav-actions {
                display: flex;
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }

            .nav-actions .btn {
                width: 100%;
            }

            .hero-buttons .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<section class="hero-section">

    <nav class="navbar-custom">

        <div class="container">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                            <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center gap-2 fw-bold">
                              <span class="home-logo-wrap">
                                <img src="{{ asset('images/logo.png') }}"
                              alt="AzureWave Logo"
                              class="home-logo"
                              onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                             <span class="home-logo-fallback">
                            🚢
                          </span>
                        </span>

                     <span>AzureWave</span>
                </a>

                <div class="nav-actions d-flex gap-2">

                    <a href="{{ route('customer.login') }}" class="btn btn-light">
                        <i class="bi bi-person-circle"></i>
                        Customer Login
                    </a>

                    <a href="{{ route('customer.register') }}" class="btn btn-warning">
                        <i class="bi bi-person-plus"></i>
                        Register
                    </a>

                    <a href="{{ route('admin.login') }}" class="btn btn-dark">
                        <i class="bi bi-shield-lock"></i>
                        Admin Login
                    </a>

                </div>

            </div>

        </div>

    </nav>

    <div class="container hero-content">

        <div class="row align-items-center">

            <div class="col-lg-7">

                <div class="hero-badge">
                    <i class="bi bi-stars"></i>
                    Book your next ocean adventure
                </div>

                <h1 class="hero-title">
                    Cruise Ship Booking <span>Management System</span>
                </h1>

                <p class="hero-subtitle">
                    A modern cruise reservation platform for customers and administrators.
                    Manage bookings, check event calendars, monitor available schedules,
                    and prevent double booking with ease.
                </p>

                <div class="hero-buttons">

                    <a href="{{ route('customer.login') }}" class="btn btn-main">
                        <i class="bi bi-calendar-check"></i>
                        Book a Cruise
                    </a>

                    <a href="{{ route('customer.register') }}" class="btn btn-glass">
                        <i class="bi bi-person-plus"></i>
                        Create Account
                    </a>

                    <a href="{{ route('admin.login') }}" class="btn btn-glass">
                        <i class="bi bi-shield-lock"></i>
                        Admin Portal
                    </a>

                </div>

            </div>

            <div class="col-lg-5">

                <div class="hero-card">

                    <div class="hero-card-icon">
                        <i class="bi bi-calendar2-check"></i>
                    </div>

                    <h3 class="fw-bold mb-2">
                        Smart Booking Control
                    </h3>

                    <p class="text-muted mb-0">
                        Track cruise bookings, available dates, customer reservations,
                        and booking statuses from one organized system.
                    </p>

                    <div class="feature-list">

                        <div class="feature-item">
                            <i class="bi bi-check-lg"></i>
                            Customer and admin login
                        </div>

                        <div class="feature-item">
                            <i class="bi bi-check-lg"></i>
                            Event calendar booking view
                        </div>

                        <div class="feature-item">
                            <i class="bi bi-check-lg"></i>
                            Prevent double booking
                        </div>

                        <div class="feature-item">
                            <i class="bi bi-check-lg"></i>
                            Booking logs and reports
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<section class="stats-section">

    <div class="container">

        <div class="row g-4">

            <div class="col-lg-3 col-md-6">

                <div class="card stat-card">

                    <i class="bi bi-calendar-check"></i>

                    <h3>
                        Booking
                    </h3>

                    <p>
                        Create and manage cruise reservations.
                    </p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="card stat-card">

                    <i class="bi bi-calendar3"></i>

                    <h3>
                        Calendar
                    </h3>

                    <p>
                        View booked and available schedules.
                    </p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="card stat-card">

                    <i class="bi bi-people"></i>

                    <h3>
                        Customers
                    </h3>

                    <p>
                        Manage customer accounts and bookings.
                    </p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="card stat-card">

                    <i class="bi bi-file-earmark-bar-graph"></i>

                    <h3>
                        Reports
                    </h3>

                    <p>
                        Monitor booking activity and system data.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

</body>
</html>