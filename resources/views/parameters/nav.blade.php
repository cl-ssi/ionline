<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('parameters.communes.index') }}">
            <i class="fas fa-home"></i> Comunas</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('parameters.establishments.index') }}">
            <i class="fas fa-hospital"></i> Establecimientos</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('parameters.holidays.index') }}">
            <i class="fas fa-suitcase"></i> Feriados</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('parameters.permissions.index', 'web') }}">
            <i class="fas fa-chalkboard-teacher"></i> Permisos Internos</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('parameters.permissions.index', 'external') }}">
            <i class="fas fa-external-link-alt"></i> Permisos Externos</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Request::is('parameters/roles*') ? 'active' : ''}}"
            href="{{ route('parameters.roles.index') }}">
            <i class="fas fa-chalkboard-teacher"></i> Roles</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('parameters.locations.index') }}">
            <i class="fas fa-home"></i> Ubicaciones</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('parameters.places.index') }}">
            <i class="fas fa-map-marker-alt"></i> Lugares</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('parameters.phrases.index') }}">
            <i class="fas fa-smile-beam"></i> Frases del día</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
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
    </li

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
    <!-- <li class="nav-item">
        <a class="nav-link"
            href="{{ route('parameters.values.index') }}">
            <i class="fas fa-money-bill-alt"></i> Valor Hora/Jornada</a>
    </li> -->
</ul>
