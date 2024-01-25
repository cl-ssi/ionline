<ul class="nav nav-tabs">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fas fa-inbox"></i> Solicitudes</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('purchase_plan.own_index') }}"><i class="fas fa-inbox"></i> Mis Plan de Compras</a></li>
            @can('Purchase Plan: all')
                <li><a class="dropdown-item" href="{{ route('purchase_plan.all_index') }}"><i class="fas fa-inbox"></i> Todos los Plan de Compras</a></li>
            @endcan
            {{--<li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('purchase_plan.create') }}"><i class="fas fa-plus"></i> Nuevo Plan de Compras</a></li>--}}
        </ul>
    </li>
    @can('Purchase Plan: reports')
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-chart-line"></i> Reportes
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('purchase_plan.reports.show_ppl_items') }}"><i class="fas fa-fw fa-list-ol"></i> Plan de Compras - Items</a>
        </div>
    </li>
    @endcan
</ul>

<br>