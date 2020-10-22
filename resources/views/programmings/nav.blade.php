<ul class="nav nav-tabs mb-3 small">

    <li class="nav-item">
        <a class="nav-link text-info" href="{{ route('programmings.index') }}">
        <i class="fas fa-file-invoice-dollar"></i> Programación Operativa</a>
    </li>
    @can('Programming: create professional')
    <li class="nav-item">
        <a class="nav-link text-info" href="{{ route('professionals.index') }}">
        <i class="fas fa-users"></i> Profesionales</a>
    </li>
    @endcan
    @can('Programming: create action type')
    <li class="nav-item">
        <a class="nav-link text-info" href="{{ route('actiontypes.index') }}">
        <i class="fas fa-file"></i> Tipos de Acciones</a>
    </li>
    @endcan
    @can('Programming: create ministerial')
    <li class="nav-item">
        <a class="nav-link text-info" href="{{ route('ministerialprograms.index') }}">
        <i class="fas fa-directions"></i> Programas Ministeriales</a>
    </li>
    @endcan
    @can('Programming: create activity')
    <li class="nav-item">
        <a class="nav-link text-info" href="{{ route('activityprograms.index') }}">
        <i class="fas fa-box"></i> Prestaciones o Actividades</a>
    </li>
    @endcan
</ul>
