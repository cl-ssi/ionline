<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ active('finance.receptions.index') }}"
            href="{{ route('finance.receptions.index') }}">
            <i class="bi bi-list"></i> 
            Listado de actas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('finance.receptions.create') }}"
            aria-current="page"
            href="{{ route('finance.receptions.create') }}">
            <i class="bi bi-file-plus"></i> 
            Nueva acta con OC
        </a>
    </li>
    @can('be god')
    <li class="nav-item">
        <a class="nav-link {{ active('finance.receptions.create_no_oc') }}"
            href="{{ route('finance.receptions.create_no_oc') }}">
            <i class="bi bi-receipt"></i> 
            Nueva acta sin OC
        </a>
    </li>
    @endcan
    <li class="nav-item">
        <a class="nav-link {{ active('finance.receptions.reject') }}"
            aria-current="page"
            href="{{ route('finance.receptions.reject') }}">
            <i class="bi bi-x-octagon"></i> 
            Rechazar
        </a>
    </li>
</ul>
