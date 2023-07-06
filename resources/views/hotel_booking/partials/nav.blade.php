<ul class="nav nav-tabs mb-3 d-print-none">

    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.service-request.home') }}"
            href="{{ route('rrhh.service-request.home') }}">
            <i class="fas fa-home"></i> Reservar
        </a>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{
            active('rrhh.service-request.fulfillment.index'),
            active('rrhh.service-request.report.fulfillment-pending')
        }}"
        data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-clipboard-check"></i> Administración
        </a>
        <div class="dropdown-menu">

            <a class="dropdown-item {{ active('hotel_booking.hotels.index') }}"
                href="{{ route('hotel_booking.hotels.index') }}">
                <i class="fas fa-clipboard-check"></i> Hoteles
            </a>

            <a class="dropdown-item {{ active('hotel_booking.rooms.index') }}"
                href="{{ route('hotel_booking.rooms.index') }}">
                <i class="fas fa-clipboard-check"></i> Habitaciones
            </a>

        </div>
    </li>

</ul>
