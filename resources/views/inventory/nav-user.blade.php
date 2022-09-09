<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a
            class="nav-link {{ active(['inventories.pending-movements', 'inventories.check-transfer']) }}"
            aria-current="page"
            href="{{ route('inventories.pending-movements') }}"
        >
            <i class="fas fa-list-alt"></i> Inventarios Pendientes
        </a>
    </li>

    <li class="nav-item">
        <a
            class="nav-link {{ active(['inventories.assigned-products', 'inventories.create-transfer']) }}"
            aria-current="page"
            href="{{ route('inventories.assigned-products') }}"
        >
            <i class="fas fa-list-alt"></i> Productos Asignados
        </a>
    </li>
</ul>
