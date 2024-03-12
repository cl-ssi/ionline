<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ active('finance.receptions.index') }}"
            href="{{ route('finance.receptions.index') }}">
            <i class="bi bi-list"></i> 
            Listado de actas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('finance.receptions.create', ['control_id' => '0']) }}"
            aria-current="page"
            href="{{ route('finance.receptions.create', ['control_id' => '0']) }}">
            <i class="bi bi-file-plus"></i> 
            Nueva acta con OC
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('finance.receptions.create_no_oc') }}"
            href="{{ route('finance.receptions.create_no_oc') }}">
            <i class="bi bi-receipt"></i> 
            Nueva acta sin OC
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('finance.receptions.reject') }}"
            aria-current="page"
            href="{{ route('finance.receptions.reject') }}">
            <i class="bi bi-x-octagon"></i> 
            Rechazar
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('finance.dtes.cenabast') }}"
            aria-current="page"
            href="{{ route('finance.dtes.cenabast') }}">
            <i class="bi bi-prescription"></i> 
            Dtes Cenabast
        </a>
    </li>

    <li class="nav-item dropdown">
            <a
                class="nav-link dropdown-toggle"
                data-toggle="dropdown"
                data-bs-toggle="dropdown"
                href="#"
                role="button"
                aria-expanded="false"
            >
                <i class="bi bi-wrench"></i> Parametros
            </a>
            <div class="dropdown-menu">
                <a
                    class="dropdown-item"
                    href="{{ route('finance.receptions.parameters') }}"
                >
                        <i class="fas fa-envelope"></i> Email Notificación
                </a>
                <a
                    class="dropdown-item"
                    href="{{ route('finance.receptions.type') }}"
                >
                        <i class="fas fa-file-alt"></i> Tipo de Acta
                </a>
            </div>
    </li>
</ul>