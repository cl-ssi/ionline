<ul class="nav nav-tabs mb-3 d-print-none">

    <li class="nav-item">
        <a class="nav-link {{ active('hotel_booking.index') }}"
            href="{{ route('hotel_booking.index') }}">
            <i class="fas fa-home"></i> Reservar
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('hotel_booking.my_bookings') }}"
            href="{{ route('hotel_booking.my_bookings') }}">
            <i class="fa fa-list"></i> Reservas
        </a>
    </li>

    @canany(['HotelBooking: Administrador'])
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{
                active('hotel_booking.hotels.index'),
                active('hotel_booking.rooms.index'),
                active('hotel_booking.room_booking_configuration.index')
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
                    <i class="fas fa-clipboard-check"></i> Hospedajes
                </a>

                <a class="dropdown-item {{ active('hotel_booking.room_booking_configuration.index') }}"
                    href="{{ route('hotel_booking.room_booking_configuration.index') }}">
                    <i class="fas fa-clipboard-check"></i> Configuración Habitación
                </a>

            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{
                active('hotel_booking.services.*')
            }}"
            data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-clipboard-check"></i> Mantenedores
            </a>
            <div class="dropdown-menu">

                <a class="dropdown-item {{ active('hotel_booking.services.index') }}"
                    href="{{ route('hotel_booking.services.index') }}">
                    <i class="fas fa-clipboard-check"></i> Servicios
                </a>

            </div>
        </li>
    @endcanany


</ul>
