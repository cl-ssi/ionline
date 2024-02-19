<ul class="nav nav-tabs mb-3 d-print-none">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ active(['job.position.profile.*']) }}" href="#" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-id-badge fa-fw"></i> Perfiles de Cargo
        </a>

        <div class="dropdown-menu">
            <a class="dropdown-item {{ active(['job_position_profile.index']) }}" href="{{ route('job_position_profile.own_index') }}"><i class="fas fa-id-badge fa-fw"></i> Mis Perfiles de Cargos</a>
            <a class="dropdown-item {{ active(['job_position_profile.create']) }}" href="{{ route('job_position_profile.create') }}"><i class="fas fa-plus fa-fw"></i> Nuevo Perfil de Cargo</a>
            @can(['Job Position Profile: all'])
                <div class="dropdown-divider"></div>
                <a class="dropdown-item {{ active(['job_position_profile.all_index']) }}" href="{{ route('job_position_profile.all_index') }}"><i class="fas fa-id-badge fa-fw"></i> Todos los Perfiles de Cargos</a>
            @endcan
        </div>
    </li>

    @if(auth()->user()->manager->count() > 0)
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ active(['job.position.profile.index_review']) }}" href="#" id="navbardrop" data-toggle="dropdown">
                <i class="fas fa-id-badge"></i> Aprobación
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item {{ active(['job.position.profile.index_to_sign']) }}" href="{{ route('job_position_profile.index_to_sign') }}">
                    <i class="fas fa-check-circle fa-fw"></i> Gestión de solicitudes
                </a>
            </div>
        </li>
    @endif
</ul>
