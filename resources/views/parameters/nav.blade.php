@role('god')
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{active('parameters.communes.index')}}"
            href="{{ route('parameters.communes.index') }}">
            <i class="fas fa-home"></i> Comunas</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{active('parameters.establishments.index')}}"
            href="{{ route('parameters.establishments.index') }}">
            <i class="fas fa-hospital"></i> Establecimientos</a>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{active('parameters.permissions.index')}}"
            data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-clipboard-check"></i> Permisos
        </a>

        <div class="dropdown-menu">
            <a class="dropdown-item"
                href="{{ route('parameters.permissions.index', 'web') }}">
                <i class="fas fa-chalkboard-teacher"></i> Internos
            </a>

            <a class="dropdown-item"
                href="{{ route('parameters.permissions.index', 'external') }}">
                <i class="fas fa-external-link-alt"></i> Externos
            </a>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link {{active('parameters.holidays.index')}}"
            href="{{ route('parameters.holidays.index') }}">
            <i class="fas fa-suitcase"></i> Feriados</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Request::is('parameters/roles*') ? 'active' : ''}}"
            href="{{ route('parameters.roles.index') }}">
            <i class="fas fa-chalkboard-teacher"></i> Roles</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{active('parameters.locations.index')}}"
            href="{{ route('parameters.locations.index') }}">
            <i class="fas fa-home"></i> Ubicaciones</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{active('parameters.places.index')}}"
            href="{{ route('parameters.places.index') }}">
            <i class="fas fa-map-marker-alt"></i> Lugares</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{active('parameters.phrases.index')}}"
            href="{{ route('parameters.phrases.index') }}">
            <i class="fas fa-smile-beam"></i> Frases del día</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{active('parameters.professions.index')}}"
            href="{{ route('parameters.professions.index') }}">
            <i class="fas fa-external-link-alt"></i> Profesiones</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('parameters.budgetitems.index') }}">
            <i class="fas fa-file-invoice-dollar"></i> Item Presupuestario</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('parameters.measurements.index') }}">
            <i class="fas fa-ruler-combined"></i> Unidades de Medida</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('parameters.purchasemechanisms.index') }}">
            <i class="fas fa-shopping-cart"></i> Mecanismos de Compra</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('parameters.purchasetypes.index') }}">
            <i class="fas fa-shopping-cart"></i> Tipos de Compra</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('parameters.purchaseunits.index') }}">
            <i class="fas fa-shopping-cart"></i> Unidades de Compra</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('parameters.suppliers.index') }}">
            <i class="fas fa-shopping-cart"></i> Proveedores</a>
    </li>
    <!-- <li class="nav-item">
        <a class="nav-link"
            href="{{ route('parameters.values.index') }}">
            <i class="fas fa-money-bill-alt"></i> Valor Hora/Jornada</a>
    </li> -->
</ul>
@endrole
