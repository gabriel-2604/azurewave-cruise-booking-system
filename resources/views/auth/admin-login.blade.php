<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AzureWave | Admin Login</title>

    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(0, 180, 216, 0.35), transparent 35%),
                linear-gradient(135deg, #03045e, #023e8a 45%, #0077b6);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
            overflow-x: hidden;
        }

        .back-home {
            position: fixed;
            top: 25px;
            left: 25px;
            color: white;
            text-decoration: none;
            font-weight: 700;
            z-index: 10;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .back-home:hover {
            color: #caf0f8;
        }

        .admin-auth-wrapper {
            width: 100%;
            max-width: 980px;
        }

        .admin-auth-card {
            border: none;
            border-radius: 30px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 30px 90px rgba(0, 0, 0, 0.45);
        }

        .admin-left {
            background:
                linear-gradient(160deg, rgba(3, 4, 94, 0.92), rgba(0, 119, 182, 0.82)),
                url("{{ asset('images/hero.jpg') }}");
            background-size: cover;
            background-position: center;
            color: white;
            padding: 55px 45px;
            min-height: 560px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
            padding: 9px 16px;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.18);
            font-weight: 700;
            margin-bottom: 25px;
            backdrop-filter: blur(8px);
        }

        .admin-left h1 {
            font-size: 42px;
            font-weight: 900;
            line-height: 1.15;
        }

        .admin-left p {
            font-size: 16px;
            opacity: 0.95;
        }

        .admin-feature {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 18px;
            font-weight: 600;
        }

        .admin-feature i {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.22);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .admin-right {
            padding: 55px 45px;
        }

        .auth-logo-wrap {
            width: 86px;
            height: 86px;
            border-radius: 28px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0 auto 18px;
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.18);
        }

        .auth-logo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .auth-logo-fallback {
            width: 100%;
            height: 100%;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 42px;
        }

        .auth-title {
            color: #023e8a;
            font-weight: 900;
        }

        .form-label {
            font-weight: 700;
            color: #344767;
        }

        .form-control {
            border-radius: 14px;
            padding: 13px 15px;
            border: 1px solid #dbe4ef;
        }

        .form-control:focus {
            border-color: #0077b6;
            box-shadow: 0 0 0 0.2rem rgba(0, 119, 182, 0.16);
        }

        .input-group-text {
            border-radius: 14px 0 0 14px;
            background: #f4fbff;
            border: 1px solid #dbe4ef;
            color: #0077b6;
        }

        .input-group .form-control {
            border-radius: 0 14px 14px 0;
        }

        .btn-admin {
            border: none;
            border-radius: 16px;
            padding: 14px;
            font-weight: 800;
            color: white;
            background: linear-gradient(135deg, #03045e, #0077b6);
            box-shadow: 0 12px 25px rgba(3, 4, 94, 0.3);
        }

        .btn-admin:hover {
            color: white;
            background: linear-gradient(135deg, #023e8a, #0096c7);
        }

        .auth-link {
            color: #0077b6;
            font-weight: 800;
            text-decoration: none;
        }

        .auth-link:hover {
            color: #023e8a;
            text-decoration: underline;
        }

        .alert {
            border-radius: 16px;
            font-weight: 600;
        }

        @media (max-width: 991px) {
            .admin-left {
                min-height: auto;
                padding: 40px 30px;
            }

            .admin-right {
                padding: 40px 30px;
            }

            .admin-left h1 {
                font-size: 32px;
            }
        }

        @media (max-width: 576px) {
            .back-home {
                position: static;
                margin-bottom: 18px;
                justify-content: center;
                width: 100%;
            }

            body {
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    <a href="{{ route('home') }}" class="back-home">
        <i class="bi bi-arrow-left"></i>
        Back to Home
    </a>

    <div class="admin-auth-wrapper">

        <div class="card admin-auth-card">

            <div class="row g-0">

                <div class="col-lg-6 admin-left">

                    <div class="admin-badge">
                        <i class="bi bi-shield-lock"></i>
                        Admin Portal
                    </div>

                    <h1>
                        Manage AzureWave Cruises
                    </h1>

                    <p class="mt-3 mb-4">
                        Access the admin dashboard to manage cruises, bookings, customers, reports, and event calendar schedules.
                    </p>

                    <div class="admin-feature">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard monitoring
                    </div>

                    <div class="admin-feature">
                        <i class="bi bi-calendar-check"></i>
                        Booking approval management
                    </div>

                    <div class="admin-feature">
                        <i class="bi bi-graph-up-arrow"></i>
                        Reports and activity tracking
                    </div>

                </div>

                <div class="col-lg-6 admin-right">

                    <div class="auth-logo-wrap">
                        <img src="{{ asset('images/logo.png') }}"
                             alt="AzureWave Logo"
                             class="auth-logo"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                        <div class="auth-logo-fallback">
                            🚢
                        </div>
                    </div>

                    <div class="mb-4 text-center">
                        <h2 class="auth-title mb-2">
                            Admin Login
                        </h2>

                        <p class="text-muted mb-0">
                            Sign in using your administrator account.
                        </p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <strong>Login failed.</strong>
                            Please check your admin credentials.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.store') }}">

                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Admin Email
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>

                                <input type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       class="form-control"
                                       placeholder="Enter admin email"
                                       required
                                       autofocus>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Password
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>

                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       placeholder="Enter password"
                                       required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-admin w-100 mt-3">
                            <i class="bi bi-shield-check"></i>
                            Login as Admin
                        </button>

                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('customer.login') }}" class="auth-link">
                            Login as Customer
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>