<ul class="nav nav-tabs mb-3 d-print-none">
    @can('Inventory: last receptions')
        <li class="nav-item">
            <a
                class="nav-link {{ active('inventories.last-receptions') }}"
                href="{{ route('inventories.last-receptions', $establishment) }}"
            >
            <i class="fas fa-warehouse"></i> Últimos Ingresos a Bodega
            </a>
        </li>
    @endcan

    @can('Inventory: pending inventory')
        <li class="nav-item">
            <a
                class="nav-link {{ active(['inventories.pending-inventory', 'inventories.edit']) }}"
                href="{{ route('inventories.pending-inventory', $establishment) }}"
            >
                <i class="fas fa-qrcode"></i> Pendientes de Inventariar
            </a>
        </li>
    @endcan

    @can('Inventory: index')
        <li class="nav-item">
            <a
                class="nav-link {{ active(['inventories.index', 'inventories.register']) }}"
                aria-current="page"
                href="{{ route('inventories.index', $establishment) }}"
            >
                <i class="fas fa-fw fa-clipboard-list"></i> Inventario
            </a>
        </li>
    @endcan

    @can('Inventory: manager')
        <li class="nav-item">
            <a
                class="nav-link {{ active(['inventories.print-code-queue']) }}"
                href="{{ route('inventories.print-code-queue', $establishment) }}"
            >
                <i class="fas fa-print"></i> Cola de impresión
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link {{ active(['inventories.upload-excel']) }}"
                href="{{ route('inventories.upload-excel', $establishment) }}"
            >
                <i class="fas fa-file-excel"></i> Carga Excel
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link {{ active(['inventories.transfer']) }}"
                href="{{ route('inventories.transfer') }}"
            >
                <i class="fas fa-exchange-alt"></i> Traspaso Masivo
            </a>
        </li>
    @endcan

    @can('Inventory: place maintainer')
    <li class="nav-item dropdown">
            <a
                class="nav-link dropdown-toggle  {{ active('inventories.places', $establishment) }}"
                data-toggle="dropdown"
                data-bs-toggle="dropdown"
                href="#"
                role="button"
                aria-expanded="false"
            >
                <i class="fas fa-cog"></i>
            </a>
            <div class="dropdown-menu">
                <a
                    class="dropdown-item"
                    href="{{ route('inventories.places', $establishment) }}"
                >
                    <i class="fas fa-fw fa-file-alt"></i> Lugares
                </a>
                <a
                    class="dropdown-item"
                    href="{{ route('parameters.accounting-codes') }}"
                >
                    <i class="fas fa-fw fa-file-alt"></i> Cuentas Contables
                </a>
                <a
                    class="dropdown-item"
                    href="{{ route('inventories.clasification-mgr') }}"
                >
                    <i class="fas fa-fw fa-tags"></i> Clasificación de productos
                </a>
            </div>
        </li>
    @endcan
</ul>
