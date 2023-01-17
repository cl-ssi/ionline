<ul class="nav nav-tabs mb-3">
    @if(auth()->user()->active_store)
        @can('Store')
            <li class="nav-item">
                <a
                    class="nav-link {{ active('warehouse.store.welcome') }}"
                    href="{{ route('warehouse.store.welcome') }}"
                    role="button"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    <i class="fas fa-home"></i> Mi Bodega
                </a>
            </li>
        @endcan
        @can('Store: list receptions')
            <li class="nav-item">
                <a
                    class="nav-link {{ request()->query('type') === 'receiving' ? 'active' : '' }} {{ active('warehouse.generate-reception') }}"
                    aria-current="page"
                    href="{{ route('warehouse.controls.index', [
                        'store' => auth()->user()->active_store,
                        'type' => 'receiving',
                        'nav' => 'nav',
                    ]) }}"
                >
                    <i class="fas fa-shopping-basket"></i> Ingreso
                </a>
            </li>
        @endcan
        @can('Store: list dispatchs')
            <li class="nav-item">
                <a
                    class="nav-link {{ request()->query('type') === 'dispatch' ? 'active' : '' }}"
                    aria-current="page"
                    href="{{ route('warehouse.controls.index', [
                        'store' => auth()->user()->active_store,
                        'type' => 'dispatch',
                        'nav' => 'nav',
                    ]) }}"
                >
                    <i class="fas fa-shipping-fast"></i> Egreso
                </a>
            </li>
        @endcan
        @can('Store: bincard report')
            <li class="nav-item dropdown">
                <a
                    class="nav-link dropdown-toggle  {{ active('warehouse.store.report') }}"
                    data-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                >
                    <i class="fas fa-clipboard"></i> Reportes
                </a>
                <div class="dropdown-menu">
                    <a
                        class="dropdown-item"
                        href="{{ route('warehouse.store.report', [
                            'store' => auth()->user()->active_store,
                            'nav' => 'nav'])
                        }}"
                    >
                        <i class="fas fa-file-alt"></i> Reporte Bincard
                    </a>
                </div>
            </li>
        @endcan
        @can('Store: maintainers')
            <li class="nav-item dropdown">
                <a
                    class="nav-link dropdown-toggle {{ active([
                        'warehouse.products.*',
                        'warehouse.categories.*',
                        'warehouse.origins.*',
                        'warehouse.destinations.*'
                    ]) }}"
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
                        href="{{ route('warehouse.products.index', [
                            'store' => auth()->user()->active_store,
                            'nav' => 'nav'])
                        }}"
                    >
                        <i class="fas fa-boxes"></i> Productos
                    </a>
                    <a
                        class="dropdown-item"
                        href="{{ route('warehouse.categories.index', [
                            'store' => auth()->user()->active_store,
                            'nav' => 'nav'])
                        }}"
                    >
                        <i class="fas fa-flag"></i> Categorías
                    </a>
                    <a
                        class="dropdown-item"
                        href="{{ route('warehouse.origins.index', [
                            'store' => auth()->user()->active_store,
                            'nav' => 'nav'])
                        }}"
                    >
                        <i class="fas fa-download"></i> Origenes
                    </a>
                    <a
                        class="dropdown-item"
                        href="{{ route('warehouse.destinations.index', [
                            'store' => auth()->user()->active_store,
                            'nav' => 'nav'])
                        }}"
                    >
                        <i class="fas fa-upload"></i> Destinos
                    </a>
                </div>
            </li>
        @endcan
    @endif

    @can('Store: add invoice')
        <li class="nav-item">
            <a
                class="nav-link {{ active('warehouse.invoice-management') }}"
                aria-current="page"
                href="{{ route('warehouse.invoice-management', [
                    'store' => auth()->user()->active_store,
                    'nav' => 'nav'
                ]) }}"
            >
                <i class="fas fa-file-invoice-dollar"></i> Facturas
            </a>
        </li>
    @endcan
</ul>
