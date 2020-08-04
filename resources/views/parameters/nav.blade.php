<ul class="nav nav-tabs mb-3">
   {{-- <li class="nav-item">
        <a class="nav-link {{ active('parameters.communes.index') }}"
            href="{{ route('parameters.communes.index') }}">
            <i class="fas fa-home"></i> Comunas</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('parameters.establishments.index') }}"
            href="{{ route('parameters.establishments.index') }}">
            <i class="fas fa-hospital"></i> Establecimientos</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('parameters.holidays.index') }}"
            href="{{ route('parameters.holidays.index') }}">
            <i class="fas fa-suitcase"></i> Feriados</a>
    </li>--}}

    <li class="nav-item">
        <a class="nav-link {{ Request::is('parameters/permissions*') ? 'active' : '' }}"
            href="{{ route('parameters.permissions.index') }}">
            <i class="fas fa-chalkboard-teacher"></i> Permisos</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Request::is('parameters/roles*') ? 'active' : ''}}"
            href="{{ route('parameters.roles.index') }}">
            <i class="fas fa-chalkboard-teacher"></i> Roles</a>
    </li>

  {{--  <li class="nav-item">
        <a class="nav-link {{ active('parameters.locations.*') }}"
            href="{{ route('parameters.locations.index') }}">
            <i class="fas fa-home"></i> Ubicaciones</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('parameters.places.*') }}"
            href="{{ route('parameters.places.index') }}">
            <i class="fas fa-map-marker-alt"></i> Lugares</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('parameters.phrases.*') }}"
            href="{{ route('parameters.phrases.index') }}">
            <i class="fas fa-smile-beam"></i> Frases del día</a>
    </li>--}}
</ul>
