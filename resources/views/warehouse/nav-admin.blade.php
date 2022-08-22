<ul class="nav nav-tabs mb-3">
    @can('Store')
        <li class="nav-item">
            <a
                class="nav-link {{ active('warehouse.stores.index') }}"
                href="{{ route('warehouse.stores.index') }}"
                role="button"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <i class="fas fa-home"></i> Todas las Bodegas
            </a>
        </li>
    @endcan
</ul>
