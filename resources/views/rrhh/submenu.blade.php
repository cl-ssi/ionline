<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.users.index') }}" href="{{ route('rrhh.users.index') }}"><span class="fas fa-search"></span> </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.users.edit') }}" href="{{ route('rrhh.users.edit',$user->id) }}">
            <span class="fas fa-user"></span> <span class="d-none d-sm-inline"> Perfil</span></a>
    </li>

    @can('Users: assign permission')
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.roles.index') }}" href="{{ route('rrhh.roles.index', $user->id) }}">
            <span class="fas fa-wrench"></span> <span class="d-none d-sm-inline"> Permisos</span></a>
    </li>
    @endcan

    @can('be god')
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.users.access-logs') }}" href="{{ route('rrhh.users.access-logs', [$user]) }}">
            <span class="fas fa-user-clock"></span> <span class="d-none d-sm-inline"> Registros de acceso</span></a>
    </li>
    @endcan

</ul>