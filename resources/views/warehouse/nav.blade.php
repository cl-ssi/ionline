@if(Auth::user()->active_store)
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a
                class="nav-link"
                href="{{ route('warehouse.store.welcome') }}"
                role="button"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <i class="fas fa-home"></i> Mi Bodega
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link"
                aria-current="page"
                href="{{ route('warehouse.controls.index', ['store' => Auth::user()->active_store, 'type' => 'receiving']) }}"
            >
                <i class="fas fa-shopping-basket"></i> Ingreso
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link"
                aria-current="page"
                href="{{ route('warehouse.controls.index', ['store' => Auth::user()->active_store, 'type' => 'dispatch']) }}"
            >
                <i class="fas fa-shipping-fast"></i> Egreso
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle"
                data-toggle="dropdown"
                href="#"
                role="button"
                aria-expanded="false"
            >
                <i class="fas fa-cog"></i> Reportes
            </a>
            <div class="dropdown-menu">
                <a
                    class="dropdown-item"
                    href="{{ route('warehouse.control.report', Auth::user()->active_store) }}"
                >
                    <i class="fas fa-file-alt"></i> Reporte Bincard
                </a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle"
                data-toggle="dropdown"
                href="#"
                role="button"
                aria-expanded="false"
            >
                <i class="fas fa-cog"></i> Mantenedores
            </a>
            <div class="dropdown-menu">
                <a
                    class="dropdown-item"
                    href="{{ route('warehouse.products.index', Auth::user()->active_store) }}"
                >
                    <i class="fas fa-boxes"></i> Productos
                </a>
                <a
                    class="dropdown-item"
                    href="{{ route('warehouse.categories.index', Auth::user()->active_store) }}"
                >
                    <i class="fas fa-flag"></i> Categorías
                </a>
                <a
                    class="dropdown-item"
                    href="{{ route('warehouse.origins.index', Auth::user()->active_store) }}"
                >
                    <i class="fas fa-download"></i> Origenes
                </a>
                <a
                    class="dropdown-item"
                    href="{{ route('warehouse.destinations.index', Auth::user()->active_store) }}"
                >
                    <i class="fas fa-upload"></i> Destinos
                </a>
            </div>
        </li>
    </ul>
@endif
