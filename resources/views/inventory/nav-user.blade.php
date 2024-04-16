<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a
            class="nav-link {{ active(['inventories.pending-movements', 'inventories.check-transfer']) }}"
            aria-current="page"
            href="{{ route('inventories.pending-movements') }}"
        >
            <i class="fas fa-list-alt"></i> Movimientos Pendientes
        </a>
    </li>

    <li class="nav-item">
        <a
            class="nav-link {{ active(['inventories.assigned-products', 'inventories.create-transfer', 'inventories.register']) }}"
            aria-current="page"
            href="{{ route('inventories.assigned-products') }}"
        >
            <i class="fas fa-boxes"></i> Mi inventario
        </a>
    </li>

    <li class="nav-item">
        <a
            class="nav-link {{ active(['inventories.update-pma']) }}"
            aria-current="page"
            href="{{ route('inventories.update-pma') }}"
        >
            <i class="fas fa-sync-alt"></i> Actualización Emplazamiento
        </a>
    </li>

    <li class="nav-item">
        <a
            class="nav-link {{ active(['parameters.places.index']) }}"
            aria-current="page"
            target="_blank"
            href="{{ route('parameters.places.index', auth()->user()->organizationalUnit->establishment) }}"
        >
            <i class="fas fa-fw fa-map-marker-alt"></i> Lugares (oficinas)
        </a>
    </li>
</ul>
