<ul class="nav nav-tabs">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fas fa-inbox fa-fw"></i> Reuniones</a>
        <ul class="dropdown-menu">
            @can('Meetings: create')
                <li><a class="dropdown-item" href="{{ route('meetings.create') }}"><i class="fas fa-plus fa-fw"></i> Nueva reunión</a></li>
                <div class="dropdown-divider"></div>
            @endcan
            <li><a class="dropdown-item" href="{{ route('meetings.index') }}"><i class="fas fa-users fa-fw"></i> Mis reuniones</a></li>
            @can('Meetings: all meetings')
                <li><a class="dropdown-item" href="{{ route('meetings.all_index') }}"><i class="fas fa-users fa-fw"></i> Todas las reuniones</a></li>
            @endcan
        </ul>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fas fa-inbox fa-fw"></i> Compromisos</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('meetings.commitments.own_index') }}"><i class="fas fa-inbox fa-fw"></i> Mis compromisos</a></li>
            @can('Meetings: all commitments')
                <li><a class="dropdown-item" href="{{ route('meetings.commitments.all_index') }}"><i class="fas fa-inbox fa-fw"></i> Todos los compromisos</a></li>
            @endcan
        </ul>
    </li>
</ul>

<br>
