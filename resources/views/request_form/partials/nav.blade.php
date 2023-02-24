<ul class="nav nav-tabs mb-3 d-print-none">
  <!-- <li class="nav-item active">
      <a class="nav-link"
          href="{{ route('request_forms.my_forms') }}">
          <i class="fas fa-inbox"></i> Mis Formularios
      </a>
  </li> -->

  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-file-alt"></i> Formularios
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
      <a class="dropdown-item" href="{{ route('request_forms.my_forms') }}"><i class="fas fa-inbox"></i> Mis Formularios</a>
      @php($ouSearch = App\Models\Parameters\Parameter::where('module', 'ou')->where('parameter', 'FinanzasSSI')->first()->value)
      @if(Auth::user()->hasPermissionTo('Request Forms: all') || Auth()->user()->organizational_unit_id == $ouSearch)
      <a class="dropdown-item" href="{{ route('request_forms.all_forms') }}"><i class="fas fa-inbox"></i> Todos los formularios</a>
      @endif
      <a class="dropdown-item" href="{{ route('request_forms.pending_forms') }}"><i class="fas fa-inbox"></i>
        {{-- @if(App\Models\RequestForms\RequestForm::getPendingRequestToSign() > 0)
            <span class="badge badge-secondary">{{ App\Models\ReplacementStaff\RequestReplacementStaff::getPendingRequestToSign() }} </span>
        @endif --}}
        Pendientes por firmar
      </a>
      <a class="dropdown-item" href="{{ route('request_forms.contract_manager_forms') }}"><i class="fas fa-inbox"></i> Admin. de contratos</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{ route('request_forms.items.create') }}"><i class="fas fa-file-alt"></i> Bienes y/o Servicios</a>
      <a class="dropdown-item" href="{{ route('request_forms.passengers.create') }}"><i class="fas fa-ticket-alt"></i> Pasajes Aéreos</a>
    </div>
  </li>

  @php($ouSearch = App\Models\Parameters\Parameter::where('module', 'ou')->whereIn('parameter', ['AbastecimientoSSI', 'AbastecimientoHAH', 'AdquisicionesHAH'])->pluck('value')->toArray())
  @if(in_array(Auth()->user()->organizational_unit_id, $ouSearch) || Auth::user()->hasPermissionTo('Request Forms: purchaser'))
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-file-alt"></i> Abastecimiento
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="{{ route('request_forms.supply.index') }}"><i class="fas fa-inbox"></i> Comprador</a>
      </div>
    </li>
  @endif

  @php($ouSearch = App\Models\Parameters\Parameter::where('module', 'ou')->whereIn('parameter', ['AbastecimientoSSI', 'AbastecimientoHAH', 'AdquisicionesHAH', 'FinanzasSSI'])->pluck('value')->toArray())
	@if(in_array(Auth()->user()->organizational_unit_id, $ouSearch) || Auth::user()->hasPermissionTo('Request Forms: config'))
	<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="fas fa-file-alt"></i> Parámetros
	</a>
	<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
		<a class="dropdown-item" href="{{ route('parameters.budgetitems.index') }}">
			<i class="fas fa-fw fa-file-invoice-dollar"></i> Item Presupuestario
		</a>
		<a class="dropdown-item" href="{{ route('parameters.measurements.index') }}">
			<i class="fas fa-fw fa-ruler-combined"></i> Unidades de Medida
		</a>
		<a class="dropdown-item" href="{{ route('parameters.purchasemechanisms.index') }}">
			<i class="fas fa-fw fa-shopping-cart"></i> Mecanismos de Compra
		</a>
		<a class="dropdown-item" href="{{ route('parameters.purchasetypes.index') }}">
			<i class="fas fa-fw fa-shopping-cart"></i> Tipos de Compra
		</a>
		<a class="dropdown-item" href="{{ route('parameters.purchaseunits.index') }}">
			<i class="fas fa-fw fa-shopping-cart"></i> Unidades de Compra
		</a>
		<a class="dropdown-item" href="{{ route('parameters.suppliers.index') }}">
			<i class="fas fa-fw fa-truck"></i> Proveedores
		</a>
	</div>
	</li>
	@endif
	</ul>
