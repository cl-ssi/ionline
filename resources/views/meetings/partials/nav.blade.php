{{--
<ul class="nav nav-tabs mb-3 d-print-none">

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ request()->routeIs('allowances.index*') || request()->routeIs('allowances.create*') || request()->routeIs('allowances.all_index*')  ? 'active' : '' }}" href="#" id="navbardrop" data-toggle="dropdown">
                <i class="fas fa-wallet"></i> Reuniones
            </a>

            <div class="dropdown-menu">
                <a class="dropdown-item {{ active(['allowances.index']) }}" href="{{ route('allowances.index') }}"><i class="fas fa-users fa-fw"></i> Mis reuniones</a>
            </div>
        </li>
</ul>
--}}

<ul class="nav nav-tabs">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fas fa-inbox fa-fw"></i> Reuniones</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('meetings.index') }}"><i class="fas fa-users fa-fw"></i> Mis reuniones</a></li>
            <li><a class="dropdown-item" href="{{ route('meetings.create') }}"><i class="fas fa-plus fa-fw"></i> Nueva reunión</a></li>
        </ul>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fas fa-inbox fa-fw"></i> Compromisos</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('meetings.commitments.own_index') }}"><i class="fas fa-inbox fa-fw"></i> Mis compromisos</a></li>
            <li><a class="dropdown-item" href="{{ route('meetings.commitments.all_index') }}"><i class="fas fa-inbox fa-fw"></i> Todos los compromisos</a></li>
        </ul>
    </li>
</ul>

<br>
