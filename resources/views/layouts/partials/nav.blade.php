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

                <li class="nav-item {{ active('rrhh.users.directory') }}">
                    <a class="nav-link" href="{{ route('rrhh.users.directory') }}">
                        <i class="fas fa-address-book" title="Teléfonos"></i>
                    </a>
                </li>

                @auth
                <li class="nav-item {{ active('calendars') }}">
                    <a class="nav-link" href="{{ route('calendars') }}">
                        <i class="fas fa-calendar-alt" title="Calendarios"></i>
                    </a>
                </li>
                @endauth

                <li class="nav-item dropdown {{ active(['indicators.*','programmings.*','communefiles.index','le_extra_plans.index']) }}">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-chart-pie"></i> Estadísticas
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item" href="{{ route('indicators.index') }}">
                            <i class="fas fa-desktop fa-fw"></i> Indicadores - REM
                        </a>

                        <a class="dropdown-item" href="{{ route('indicators.population') }}">
                            <i class="fas fa-globe-americas fa-fw"></i> Tablero de población
                        </a>

                        @canany(['be god','Rem: admin','Rem: user'])
                        <!-- <a class="dropdown-item"
                           href="{{ route('rem.files.index') }}">
                            <i class="fas fa-file-excel fa-fw"></i> Carga de Rems
                        </a> -->
                        <a class="dropdown-item" href="{{ route('rem.files.rem_original') }}">
                            <i class="fas fa-file-excel fa-fw"></i> Carga de Rems
                        </a>
                        @endcan
                        @can('RNI Database: view')
                        <a class="dropdown-item" href="{{ route('indicators.rni_db.index') }}">
                            <i class="fas fa-database fa-fw"></i> Base de datos RNI
                        </a>
                        @endcan

                        @can('Programming: view')
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('programmings.index') }}">
                            <i class="fas fa-calculator fa-fw"></i> Programación Numérica
                        </a>

                        <a class="dropdown-item" href="{{ route('communefiles.index') }}">
                            <i class="fas fa-file-alt fa-fw"></i> Documentos Comunales
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

                    <a class="nav-link dropdown-toggle
                    {{ active(['documents.*','documents.*','agreements.*','quality_aps.*','health_plan.*']) }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-file-alt"></i> Docs
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        @canany(['Documents: create','Documents: edit','Documents: add number', 'Documents: dev'])
                        <a class="dropdown-item {{ active('documents.index') }}" href="{{ route('documents.index') }}">
                            <i class="fas fa-pen"></i> Generador de documentos
                        </a>
                        @endcan

                        @canany(['Documents: signatures and distribution'])
                        <a class="dropdown-item {{ active('documents.signatures.*') }}" href="{{ route('documents.signatures.index', ['pendientes']) }}">
                            <i class="fas fa-signature"></i> Solicitud de firmas
                        </a>
                        @endcan

                        @canany(['Partes: oficina','Partes: user','Partes: director'])
                        <a class="dropdown-item {{ active('documents.partes.*') }}" href="{{ route('documents.partes.index') }}">
                            <i class="fas fa-file-import"></i> Partes
                        </a>
                        @endcan

                        @can('Agreement: view')
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item {{ active('agreements.tracking.*') }}" href="{{ route('agreements.tracking.index') }}">
                            <i class="fas fa-file"></i> Convenios
                        </a>
                        @endcan

                        <a class="dropdown-item {{ active('quality_aps.*') }}" href="{{ route('quality_aps.index') }}">
                            <i class="fas fa-file-alt"></i> Acreditación de Calidad
                        </a>

                        <a class="dropdown-item {{ active('health_plan.*') }}" href="{{ route('health_plan.index', ['iquique']) }}">
                            <i class="fas fa-file-powerpoint"></i> Planes Comunales
                        </a>
                    </div>
                </li>


                @can('Requirements: create')
                <li class="nav-item {{ active('requirements.*') }}">
                    <a class="nav-link" href="{{ route('requirements.inbox') }}">
                        <i class="fas fa-rocket"></i> SGR
                        <span class="badge badge-secondary">{{ App\Models\Requirements\Requirement::getPendingRequirements() }}</span>
                    </a>
                </li>
                @endcan


                @if(auth()->user()->organizationalUnit && auth()->user()->organizationalUnit->establishment_id != 1)
                <li class="nav-item dropdown {{ active(['request_forms.*','warehouse.*','pharmacies.*','resources.*','inventories.*','allowances.*']) }}">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Subdirección Administrativa">
                            <i class="fas fa-money-check"></i> SDA
                        </span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @php($ouSearch = App\Models\Parameters\Parameter::where('module', 'nav')->where('parameter', 'accessRF')->first()->value)
                        @if(auth()->user()->organizationalUnit && in_array(auth()->user()->organizationalUnit->establishment_id, explode(',', $ouSearch)))
                        <a class="dropdown-item {{ active('request_forms.my_forms') }}" href="{{ route('request_forms.my_forms') }}">
                            <i class="fas fa-fw fa-shopping-cart"></i> Abastecimiento
                        </a>
                        @endif


                        @can('Payments')
                        <a class="dropdown-item {{ active('finance.payments.index') }}" href="{{ route('finance.payments.index') }}">
                            <i class="fas fa-fw fa-money-bill"></i> Estados de pago
                        </a>
                        @endif

                        @can('Store')
                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header">Bodegas</h6>
                        @endcan

                        @canany([
                        'Store', 'Store: admin', 'Store: index', 'Store: list receptions',
                        'Store: list dispatchs', 'Store: bincard report', 'Store: maintainer programs',
                        'Store: maintainers', 'Store: add invoice', 'Store: create dispatch',
                        'Store: create reception by donation', 'Store: create reception by purcharse order'
                        ])
                        @forelse(Auth::user()->stores as $store)
                        <a class="dropdown-item" href="{{ route('warehouse.store.active', $store->id) }}">
                            @if($store->id == optional(Auth::user()->active_store)->id)
                            <i class="fas fa-fw fa-box-open"></i>
                            @else
                            <i class="fas fa-fw fa-circle"></i>
                            @endif
                            {{ $store->name }}
                        </a>
                        @empty
                        <a class="dropdown-item" href="#">
                            No tiene bodegas asignadas
                        </a>
                        @endforelse
                        @endcanany

                        {{-- @can('Store: add invoice')
                            <a
                                class="dropdown-item {{ active('warehouse.invoice-management') }}"
                        href="{{ route('warehouse.invoice-management') }}"
                        >
                        <i class="fas fa-fw fa-file-invoice-dollar"></i> Ingreso facturas
                        </a>
                        @endcan --}}

                        @canany(['Store: warehouse manager'])
                        <a class="dropdown-item {{ active('warehouse.stores.index') }}" href="{{ route('warehouse.stores.index') }}">
                            <i class="fas fa-fw fa-cog"></i> Administrar Bodegas
                        </a>
                        @endcanany


                        @can('Inventory')
                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header">Inventario</h6>
                        @endcan

                        @can('Inventory')
                        @foreach(auth()->user()->establishmentInventories as $establishmentItem)
                        <a class="dropdown-item" href="{{ route('inventories.index', $establishmentItem) }}">
                            <i class="fas fa-fw fa-clipboard-list"></i>
                            {{ $establishmentItem->name }}
                        </a>
                        @endforeach
                        @endcan

                        @can('Inventory: manager')
                        <a class="dropdown-item" href="{{ route('inventories.manager') }}">
                            <i class="fas fa-fw fa-cog"></i> Administrar Inventarios
                        </a>
                        @endcan

                        @canany(['Pharmacy'])
                        <div class="dropdown-divider"></div>

                        <h6 class="dropdown-header">Droguerías</h6>

                        @canany(['Pharmacy: Administrator'])
                        <a class="dropdown-item {{ active('pharmacies.admin_view') }}" href="{{ route('pharmacies.admin_view') }}">
                            <i class="fas fa-fw fa-user"></i> Administrador
                        </a>
                        @endcanany

                        @if(Auth::user()->pharmacies->count() > 0)
                        <a class="dropdown-item {{ active('pharmacies.index') }}" href="{{ route('pharmacies.index') }}">
                            <i class="fas fa-fw fa-prescription-bottle-alt"></i>
                            {{ Auth::user()->pharmacies->first()->name}}
                        </a>
                        @else
                        <a class="dropdown-item">
                            <i class="fas fa-fw fa-exclamation-circle"></i> No tiene droguerías asignadas
                        </a>
                        @endif

                        @endcan


                        @canany(['Resources: create', 'Resources: edit', 'Resources: delete'])

                        <div class="dropdown-divider"></div>

                        <h6 class="dropdown-header">Recursos informáticos</h6>

                        <a class="dropdown-item {{ active('resources.tic') }}" href="{{ route('resources.tic') }}">
                            <i class="fas fa-boxes fa-fw"></i> Bandeja de inventario
                        </a>

                        <a class="dropdown-item {{ active('resources.computer.*') }}" href="{{ route('resources.computer.index') }}">
                            <i class="fas fa-desktop fa-fw"></i> Computadores
                        </a>

                        <a class="dropdown-item {{ active('resources.printer.*') }}" href="{{ route('resources.printer.index') }}">
                            <i class="fas fa-print fa-fw"></i> Impresoras
                        </a>

                        <a class="dropdown-item {{ active('resources.telephone.*') }}" href="{{ route('resources.telephone.index') }}">
                            <i class="fas fa-fax fa-fw"></i> Teléfonos Fijos
                        </a>

                        <a class="dropdown-item {{ active('resources.mobile.*') }}" href="{{ route('resources.mobile.index') }}">
                            <i class="fas fa-mobile-alt fa-fw"></i> Teléfonos Móviles
                        </a>

                        <a class="dropdown-item {{ active('resources.wingle.*') }}" href="{{ route('resources.wingle.index') }}">
                            <i class="fas fa-wifi fa-fw"></i> Banda Ancha Móvil
                        </a>

                        @endcan


                        {{-- @if(Auth::user()->can('Allowances: create') ||
                            Auth::user()->can('Allowances: all') ||
                            Auth::user()->can('Allowances: reports')) --}}

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item {{ active('allowances.index') }}" href="{{ route('allowances.index') }}">
                            <i class="fas fa-wallet"></i> Viáticos
                        </a>
                        {{-- @endcan --}}

                    </div>
                </li>
                @endif


                @canany(['Users: create', 'Users: edit','Users: delete',
                'OrganizationalUnits: create',
                'OrganizationalUnits: edit',
                'OrganizationalUnits: delete',
                'Authorities: view',
                'Authorities: create',
                'Users: service requests',
                'Service Request',
                'Replacement Staff: create request',
                'Replacement Staff: view requests',
                'Job Position Profile: create',
                'Job Position Profile: all',
                'Job Position Profile: review'])
                <li class="nav-item dropdown
                    {{ active(['rrhh.users.*','rrhh.organizational-units.*','rrhh.authorities.*','suitability.*','replacement_staff.request.*']) }}">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Subdirección de Gestión y Desarrollo de las Personas">
                            <i class="fas fa-users"></i> SDGP
                        </span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        @canany(['Users: create', 'Users: edit','Users: delete'])
                        <a class="dropdown-item {{ active(['rrhh.users.index']) }}" href="{{ route('rrhh.users.index') }}">
                            <i class="fas fa-user fa-fw"></i> Usuarios
                        </a>
                        @endcan

                        @canany(['OrganizationalUnits: create', 'OrganizationalUnits: edit', 'OrganizationalUnits: delete'])
                        <a class="dropdown-item {{ active('rrhh.organizational-units.*') }}" href="{{ route('rrhh.organizational-units.index') }}">
                            <i class="fas fa-sitemap fa-fw"></i> Unidades organizacionales
                        </a>
                        @endcan

                        @canany(['Authorities: view', 'Authorities: create'])
                        <a class="dropdown-item {{ active('rrhh.new-authorities.*') }}" href="{{ route('rrhh.new-authorities.index') }}">
                            <i class="fas fa-chess-king fa-fw"></i> Autoridades
                        </a>
                        @endcan

                        @canany(['Rrhh: birthday'])
                        <a class="dropdown-item {{ active('rrhh.users.birthdayGrettings') }}" href="{{ route('rrhh.users.birthdayGrettings') }}">
                            <i class="fas fa-birthday-cake"></i> Correo cumpleaños
                        </a>
                        @endcan

                        @canany(['Rrhh: wellfair', 'be god'])
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('welfare.index') }}">
                            <i class="fas fa-money-check"></i> Bienestar
                        </a>
                        @endcan

                        <div class="dropdown-divider"></div>

                        @can('Suitability: ssi')
                        <a class="dropdown-item {{ active('suitability.*') }}" href="{{ route('suitability.own') }}">
                            <i class="fas fa-chalkboard-teacher"></i> Idoneidad
                        </a>
                        @endcan


                        @canany(['Service Request'])
                        <a class="dropdown-item {{ active('rrhh.service-request.*') }}" href="{{ route('rrhh.service-request.home') }}">
                            <i class="fas fa-child fa-fw"></i> Contratación Honorarios
                        </a>
                        @endcan

                        @canany(['Service Request: export sirh mantenedores'])
                        <a class="dropdown-item {{ active('parameters.professions.index') }}" href="{{ route('parameters.professions.index') }}">
                            <i class="fas fa-child fa-chevron-right"></i> Mantenedor de profesiones
                        </a>

                        <a class="dropdown-item" href="{{ route('rrhh.organizational-units.index') }}">
                            <i class="fas fa-sitemap fa-chevron-right"></i> Unidades organizacionales
                        </a>
                        @endcan

                        @canany(['Shift Management: view'])
                        <a class="dropdown-item {{ active('rrhh.shiftManag.index') }}" href="{{ route('rrhh.shiftManag.index') }}">
                            <i class="fa fa-calendar fa-fw"></i> Modulo Turnos
                        </a>
                        @endcan

                        @canany(['Users: service requests'])
                        <a class="dropdown-item {{ active('rrhh.users.service_requests.index') }}" href="{{ route('rrhh.users.service_requests.index') }}">
                            <i class="fas fa-user fa-fw"></i> Usuarios - Contrat. de Servicios
                        </a>
                        @endcan

                        {{-- @if(Auth::user()->hasRole('Replacement Staff: admin'))
                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item {{ active('replacement_staff.request.index') }}"
                        href="{{ route('replacement_staff.request.index') }}">
                        <i class="far fa-id-card"></i> Solicitudes de Contratación
                        </a>
                        @endif --}}

                        @if(Auth::user()->hasRole('Replacement Staff: user rys'))
                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header">Depto. Desarrollo y Gestión del Talento</h6>

                        <a class="dropdown-item {{ active('replacement_staff.request.assign_index') }}" href="{{ route('replacement_staff.request.assign_index') }}">
                            <i class="far fa-id-card"></i> Solicitudes de Contratación
                        </a>
                        @endif

                        @if(Auth::user()->hasRole('Replacement Staff: user') ||
                        App\Rrhh\Authority::getAmIAuthorityFromOu(Carbon\Carbon::now(), 'manager', Auth::user()->id) ||
                        Auth::user()->hasRole('Replacement Staff: personal') ||
                        Auth::user()->hasRole('Replacement Staff: personal sign') ||
                        Auth::user()->hasRole('Replacement Staff: admin'))

                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header">Depto. Desarrollo y Gestión del Talento</h6>

                        <a class="dropdown-item {{ active('replacement_staff.request.own_index') }}" href="{{ route('replacement_staff.request.own_index') }}">
                            <i class="far fa-id-card"></i> Solicitudes de Contratación
                            {{--
                            @if(App\Models\ReplacementStaff\RequestReplacementStaff::getPendingRequestToSign() > 0)
                            <span class="badge badge-secondary">
                                {{ App\Models\ReplacementStaff\RequestReplacementStaff::getPendingRequestToSign() }}
                            </span>
                            @endif
                            --}}
                        </a>
                        @endif

                        @canany(['Job Position Profile: create', 'Job Position Profile: all', 'Job Position Profile: review'])
                        <a class="dropdown-item" href="{{ route('job_position_profile.index') }}">
                            <i class="fas fa-id-badge"></i> Perfil de Cargos
                        </a>
                        @endcan

                    </div>

                </li>
                @endcan

                @can('Drugs')
                <li class="nav-item {{ active('drugs.*') }}">
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

                @can('Integrity: manage complaints')
                <li class="nav-item {{ active('integrity.complaints.*') }}">
                    <a class="nav-link" href="{{ route('integrity.complaints.index') }}">
                        <i class="fas fa-balance-scale"></i> Integridad</a>
                </li>
                @endcan

                @can('Mammography: admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mammography.index') }}" title="Mamografias"> <i class="fas fa-fw fa-dot-circle"></i> </a>
                </li>
                @endcan

                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                </li>
                @else

                @canany([
                'be god',
                'Parameters: programs',
                'Parameters: professions',
                'Parameters: locations',
                'Parameters: places',
                'Parameters: holidays',
                'Parameters: UNSPSC',
                ])
                <li class="nav-item dropdown {{ active(['parameters.*']) }}">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cog" title="Mantenedores"></i>
                    </a>

                    <ul class="dropdown-menu">

                        @canany(['be god'])
                        <a class="dropdown-item {{ active(['parameters.index', 'parameters.create', 'parameters.edit']) }}" href="{{ route('parameters.index') }}">
                            <i class="fas fa-cog"></i> Parámetros
                        </a>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <a class="dropdown-item {{ active(['parameters.permissions.web']) }}" href="{{ route('parameters.permissions.index', 'web') }}">
                            <i class="fas fa-fw fa-user-tag"></i> Permisos internos
                        </a>

                        <a class="dropdown-item {{ active(['parameters.permissions.external']) }}" href="{{ route('parameters.permissions.index', 'external') }}">
                            <i class="fas fa-fw fa-user-lock"></i> Permisos externos
                        </a>

                        <a class="dropdown-item {{ active(['parameters.roles.*']) }}" href="{{ route('parameters.roles.index') }}">
                            <i class="fas fa-fw fa-users-cog"></i> Roles
                        </a>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <a class="dropdown-item {{ active('parameters.communes.*') }}" href="{{ route('parameters.communes.index') }}">
                            <i class="fas fa-fw fa-map"></i> Comunas
                        </a>

                        <a class="dropdown-item {{ active('parameters.establishments.index') }}" href="{{ route('parameters.establishments.index') }}">
                            <i class="fas fa-fw fa-hospital"></i> Establecimientos
                        </a>


                        <a class="dropdown-item {{ active('parameters.establishment_types.index') }}" href="{{ route('parameters.establishment_types.index') }}">
                            <i class="fas fa-th-list"></i> Tipos de Establecimientos
                        </a>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @endcanany


                        @canany(['be god','Parameters: programs'])
                        <a class="dropdown-item {{ active(['parameters.programs.*']) }}" href="{{ route('parameters.programs.index')}}">
                            <i class="fas fa-fw fa-list"></i> Programas
                        </a>

                        @endcanany

                        @canany(['be god','Parameters: professions'])
                        <a class="dropdown-item {{ active('parameters.professions.index') }}" href="{{ route('parameters.professions.index') }}">
                            <i class="fas fa-fw fa-user-md"></i> Profesiones
                        </a>
                        @endcanany

                        @canany(['be god','Parameters: COMGES cutoffdates'])
                        <a class="dropdown-item {{ active(['parameters.cutoffdates.*']) }}" href="{{ route('parameters.cutoffdates.index') }}">
                            <i class="fas fa-fw fa-calendar-alt"></i> COMGES - Fechas de corte
                        </a>
                        @endcanany

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        @canany(['be god','Parameters: locations'])
                        <a class="dropdown-item {{ active(['parameters.locations.*']) }}" href="{{ route('parameters.locations.index', auth()->user()->organizationalUnit->establishment) }}">
                            <i class="fas fa-fw fa-building"></i> Ubicaciones (edificios)
                        </a>
                        @endcanany

                        @canany(['be god','Parameters: places'])
                        <a class="dropdown-item {{ active(['parameters.places.*']) }}" href="{{ route('parameters.places.index', auth()->user()->organizationalUnit->establishment) }}">
                            <i class="fas fa-fw fa-map-marker-alt"></i> Lugares (oficinas)
                        </a>
                        @endcanany

                        @canany(['be god','Parameters: holidays'])
                        <a class="dropdown-item {{active('parameters.holidays.*')}}" href="{{ route('parameters.holidays') }}">
                            <i class="fas fa-fw fa-suitcase"></i> Feriados
                        </a>
                        @endcanany

                        @canany(['be god','Parameters: UNSPSC'])
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <a class="dropdown-item {{ active('segments.index') }}" href="{{ route('segments.index') }}">
                            <i class="fas fa-fw fa-cubes"></i> UNSPSC Segmentos
                        </a>

                        <a class="dropdown-item {{ active('products.all') }}" href="{{ route('products.all') }}">
                            <i class="fas fa-fw fa-cube"></i> UNSPSC Productos
                        </a>
                        @endcanany

                        @canany(['be god'])
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <a class="dropdown-item {{active('parameters.phrases.index')}}" href="{{ route('parameters.labels.index', 'computers') }}">
                            <i class="fas fa-tag"></i> Etiqueta Computadores
                        </a>

                        <a class="dropdown-item {{active('parameters.phrases.index')}}" href="{{ route('parameters.phrases.index') }}">
                            <i class="fas fa-smile-beam"></i> Frases del día
                        </a>


                        <a class="dropdown-item {{active('rrhh.users.last-access')}}" href="{{ route('rrhh.users.last-access') }}">
                            <i class="fas fa-list-alt"></i> Últimos accesos
                        </a>
                        @endcanany

                    </ul>
                </li>
                @endcanany



                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fas fa-bell" title="Notificaciones"></i>
                        @if(count(auth()->user()->unreadNotifications))
                        <span class="badge badge-secondary">{{ count(auth()->user()->unreadNotifications) }}</span>
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('allNotifications') }}">
                            <i class="fas fa-fw fa-bell" title="Notificaciones"></i> Todas mis notificaciones
                        </a>

                        <div class="dropdown-divider"></div>

                        @if(count(auth()->user()->unreadNotifications))
                        @foreach(auth()->user()->unreadNotifications as $notification)
                        <a class="dropdown-item small" href="{{ route('openNotification',$notification) }}">
                            {!! $notification->data['icon'] ?? null !!}
                            <b>{{ $notification->data['module'] ?? '' }}</b>
                            {{ substr($notification->data['subject'],0,100) }}
                        </a>
                        @endforeach
                        @else
                        <div class="dropdown-item small">
                            <i class="fas fa-exclamation"></i> Sin Notificaciones Nuevas
                        </div>
                        @endif
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        @if(auth()->user()->gravatar)
                        <img src="{{ auth()->user()->gravatarUrl }}?s=30&d=mp&r=g" class="rounded-circle" alt="{{ Auth::user()->firstName }}">
                        @else
                        {{ Auth::user()->firstName }}
                        @endif
                        <span class="caret"></span>
                        @if(auth()->user()->absent)
                        <i class="fas text-warning fa-cocktail"></i>
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                        @if(session()->has('god'))
                        <a class="dropdown-item" href="{{ route('rrhh.users.switch', session('god')) }}">
                            <i class="fas fa-eye text-danger"></i> God Like
                        </a>

                        <div class="dropdown-divider"></div>
                        @endif

                        <a class="dropdown-item" href="{{ route('profile.subrogations') }}">
                            @if(auth()->user()->absent)
                            <i class="fas fa-fw fa-cocktail text-danger"></i>
                            @else
                            <i class="fas fa-fw fa-chess"></i>
                            @endif
                            Subrogancia
                        </a>

                        <a class="dropdown-item" href="{{ route('inventories.pending-movements') }}">
                            <i class="fas fa-fw fa-boxes"></i> {{ __('Inventario') }}
                        </a>

                        @role('god')
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('parameters.logs.index') }}">
                            <i class="fas fa-cog fa-bomb"></i> Log de errores
                        </a>
                        @endrole


                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('rrhh.users.password.edit') }}">
                            <i class="fas fa-cog fa-key"></i> Cambio de clave
                        </a>

                        <a class="dropdown-item" href="{{ route('logout') }}">
                            <i class="fas fa-fw fa-sign-out-alt"></i> {{ __('Cerrar sesión') }}
                        </a>

                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>