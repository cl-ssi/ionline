<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ active('finance.receptions.index') }}"
            href="{{ route('finance.receptions.index') }}">Listado de actas</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('finance.receptions.create') }}"
            aria-current="page"
            href="{{ route('finance.receptions.create') }}">Nueva acta con OC</a>
    </li>
    <li class="nav-item">
        <a class="nav-link"
            href="#">Nueva acta sin OC</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('finance.receptions.reject') }}"
            aria-current="page"
            href="{{ route('finance.receptions.reject') }}">Rechazar</a>
    </li>
</ul>
