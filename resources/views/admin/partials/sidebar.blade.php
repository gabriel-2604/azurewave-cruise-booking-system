<aside class="admin-sidebar">

    <div class="admin-sidebar-brand">

        <a href="{{ route('admin.dashboard') }}" class="admin-brand-link">

            <div class="admin-logo-wrap">

                <img src="{{ asset('images/logo.png') }}"
                     alt="AzureWave Logo"
                     class="admin-logo"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                <div class="admin-logo-fallback">
                    🛳️
                </div>

            </div>

            <div class="admin-brand-text">
                <h4>
                    AzureWave
                </h4>

                <small>
                    Admin Panel
                </small>
            </div>

        </a>

    </div>

    <div class="admin-user-card">

        <div class="admin-user-avatar">
            <i class="bi bi-shield-lock"></i>
        </div>

        <div>
            <h6 class="mb-0">
                {{ auth()->user()->name }}
            </h6>

            <small>
                Administrator
            </small>
        </div>

    </div>

    <div class="admin-menu-label">
        COMMAND CENTER
    </div>

    <ul class="admin-menu">

        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                <i class="bi bi-speedometer2"></i>

                <span>
                    Dashboard
                </span>

            </a>
        </li>

        <li>
            <a href="{{ route('cruises.index') }}"
               class="{{ request()->routeIs('cruises.*') ? 'active' : '' }}">

                <i class="bi bi-water"></i>

                <span>
                    Cruise Management
                </span>

            </a>
        </li>

        <li>
            <a href="{{ route('bookings.index') }}"
               class="{{ request()->routeIs('bookings.*') ? 'active' : '' }}">

                <i class="bi bi-calendar-check"></i>

                <span>
                    Booking Management
                </span>

            </a>
        </li>

        <li>
            <a href="{{ route('booking_logs.index') }}"
               class="{{ request()->routeIs('booking_logs.*') ? 'active' : '' }}">

                <i class="bi bi-clock-history"></i>

                <span>
                    Booking Logs
                </span>

            </a>
        </li>

        <li>
            <a href="{{ route('customers.index') }}"
               class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">

                <i class="bi bi-people"></i>

                <span>
                    Customer Management
                </span>

            </a>
        </li>

        <li>
            <a href="{{ route('calendar.index') }}"
               class="{{ request()->routeIs('calendar.*') ? 'active' : '' }}">

                <i class="bi bi-calendar3"></i>

                <span>
                    Event Calendar
                </span>

            </a>
        </li>

        <li>
            <a href="{{ route('reports.index') }}"
               class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">

                <i class="bi bi-file-earmark-bar-graph"></i>

                <span>
                    Reports
                </span>

            </a>
        </li>

    </ul>

    <div class="admin-sidebar-footer">

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button type="submit" class="admin-logout-btn">

                <i class="bi bi-box-arrow-right"></i>

                <span>
                    Logout
                </span>

            </button>

        </form>

    </div>

</aside>