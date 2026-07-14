<div class="d-flex justify-content-between align-items-center">

    <div>

        <h3 class="fw-bold mb-0">

            @yield('title')

        </h3>

        <small class="text-muted">

            AzureWave Cruise Booking System

        </small>

    </div>

    <div class="d-flex align-items-center">

        <div class="me-4 text-end">

            <strong>

                {{ auth()->user()->name }}

            </strong>

            <br>

            <small class="text-muted">

                Administrator

            </small>

        </div>

        <div class="fs-3">

            <i class="bi bi-person-circle"></i>

        </div>

    </div>

</div>