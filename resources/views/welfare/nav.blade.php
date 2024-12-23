<ul class="nav nav-tabs mb-3 d-print-none">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('welfare.index') }}">
            <i class="fas fa-home"></i> home
        </a>
    </li>

    @if(auth()->user()->can('welfare: balance') || auth()->user()->can('be god'))
        <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-balance-scale"></i> Balance </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    
                    <a class="dropdown-item" href="{{ route('welfare.dosfile.index') }}">
                        <i class="fas fa-file-upload"></i> Carga archivo DOS
                    </a>

                    <a class="dropdown-item" href="{{ route('welfare.balances') }}">
                        <i class="fas fa-balance-scale"></i> Balance
                    </a>

                    <a class="dropdown-item" href="{{ route('welfare.loans.index') }}">
                        <i class="fas fa-file-excel"></i> Carga Excel de préstamos
                    </a>

                    <a class="dropdown-item" href="{{ route('welfare.report') }}">
                        <i class="fas fa-chart-bar"></i> Gráficos
                    </a>
                </div>
        </li>
    @endif

    


    

    @if(auth()->user()->welfare || auth()->user()->can('be god') || auth()->user()->can('welfare: benefits') || auth()->user()->can('welfare: hotel booking administrator'))
        <!-- <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-hands-helping"></i> Beneficios </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    
                    <a class="dropdown-item" href="{{ route('welfare.benefits.requests') }}">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Mis solicitudes
                    </a>

                    @if(auth()->user()->can('welfare: benefits') || auth()->user()->can('be god'))

                        <a class="dropdown-item" href="{{ route('welfare.benefits.benefits') }}">
                            <i class="fas fa-plus-square"></i> Mantenedor de Categorías
                        </a>

                        <a class="dropdown-item" href="{{ route('welfare.benefits.subsidies') }}">
                            <i class="fas fa-plus-square"></i> Mantenedor de Beneficios
                        </a>

                        <a class="dropdown-item" href="{{ route('welfare.benefits.requests-admin') }}">
                            <i class="fa fa-users" aria-hidden="true"></i> Administrador de solicitudes
                        </a>

                    @endif

                </div>
        </li> -->

        <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bed"></i> Reserva de cabañas </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                    <a class="dropdown-item {{ active('hotel_booking.index') }}"
                        href="{{ route('hotel_booking.index') }}">
                        <i class="fas fa-home"></i> Reservar
                    </a>

                    <a class="dropdown-item {{ active('hotel_booking.my_bookings') }}"
                        href="{{ route('hotel_booking.my_bookings') }}">
                        <i class="fa fa-list"></i> Mis reservas
                    </a>

                    @canany(['welfare: hotel booking administrator'])

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item {{ active('hotel_booking.hotels.index') }}"
                            href="{{ route('hotel_booking.hotels.index') }}">
                            <i class="fa fa-building"></i> Recintos
                        </a>

                        <a class="dropdown-item {{ active('hotel_booking.rooms.index') }}"
                            href="{{ route('hotel_booking.rooms.index') }}">
                            <i class="fa fa-bed"></i> Hospedajes
                        </a>

                        <a class="dropdown-item {{ active('hotel_booking.room_booking_configuration.index') }}"
                            href="{{ route('hotel_booking.room_booking_configuration.index') }}">
                            <i class="fas fa-clipboard-check"></i> Configuración Hospedaje
                        </a>

                        <a class="dropdown-item {{ active('hotel_booking.services.index') }}"
                            href="{{ route('hotel_booking.services.index') }}">
                            <i class="fas fa-clipboard-check"></i> Servicios
                        </a>

                        <a class="dropdown-item {{ active('hotel_booking.booking_admin') }}"
                            href="{{ route('hotel_booking.booking_admin') }}">
                            <i class="fa fa-list"></i> Administrador de reservas
                        </a>

                        <div class="dropdown-divider"></div>
                        
                        <a class="dropdown-item {{ active('hotel_booking.reports.discount_sheet') }}"
                            href="{{ route('hotel_booking.reports.discount_sheet') }}">
                            <i class="fa fa-chart-bar"></i> Planilla de descuentos 
                        </a>
                    @endcanany

                </div>
        </li>
    @endif





    @if(auth()->user()->can('welfare: amipass') || auth()->user()->can('be god'))
        <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-file-invoice"></i> Gestor Amipass</a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                <a class="dropdown-item" href="{{ route('welfare.amipass.upload') }}">
                    <i class="fas fa-file-upload"></i> Carga Archivos
                </a>

                <a class="dropdown-item" href="{{ route('welfare.amipass.shifts-index') }}">
                    <i class="fas fa-list"></i> Carga Turnos
                </a>

                <a class="dropdown-item" href="{{ route('welfare.amipass.dashboard') }}">
                    <i class="fas fa-file-upload"></i> Dashboard
                </a>

                <a class="dropdown-item" href="{{ route('welfare.amipass.value.indexValue') }}">
                    <i class="fas fa-calendar-alt"></i> Valor de Carga Amipass Anual
                </a>
                
                <a class="dropdown-item" href="{{ route('welfare.amipass.report-by-dates') }}">
                    <i class="fas fa-calendar-alt"></i> Reporte por mes
                </a>

                <a class="dropdown-item" href="{{ route('welfare.amipass.report-by-employee') }}">
                    <i class="fas fa-calendar-alt"></i> Reporte por funcionario
                </a>
            </div>
        </li>
    @endif




    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-file-invoice"></i> Mi Amipass</a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                <a class="dropdown-item" href="{{ route('welfare.amipass.mi-amipass') }}">
                    <i class="fas fa-utensils"></i> Mi Amipass
                </a>

                <a class="dropdown-item" href="{{ route('welfare.amipass.requests-manager') }}">
                    <i class="fas fa-utensils"></i> Solicitudes Amipass
                </a>

                <a class="dropdown-item" href="{{ route('welfare.amipass.question-all-index') }}">
                    <i class="fas fa-question-circle"></i> Consultas/Sugerencia Amipass
                </a>
            </div>
    </li>

    </ul>
