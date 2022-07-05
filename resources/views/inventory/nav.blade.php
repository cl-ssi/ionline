<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a
            class="nav-link {{ active('inventories.index') }}"
            aria-current="page"
            href="{{ route('inventories.index') }}"
        >
            <i class="fas fa-list-alt"></i> Inventario
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link {{ active('inventories.last-income') }}"
            href="{{ route('inventories.last-income') }}"
        >
        <i class="fas fa-clock"></i> Últimos Ingresos a Bodega
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link {{ active('inventories.pending-inventory') }}"
            href="{{ route('inventories.pending-inventory') }}"
        >
            <i class="fas fa-hourglass"></i> Bandeja Pendiente de Inventario
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link {{ active('inventories.details') }}"
            href="{{ route('inventories.details') }}"
        >
            <i class="fas fa-edit"></i> Item Inventario (ejemplo)
        </a>
    </li>
</ul>