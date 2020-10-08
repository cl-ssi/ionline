<ul class="nav nav-tabs mb-3 small">

    <li class="nav-item">
        <a class="nav-link {{ active('programmings.index') }}" href="{{ route('programmings.index') }}">
        <i class="fas fa-file-invoice-dollar"></i> Programación Operativa</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('professionals.index') }}" href="{{ route('professionals.index') }}">
        <i class="fas fa-users"></i> Profesionales</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('actiontypes.index') }}" href="{{ route('actiontypes.index') }}">
        <i class="fas fa-file"></i> Tipos de Acciones</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('ministerialprograms.index') }}" href="{{ route('ministerialprograms.index') }}">
        <i class="fas fa-directions"></i> Programas Ministeriales</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('activityprograms.index') }}" href="{{ route('activityprograms.index') }}">
        <i class="fas fa-box"></i> Prestaciones o Actividades</a>
    </li>
</ul>
