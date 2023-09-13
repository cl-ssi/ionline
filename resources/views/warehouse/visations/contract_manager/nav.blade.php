<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ $tray === null ? 'active' : '' }}" href="{{ route('warehouse.visation_contract_manager.index') }}">Visaciones Pendientes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $tray === 'aprobados' ? 'active' : '' }}" href="{{ route('warehouse.visation_contract_manager.index', ['tray' => 'aprobados']) }}">Visaciones Aprobadas</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $tray === 'rechazados' ? 'active' : '' }}" href="{{ route('warehouse.visation_contract_manager.index', ['tray' => 'rechazados']) }}">Visaciones Rechazadas</a>
    </li>
</ul>
