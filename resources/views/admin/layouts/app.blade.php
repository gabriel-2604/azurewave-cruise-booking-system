<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AzureWave | @yield('title', 'Admin Panel')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f8fb;
            color: #1f2937;
            overflow-x: hidden;
        }

        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 295px;
            height: 100vh;
            background:
                radial-gradient(circle at top right, rgba(255, 214, 10, 0.18), transparent 28%),
                linear-gradient(180deg, rgba(3, 4, 94, 0.98), rgba(2, 62, 138, 0.97), rgba(0, 119, 182, 0.95)),
                url("{{ asset('images/hero.jpg') }}");
            background-size: cover;
            background-position: center;
            color: white;
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            box-shadow: 14px 0 38px rgba(3, 4, 94, 0.22);
        }

        .admin-sidebar-brand {
            margin-bottom: 22px;
        }

        .admin-brand-link {
            display: flex;
            align-items: center;
            gap: 14px;
            color: white;
            text-decoration: none;
        }

        .admin-brand-link:hover {
            color: white;
        }

        .admin-logo-wrap {
            width: 64px;
            height: 64px;
            border-radius: 23px;
            background: rgba(255, 255, 255, 0.16);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            backdrop-filter: blur(10px);
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.20);
            flex-shrink: 0;
        }

        .admin-logo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .admin-logo-fallback {
            width: 100%;
            height: 100%;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 34px;
        }

        .admin-brand-text h4 {
            font-weight: 900;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .admin-brand-text small {
            opacity: 0.82;
            font-weight: 600;
        }

        .admin-user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(10px);
            margin-bottom: 24px;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .admin-user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 17px;
            background: rgba(255, 214, 10, 0.25);
            color: #ffd60a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .admin-user-card h6 {
            font-weight: 800;
            color: white;
        }

        .admin-user-card small {
            color: rgba(255, 255, 255, 0.78);
            font-size: 12px;
        }

        .admin-menu-label {
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 1.4px;
            color: rgba(255, 255, 255, 0.65);
            margin: 0 0 12px 12px;
        }

        .admin-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex: 1;
        }

        .admin-menu li {
            margin-bottom: 8px;
        }

        .admin-menu a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 14px;
            border-radius: 18px;
            color: rgba(255, 255, 255, 0.86);
            text-decoration: none;
            font-weight: 750;
            transition: 0.22s ease;
        }

        .admin-menu a i {
            width: 24px;
            font-size: 20px;
            text-align: center;
        }

        .admin-menu a:hover {
            color: white;
            background: rgba(255, 255, 255, 0.14);
            transform: translateX(5px);
        }

        .admin-menu a.active {
            color: #03045e;
            background: #ffffff;
            box-shadow: 0 14px 30px rgba(255, 255, 255, 0.18);
        }

        .admin-menu a.active i {
            color: #0077b6;
        }

        .admin-sidebar-footer {
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.16);
        }

        .admin-logout-btn {
            width: 100%;
            border: none;
            border-radius: 18px;
            padding: 13px 14px;
            background: linear-gradient(135deg, #dc3545, #b42318);
            color: white;
            font-weight: 850;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: 0.22s ease;
        }

        .admin-logout-btn:hover {
            background: linear-gradient(135deg, #b42318, #7f1d1d);
            transform: translateY(-2px);
        }

        .main-content {
            margin-left: 295px;
            min-height: 100vh;
        }

        .content-wrapper {
            padding: 24px;
            min-height: 100vh;
        }

        .topbar {
            margin-bottom: 24px;
        }

        footer,
        .footer {
            margin-top: 30px;
        }

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

        @media (max-width: 991px) {
            .admin-sidebar {
                position: relative;
                width: 100%;
                height: auto;
                border-radius: 0 0 28px 28px;
            }

            .admin-menu {
                flex: unset;
            }

            .main-content {
                margin-left: 0;
            }

            .content-wrapper {
                padding: 18px;
            }
        }

        @media (max-width: 576px) {
            .admin-sidebar {
                padding: 20px 14px;
            }

            .admin-brand-link {
                justify-content: center;
                text-align: center;
                flex-direction: column;
            }

            .admin-user-card {
                justify-content: center;
                text-align: center;
            }

            .admin-menu a {
                justify-content: center;
            }

            .content-wrapper {
                padding: 14px;
            }
        }
    </style>

    {{-- Extra Page Styles --}}
    @stack('styles')
</head>

<body>

    @include('admin.partials.sidebar')

    <div class="main-content">

        <div class="content-wrapper">

            <div class="topbar">
                @include('admin.partials.navbar')
            </div>

            @yield('content')

            @include('admin.partials.footer')

        </div>

    </div>

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
                            form.submit();
                        }
                    });
                });
            });

        });
    </script>

    {{-- Extra Page Scripts --}}
    @stack('scripts')

</body>

</html>