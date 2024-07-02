<ul class="nav nav-tabs mb-3 d-print-none">

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ request()->routeIs('allowances.index*') || request()->routeIs('allowances.create*') || request()->routeIs('allowances.all_index*')  ? 'active' : '' }}" href="#" id="navbardrop" data-toggle="dropdown">
                <i class="fas fa-wallet"></i> Viáticos
            </a>

            <div class="dropdown-menu">
                <a class="dropdown-item {{ active(['allowances.index']) }}" href="{{ route('allowances.index') }}"><i class="fas fa-wallet"></i> Mis víaticos</a>
                <a class="dropdown-item {{ active(['allowances.create']) }}" href="{{ route('allowances.create') }}"><i class="fas fa-plus"></i> Nueva Solicitud</a>
                @canany(['Allowances: all', 'Allowances: all establishment'])
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item {{ active(['allowances.all_index']) }}" href="{{ route('allowances.all_index') }}"><i class="fas fa-wallet"></i> Todos los víaticos</a>
                @endcanany
            </div>
        </li>

        @can('Allowances: sirh')
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('allowances.sign_index') || request()->routeIs('allowances.archived_index') ? 'active' : '' }}" href="#" id="navbardrop" data-toggle="dropdown">
                    <i class="fas fa-wallet"></i> Revisión SIRH
                </a>

                <div class="dropdown-menu">
                    <a class="dropdown-item {{ active(['allowances.sign_index']) }}" href="{{ route('allowances.sign_index') }}">
                        <i class="fas fa-wallet"></i> Todos los viáticos
                    </a>
                    <a class="dropdown-item {{ active(['allowances.archived_index']) }}" href="{{ route('allowances.archived_index') }}">
                        <i class="fas fa-archive"></i> Viáticos archivados
                    </a>
                </div>
            </li>
        @endcan

        @can('Allowances: contabilidad')
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('allowances.contabilidad_index') || request()->routeIs('allowances.archived_index') ? 'active' : '' }}" href="#" id="navbardrop" data-toggle="dropdown">
                    <i class="fas fa-wallet"></i> Contabilidad
                </a>

                <div class="dropdown-menu">
                    <a class="dropdown-item {{ active(['allowances.contabilidad_index']) }}" href="{{ route('allowances.contabilidad_index') }}">
                        <i class="fas fa-wallet"></i> Todas los viáticos
                    </a>
                    <a class="dropdown-item {{ active(['allowances.archived_index']) }}" href="{{ route('allowances.archived_index') }}">
                        <i class="fas fa-archive"></i> Viáticos archivados
                    </a>
                </div>
            </li>
        @endcan

        @if(auth()->user()->hasPermissionTo('Allowances: director'))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ request()->routeIs('allowances.director_index*')  ? 'active' : '' }}" href="#" id="navbardrop" data-toggle="dropdown">
                <i class="fas fa-wallet"></i> Aprobaciones
            </a>

            @can('Allowances: director')
            <div class="dropdown-menu">
                <a class="dropdown-item {{ active(['allowances.director_index']) }}" href="{{ route('allowances.director_index') }}"><i class="fas fa-wallet"></i> Dirección</a>
            </div>
            @endcan
        </li>
        @endif

        @can('Allowances: reports')
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ active(['allowances.reports.*']) }}" href="#" id="navbardrop" data-toggle="dropdown">
                <i class="fas fa-file-export"></i> Reportes
            </a>

            <div class="dropdown-menu">
                <a class="dropdown-item {{ active(['allowances.reports.create_by_dates']) }}" href="{{ route('allowances.reports.create_by_dates') }}">
                    <i class="fas fa-calendar"></i> Viáticos por fecha
                </a>
            </div>
        </li>
        @endcan
</ul>
