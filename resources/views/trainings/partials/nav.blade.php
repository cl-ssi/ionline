<ul class="nav nav-tabs">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fas fa-inbox"></i> Capacitaciones</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('trainings.create') }}"><i class="fas fa-plus fa-fw"></i> Nueva capacitación</a></li>
            <li><a class="dropdown-item" href="{{ route('trainings.own_index') }}"><i class="fas fa-users fa-fw"></i> Mis capacitaciones</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('trainings.all_index') }}"><i class="fas fa-users fa-fw"></i> Todas las capacitaciones</a></li>
        </ul>
    </li>
</ul>