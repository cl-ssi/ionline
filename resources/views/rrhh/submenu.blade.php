<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.users.index') }}" href="{{ route('rrhh.users.index') }}"><i class="bi bi-search"></i> </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.users.edit') }}" href="{{ route('rrhh.users.edit',$user->id) }}">
            <i class="bi bi-person-fill"></i> <span class="d-none d-sm-inline"> Perfil</span></a>
    </li>

    @can('Users: assign roles')
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.roles.mgr') }}" href="{{ route('rrhh.roles.mgr', $user->id) }}">
            <i class="bi bi-wrench-adjustable"></i> <span class="d-none d-sm-inline"> Roles</span></a>
    </li>
    @endcan

    @can('Users: assign permission')
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.permissions.mgr') }}" href="{{ route('rrhh.permissions.mgr', $user->id) }}">
            <i class="bi bi-wrench-adjustable"></i> <span class="d-none d-sm-inline"> Permisos</span></a>
    </li>
    @endcan

    @can('Users: show access logs')
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.users.access-logs') }}" href="{{ route('rrhh.users.access-logs', [$user]) }}">
            <i class="bi bi-person-fill-lock"></i> <span class="d-none d-sm-inline"> Registros de acceso</span></a>
    </li>
    @endcan

</ul>