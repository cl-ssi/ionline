<ul class="nav nav-tabs mb-3 d-print-none">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ active(['job.position.profile.*']) }}" href="#" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-id-badge"></i> Perfiles de Cargo
        </a>

        <div class="dropdown-menu">
            <a class="dropdown-item {{ active(['job_position_profile.index']) }}" href="{{ route('job_position_profile.own_index') }}"><i class="fas fa-id-badge"></i> Mis Perfiles de Cargos</a>
            <a class="dropdown-item {{ active(['job_position_profile.create']) }}" href="{{ route('job_position_profile.create') }}"><i class="fas fa-plus"></i> Nuevo Perfil de Cargo</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item {{-- active(['allowances.all_index']) --}}" href="{{-- route('allowances.all_index') --}}"><i class="fas fa-id-badge"></i> Todos los Perfiles de Cargos</a>
        </div>
    </li>

    @if(Auth::user()->hasPermissionTo('Job Position Profile: review') || 
        App\Rrhh\Authority::getAmIAuthorityFromOu(Carbon\Carbon::now(), 'manager', auth()->user()->id)->count() > 0)
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ active(['job.position.profile.index_review']) }}" href="#" id="navbardrop" data-toggle="dropdown">
                <i class="fas fa-id-badge"></i> Aprobación
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item {{ active(['job_position_profile.index_review']) }}" href="{{ route('job_position_profile.index_review') }}"><i class="fab fa-readme fa-fw"></i>  Pendientes de Revisión</a>
                @if(App\Rrhh\Authority::getAmIAuthorityFromOu(Carbon\Carbon::now(), 'manager', auth()->user()->id)->count() > 0)
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('job_position_profile.index_to_sign') }}">
                        <i class="fas fa-check-circle fa-fw"></i> Gestión de solicitudes
                    </a>
                @endif
            </div>
        </li>
    @endif

        {{--
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                <i class="fas fa-file-export"></i> Reportes
            </a>

        </li>
        --}}
    {{-- @endcan --}}
</ul>
