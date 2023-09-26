<ul class="nav nav-tabs">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fas fa-inbox"></i> Solicitudes</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('purchase_plan.own_index') }}"><i class="fas fa-inbox"></i> Mis Plan de Compras</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('purchase_plan.create') }}"><i class="fas fa-plus"></i> Nuevo Plan de Compras</a></li>
        </ul>
    </li>

    {{--

    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#">Solicitudes</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Dropdown</a>
        <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Separated link</a></li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled">Disabled</a>
    </li>
    --}}
</ul>

<br>