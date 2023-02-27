<ul class="nav nav-tabs mb-3 d-print-none">
    {{-- @canany(['Replacement Staff: list rrhh', 'Replacement Staff: staff manage']) --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ active(['job.position.profile.*']) }}" href="#" id="navbardrop" data-toggle="dropdown">
                <i class="fas fa-id-badge"></i> Perfiles de Cargo
            </a>

            <div class="dropdown-menu">
                <a class="dropdown-item {{ active(['job_position_profile.index']) }}" href="{{ route('job_position_profile.own_index') }}"><i class="fas fa-id-badge"></i> Mis Perfiles de Cargos</a>
                <a class="dropdown-item {{ active(['job_position_profile.create']) }}" href="{{ route('job_position_profile.create') }}"><i class="fas fa-plus"></i> Nuevo Perfil de Cargo</a>

                {{-- @can('Allowances: all') --}}
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item {{-- active(['allowances.all_index']) --}}" href="{{-- route('allowances.all_index') --}}"><i class="fas fa-id-badge"></i> Todos los Perfiles de Cargos</a>
                {{-- @endcan --}}
            </div>
        </li>

        @can('Job Position Profile: review')
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ active(['job.position.profile.index_review']) }}" href="#" id="navbardrop" data-toggle="dropdown">
                <i class="fas fa-id-badge"></i> Revisión
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item {{ active(['job_position_profile.index_review']) }}" href="{{ route('job_position_profile.index_review') }}"><i class="fas fa-id-badge"></i> Pendientes de Revisión</a>
            </div>
        </li>
        @endcan

        {{--
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                <i class="fas fa-file-export"></i> Reportes
            </a>

        </li>
        --}}
    {{-- @endcan --}}
</ul>
