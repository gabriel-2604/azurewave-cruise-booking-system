<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AzureWave | Customer Login</title>

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
                linear-gradient(rgba(2, 45, 87, 0.78), rgba(2, 83, 120, 0.70)),
                url("{{ asset('images/hero.jpg') }}");
            background-size: cover;
            background-position: center;
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

        .auth-wrapper {
            width: 100%;
            max-width: 1050px;
        }

        .auth-card {
            border: none;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.35);
            background: rgba(255, 255, 255, 0.95);
        }

        .auth-left {
            background:
                linear-gradient(160deg, rgba(0, 119, 182, 0.95), rgba(0, 180, 216, 0.82)),
                url("{{ asset('images/hero.jpg') }}");
            background-size: cover;
            background-position: center;
            color: white;
            padding: 55px 45px;
            min-height: 580px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-logo-wrap {
            width: 76px;
            height: 76px;
            border-radius: 24px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-bottom: 25px;
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.22);
            flex-shrink: 0;
        }

        .brand-logo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .brand-logo-fallback {
            width: 100%;
            height: 100%;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }

        .auth-left h1 {
            font-weight: 900;
            font-size: 42px;
            line-height: 1.15;
        }

        .auth-left p {
            font-size: 16px;
            opacity: 0.95;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 18px;
            font-weight: 600;
        }

        .feature-item i {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.22);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-right {
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
            font-weight: 900;
            color: #023e8a;
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
            border-color: #00b4d8;
            box-shadow: 0 0 0 0.2rem rgba(0, 180, 216, 0.15);
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

        .btn-auth {
            border: none;
            border-radius: 16px;
            padding: 14px;
            font-weight: 800;
            color: white;
            background: linear-gradient(135deg, #0077b6, #00b4d8);
            box-shadow: 0 12px 25px rgba(0, 119, 182, 0.3);
        }

        .btn-auth:hover {
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
            .auth-left {
                min-height: auto;
                padding: 40px 30px;
            }

            .auth-right {
                padding: 40px 30px;
            }

            .auth-left h1 {
                font-size: 32px;
            }
        }

        @media (max-width: 576px) {
            body {
                align-items: flex-start;
            }

            .back-home {
                position: static;
                width: 100%;
                justify-content: center;
                margin-bottom: 18px;
            }
        }
    </style>
</head>

<body>

    <a href="{{ route('home') }}" class="back-home">
        <i class="bi bi-arrow-left"></i>
        Back to Home
    </a>

    <div class="auth-wrapper">

        <div class="card auth-card">

            <div class="row g-0">

                <div class="col-lg-6 auth-left">

                    <div class="brand-logo-wrap">
                        <img src="{{ asset('images/logo.png') }}"
                             alt="AzureWave Logo"
                             class="brand-logo"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                        <div class="brand-logo-fallback">
                            🚢
                        </div>
                    </div>

                    <h1>
                        Welcome Back, Traveler!
                    </h1>

                    <p class="mt-3 mb-4">
                        Log in to manage your cruise bookings, view your event calendar, and track your reservation status.
                    </p>

                    <div class="feature-item">
                        <i class="bi bi-calendar-check"></i>
                        Manage cruise bookings
                    </div>

                    <div class="feature-item">
                        <i class="bi bi-shield-check"></i>
                        Secure customer account
                    </div>

                    <div class="feature-item">
                        <i class="bi bi-water"></i>
                        Explore available cruise schedules
                    </div>

                </div>

                <div class="col-lg-6 auth-right">

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
                            Customer Login
                        </h2>

                        <p class="text-muted mb-0">
                            Sign in to continue to your AzureWave account.
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
                            Please check your email and password.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('customer.login.store') }}">

                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Email Address
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>

                                <input type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       class="form-control"
                                       placeholder="Enter your email"
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
                                       placeholder="Enter your password"
                                       required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-auth w-100 mt-3">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Login
                        </button>

                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted mb-0">
                            Don’t have an account?

                            <a href="{{ route('customer.register') }}" class="auth-link">
                                Create account
                            </a>
                        </p>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ route('admin.login') }}" class="auth-link">
                            Login as Admin
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>