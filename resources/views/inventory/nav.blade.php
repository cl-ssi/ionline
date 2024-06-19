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
                class="nav-link"
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

        @can('Inventory: manager')
            <li class="nav-item">
                <a
                    class="nav-link {{ active(['inventories.fusion', 'inventories.fusion']) }}"
                    aria-current="page"
                    href="{{ route('inventories.fusion', $establishment) }}"
                >
                    <i class="fas fa-fw fa-compress-alt"></i> Fusión
                </a>
            </li>
        @endcan
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
        
        <li class="nav-item">
            <a
                class="nav-link {{ active(['inventories.sheet']) }}"
                href="{{ route('inventories.sheet') }}"
            >
            <i class="fas fa-chalkboard"></i> Planilla Mural
            </a>
        </li>
        
        <li class="nav-item">
            <a
                class="nav-link {{ active(['inventories.accounting-update']) }}"
                href="{{ route('inventories.accounting-update') }}"
            >
            <i class="fas fa-dollar-sign"></i> Actualización Contable
            </a>
        </li>

        @can('be god')
            <li class="nav-item">
                <a
                    class="nav-link {{ active(['inventories.massive-update-pma']) }}"
                    href="{{ route('inventories.massive-update-pma') }}"
                >
                <i class="fas fa-sync-alt"></i> Actualización Masiva Emplazamiento
                </a>
            </li>
        @endcan 
        
        
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
                    href="{{ route('inventories.removal-request-mgr') }}"
                >
                    <i class="fas fa-fw fa-minus-circle"></i> Solicitudes de Baja de Inventario
                </a>
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
