<ul class="nav nav-tabs mb-3 d-print-none">

    @can('Drugs: view receptions')
    <li class="nav-item">
        <a class="nav-link {{ active('drugs.receptions.index') }}"
                      href="{{ route('drugs.receptions.index') }}">
            <i class="fas fa-inbox"></i> Actas de Recepción
        </a>
    </li>
    @endcan

    @can('Drugs: edit receptions')
    <li class="nav-item">
        <a class="nav-link {{ active('drugs.receptions.create') }}"
                      href="{{ route('drugs.receptions.create') }}">
            <i class="fas fa-plus"></i> Agregar nueva
        </a>
    </li>
    @endcan

    @can('Drugs: view reports')
    <li class="nav-item">
        <a class="nav-link {{ active('drugs.receptions.report') }}"
                      href="{{ route('drugs.receptions.report') }}">
            <i class="fas fa-file-invoice"></i> Reporte
        </a>
    </li>
    @endcan

    @can('Drugs: manage parameters')
    <li class="nav-item">
        <a class="nav-link {{ active('parameters.drugs') }}"
                      href="{{ route('parameters.drugs') }}">
            <i class="fas fa-cog"></i> Parametros
        </a>
    </li>
    @endcan

    @can('Drugs: manage substances')
    <li class="nav-item">
        <a class="nav-link {{ active('drugs.substances.index') }}"
                      href="{{ route('drugs.substances.index') }}">
            <i class="fas fa-cog"></i> Sustancias
        </a>
    </li>
    @endcan

    @can('Drugs: manage courts')
    <li class="nav-item">
        <a class="nav-link {{ active('drugs.courts.index') }}"
                      href="{{ route('drugs.courts.index') }}">
            <i class="fas fa-cog"></i> Juzgados
        </a>
    </li>
    @endcan

    @can('Drugs: manage police units')
    <li class="nav-item">
        <a class="nav-link {{ active('drugs.police_units.index') }}"
                      href="{{ route('drugs.police_units.index') }}">
            <i class="fas fa-cog"></i> Unidades Policiales
        </a>
    </li>
    @endcan

    @can('Drugs')
    <li class="nav-item">
        <a class="nav-link {{ active('drugs.users') }}"
                      href="{{ route('drugs.users') }}">
            <i class="fas fa-user"></i> 
        </a>
    </li>
    @endcan

</ul>
