<nav class="navbar navbar-expand-md navbar-dark shadow-sm bg-nav-gobierno">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('rrhh.users.directory') }}">
                        <i class="fas fa-address-book" title="Teléfonos"></i>
                    </a>
                </li>

                <li class="nav-item {{ active('calendars') }}">
                    <a class="nav-link" href="{{ route('calendars') }}">
                        <i class="fas fa-calendar-alt" title="Calendarios"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-chart-line"></i> Estadísticas
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item"
                           href="{{ route('indicators.index') }}">
                            <i class="fas fa-desktop fa-fw"></i> Indicadores - REM
                        </a>

                        <a class="dropdown-item"
                           href="{{ route('indicators.population') }}">
                            <i class="fas fa-globe-americas"></i> Tablero de población
                        </a>

                        @can('Programming: view')
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"
                           href="{{ route('programmings.index') }}">
                            <i class="fas fa-calculator"></i> Programación Numérica
                        </a>

                        <a class="dropdown-item"
                           href="{{ route('communefiles.index') }}">
                            <i class="fas fa-file-alt"></i> Documentos Comunales
                        </a>
                        @endcan

                        {{--@auth
                            @canany(['LE Extra Plan: Carga','LE Extra Plan: Monitoreo'])
                                <a class="dropdown-item"
                                   href="{{ route('le_extra_plans.index') }}">
                                    <i class="far fa-file-alt"></i> LE Plan Extraordinario
                                </a>
                            @endcan
                        @endauth--}}
                    </div>
                </li>

                @auth
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-file-alt"></i> Docs
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                    @canany(['Documents: create','Documents: edit','Documents: add number', 'Documents: dev'])
                    <a class="dropdown-item"
                        href="{{ route('documents.index') }}">
                        <i class="fas fa-pen"></i> Generador de documentos
                    </a>
                    @endcan

                    @canany(['Documents: signatures and distribution'])
                      <a class="dropdown-item"
                          href="{{ route('documents.signatures.index', ['pendientes']) }}">
                          <i class="fas fa-signature"></i> Solicitud de firmas
                      </a>
                    @endcan

                    @canany(['Partes: oficina','Partes: user','Partes: director'])
                    <a class="dropdown-item"
                        href="{{ route('documents.partes.index') }}">
                        <i class="fas fa-file-import"></i> Partes
                    </a>
                    @endcan

                    @can('Agreement: view')
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item"
                        href="{{ route('agreements.tracking.index') }}">
                        <i class="fas fa-file"></i> Convenios
                    </a>
                    @endcan

                    <a class="dropdown-item"
                        href="{{ route('quality_aps.index') }}">
                        <i class="fas fa-file-alt"></i> Acreditación de Calidad
                    </a>

                    <a class="dropdown-item"
                        href="{{ route('health_plan.index', ['iquique']) }}">
                        <i class="fas fa-file-powerpoint"></i> Planes Comunales
                    </a>
                    </div>
                </li>
                @if(Auth()->user()->organizationalUnit && Auth()->user()->organizationalUnit->establishment_id == 38)
                <li class="nav-item {{ active('request_forms') }}">
                    <a class="nav-link" href="{{ route('request_forms.my_forms') }}">
                        <i class="fas fa-shopping-cart"></i> Abastecimiento
                    </a>
                </li>
                @endif
                @endauth

                @can('Requirements: create')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('requirements.outbox') }}">
                      <i class="fas fa-rocket"></i> SGR
                      <span class="badge badge-secondary">{{ App\Requirements\Requirement::getPendingRequirements() }}</span>
                    </a>
                </li>
                @endcan

                @canany(['Users: create', 'Users: edit','Users: delete',
                    'OrganizationalUnits: create',
                    'OrganizationalUnits: edit',
                    'OrganizationalUnits: delete',
                    'Authorities: view',
                    'Authorities: create',
                    'Users: service requests',
                    'Service Request',
                    'Replacement Staff: create request',
                    'Replacement Staff: view requests'])
                <li class="nav-item dropdown @active(['rrhh.users.*','rrhh.organizationalUnits.*']">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-users"></i> RRHH
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        @canany(['Users: create', 'Users: edit','Users: delete'])
                        <a class="dropdown-item @active('rrhh.users.index')"
                            href="{{ route('rrhh.users.index') }}">
                            <i class="fas fa-user fa-fw"></i> Usuarios
                        </a>
                        @endcan

                        @canany(['OrganizationalUnits: create', 'OrganizationalUnits: edit', 'OrganizationalUnits: delete'])
                            <a class="dropdown-item"
                               href="{{ route('rrhh.organizational-units.index') }}">
                                <i class="fas fa-sitemap fa-fw"></i> Unidades organizacionales
                            </a>
                        @endcan



                        @canany(['Authorities: view', 'Authorities: create'])
                            <a class="dropdown-item"
                               href="{{ route('rrhh.authorities.index') }}">
                                <i class="fas fa-chess-king fa-fw"></i> Autoridades
                            </a>
                        @endcan

                        <div class="dropdown-divider"></div>

                        @can('Suitability: ssi')
                            <a class="dropdown-item"
                               href="{{ route('suitability.own') }}">
                                <i class="fas fa-chalkboard-teacher"></i> Idoneidad
                            </a>
                        @endcan


                        @canany(['Service Request'])
                        <a class="dropdown-item"
                            href="{{ route('rrhh.service-request.home') }}">
                            <i class="fas fa-child fa-fw"></i> Contratación Honorarios
                        </a>
                        @endcan

                        @canany(['Service Request: export sirh mantenedores'])
                        <a class="dropdown-item"
                            href="{{ route('parameters.professions.index') }}">
                            <i class="fas fa-child fa-chevron-right"></i> Mantenedor de profesiones
                        </a>

                        <a class="dropdown-item"
                           href="{{ route('rrhh.organizational-units.index') }}">
                            <i class="fas fa-sitemap fa-chevron-right"></i> Unidades organizacionales
                        </a>
                        @endcan

                        @canany(['Shift Management: view'])
                        <a class="dropdown-item @active('rrhh.users.index')"
                            href="{{ route('rrhh.shiftManag.index') }}">
                            <i class="fa fa-calendar fa-fw"></i> Modulo Turnos
                        </a>
                        @endcan

                        @canany(['Users: service requests'])
                        <a class="dropdown-item @active('rrhh.users.service_requests.index')"
                            href="{{ route('rrhh.users.service_requests.index') }}">
                            <i class="fas fa-user fa-fw"></i> Usuarios - Contrat. de Servicios
                        </a>
                        @endcan

                        {{-- @if(Auth::user()->hasRole('Replacement Staff: admin'))
                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item @active('replacement_staff.request.index')"
                               href="{{ route('replacement_staff.request.index') }}">
                                <i class="far fa-id-card"></i> Solicitudes de Contratación
                            </a>
                        @endif --}}

                        @if(Auth::user()->hasRole('Replacement Staff: user rys'))
                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item @active('replacement_staff.request.assign_index')"
                               href="{{ route('replacement_staff.request.assign_index') }}">
                                <i class="far fa-id-card"></i> Solicitudes de Contratación
                            </a>
                        @endif

                        @if(Auth::user()->hasRole('Replacement Staff: user') ||
                            App\Rrhh\Authority::getAmIAuthorityFromOu(Carbon\Carbon::now(), 'manager', Auth::user()->id) ||
                            Auth::user()->hasRole('Replacement Staff: personal') ||
                            Auth::user()->hasRole('Replacement Staff: personal sign') ||
                            Auth::user()->hasRole('Replacement Staff: admin'))

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item @active('replacement_staff.request.own_index')"
                               href="{{ route('replacement_staff.request.own_index') }}">
                                <i class="far fa-id-card"></i> Solicitudes de Contratación
                                @if(App\Models\ReplacementStaff\RequestReplacementStaff::getPendingRequestToSign() > 0)
                                    <span class="badge badge-secondary">{{ App\Models\ReplacementStaff\RequestReplacementStaff::getPendingRequestToSign() }} </span>
                                @endif
                            </a>
                        @endif

                        {{-- @if(Auth::user()->hasRole('Replacement Staff: personal') || Auth::user()->hasRole('Replacement Staff: personal sign'))
                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item @active('replacement_staff.request.personal_index')"
                               href="{{ route('replacement_staff.request.personal_index') }}">
                                <i class="far fa-id-card"></i> Solicitudes de Contratación
                            </a>
                        @endif --}}
                    </div>

                </li>
                @endcan

                @can('Drugs')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('drugs.receptions.index') }}">
                        <i class="fas fa-cannabis"></i> Drogas</a>
                </li>
                @endcan

                @canany(['Asignacion Estimulos'])
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('assigment.index') }}">
                          <i class="fas fa-wallet"></i> Asign. Estímulos</a>
                  </li>
                @endcan

                @canany(['Pharmacy'])
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-warehouse"></i> Bodega
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                            @canany(['Pharmacy: Administrator'])
                            <a class="dropdown-item"
                                href="{{ route('pharmacies.admin_view') }}">
                                <i class="fas fa-fw fa-user"></i> Administrador
                            </a>
                            @endcanany

                            @if(Auth::user()->pharmacies->count() > 0)
                              <a class="dropdown-item"
                                  href="{{ route('pharmacies.index') }}">
                                  <i class="fas fa-fw fa-prescription-bottle-alt"></i> {{Auth::user()->pharmacies->first()->name}}
                              </a>
                            @else
                              <a class="dropdown-item">
                                  <i class="fas fa-fw fa-solid fa-x"></i> Falta asignar bodega
                              </a>
                            @endif

                        </div>
                    </li>
                @endcanany


                @canany(['Resources: create', 'Resources: edit', 'Resources: delete'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-clipboard-list"></i> Recursos
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item"
                            href="{{ route('resources.computer.index') }}">
                            <i class="fas fa-desktop fa-fw"></i> Computadores
                        </a>

                        <a class="dropdown-item"
                            href="{{ route('resources.printer.index') }}">
                            <i class="fas fa-print fa-fw"></i> Impresoras
                        </a>

                        <a class="dropdown-item"
                            href="{{ route('resources.telephone.index') }}">
                            <i class="fas fa-fax fa-fw"></i> Teléfonos Fijos
                        </a>

                        <a class="dropdown-item"
                            href="{{ route('resources.mobile.index') }}">
                            <i class="fas fa-mobile-alt fa-fw"></i> Teléfonos Móviles
                        </a>

                        <a class="dropdown-item"
                            href="{{ route('resources.wingle.index') }}">
                            <i class="fas fa-wifi fa-fw"></i> Banda Ancha Móvil
                        </a>

                    </div>
                </li>
                @endcan

                @can('Mammography: admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mammography.index') }}" title="Mamografias"> <i class="fas fa-fw fa-dot-circle"></i> </a>
                </li>
                @endcan


            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fas fa-bell" title="Notificaciones"></i>
                            @if(count(auth()->user()->unreadNotifications))
                            <span class="badge badge-secondary">{{ count(auth()->user()->unreadNotifications) }}</span>
                            @endif
                        </a>

                        @if(count(auth()->user()->unreadNotifications))
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @foreach(auth()->user()->unreadNotifications as $notification)
                            <a class="dropdown-item" href="{{ route('openNotification',$notification) }}">
                                {{ substr($notification->data['subject'],0,100) }} ...
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->firstName }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                            @if(session()->has('god'))
                                <a class="dropdown-item" href="{{ route('rrhh.users.switch', session('god')) }}">
                                    <i class="fas fa-eye text-danger"></i> God Like
                                </a>
                            @endif


                            @role('god')
                            <a class="dropdown-item"
                               href="{{ route('parameters.index') }}">
                                <i class="fas fa-cog fa-fw"></i> Mantenedores
                            </a>

                            <a class="dropdown-item"
                               href="{{ route('parameters.logs.index') }}">
                                <i class="fas fa-bomb fa-fw"></i> Log de errores
                            </a>
                            @endrole


                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="{{ route('logout') }}">
                                <i class="fas fa-sign-out-alt fa-fw"></i> {{ __('Cerrar sesión') }}
                            </a>

                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
