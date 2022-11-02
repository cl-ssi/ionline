<ul class="nav nav-tabs mb-3 d-print-none">
    {{-- @canany(['Replacement Staff: list rrhh', 'Replacement Staff: staff manage']) --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                <i class="fas fa-wallet"></i> Viáticos
            </a>

            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('allowances.index') }}"><i class="fas fa-wallet"></i> Mis víaticos</a>
                <a class="dropdown-item" href="{{ route('allowances.create') }}"><i class="fas fa-plus"></i> Nueva Solicitud</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('allowances.sign_index') }}"><i class="fas fa-check-circle"></i> Gestión de viáticos</a>
           </div>
        </li>
    {{-- @endcan --}}
</ul>
