<ul class="nav nav-tabs">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fas fa-inbox"></i> Solicitudes</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('purchase_plan.own_index') }}"><i class="fas fa-inbox"></i> Mis Plan de Compras</a></li>
            @if(auth()->user()->organizational_unit_id == App\Models\Parameters\Parameter::get('ou','FinanzasSSI') || auth()->user()->hasPermissionTo('Purchase Plan: all'))
                <li><a class="dropdown-item" href="{{ route('purchase_plan.all_index') }}"><i class="fas fa-inbox"></i> Todos los Plan de Compras</a></li>
            @endif
            <li><a class="dropdown-item" href="{{ route('purchase_plan.pending_index') }}"><i class="fas fa-inbox"></i> Pendientes de firmar</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('purchase_plan.create') }}"><i class="fas fa-plus"></i> Nuevo Plan de Compras</a></li>
        </ul>
    </li>
    
    @php
        $ouSearch = App\Models\Parameters\Parameter::get('Abastecimiento',['purchaser_ou_id']);
        $iAmAuthoritiesIn = array();
        foreach(App\Models\Rrhh\Authority::getAmIAuthorityFromOu(Carbon\Carbon::now(), 'manager', auth()->user()->id) as $authority){
            array_push($iAmAuthoritiesIn, $authority->organizational_unit_id);
        }
    @endphp

    @if(in_array(auth()->user()->organizational_unit_id, $ouSearch) || auth()->user()->hasPermissionTo('Request Forms: purchaser'))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-money-bill-alt fa-fw"></i> Compradores
            </a>
            <div class="dropdown-menu">
                @if(in_array(App\Models\Parameters\Parameter::get('ou', 'AbastecimientoSSI'), $iAmAuthoritiesIn))
                    <a class="dropdown-item" href="{{ route('purchase_plan.assign_purchaser_index') }}"><i class="fas fa-inbox fa-fw"></i> Asignación Plan de Compras</a>
                @endif
                <a class="dropdown-item" href="{{ route('purchase_plan.my_assigned_plans_index') }}"><i class="fas fa-inbox fa-fw"></i> Mis Plan de Compras asignados</a>
            </div>
        </li>
    @endif

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