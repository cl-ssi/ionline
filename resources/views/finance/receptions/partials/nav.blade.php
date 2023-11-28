<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ active('finance.receptions.index') }}"
            href="{{ route('finance.receptions.index') }}">Listado de actas</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('finance.receptions.create') }}"
            aria-current="page"
            href="{{ route('finance.receptions.create') }}">Nueva con Orden de Compra</a>
    </li>
    <li class="nav-item">
        <a class="nav-link"
            href="#">Nueva Sin Orden de Compra</a>
    </li>
</ul>
