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
      <a class="dropdown-item" href="{{ route('request_forms.pending_forms') }}"><i class="fas fa-inbox"></i> Pendientes por firmar</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{ route('request_forms.items.create') }}"><i class="fas fa-file-alt"></i> Bienes y/o Servicios</a>
      <a class="dropdown-item" href="{{ route('request_forms.passengers.create') }}"><i class="fas fa-ticket-alt"></i> Pasajes Aéreos</a>
    </div>
  </li>

  @if(Auth()->user()->organizational_unit_id == 37)
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-file-alt"></i> Abastecimiento
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="{{ route('request_forms.supply.index') }}"><i class="fas fa-inbox"></i> Comprador</a>
        <!-- <div class="dropdown-divider"></div> -->
      </div>
    </li>
  @endif

  @if(App\Rrhh\Authority::getAuthorityFromDate(37, Carbon\Carbon::now(), 'manager')->user_id == Auth::user()->id ||
    Auth::user()->hasPermissionTo('Request Forms: config'))
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-file-alt"></i> Parámetros
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
      <a class="dropdown-item" href="{{ route('parameters.budgetitems.index') }}">
          <i class="fas fa-file-invoice-dollar"></i> Item Presupuestario
      </a>
      <a class="dropdown-item" href="{{ route('parameters.measurements.index') }}">
          <i class="fas fa-ruler-combined"></i> Unidades de Medida
      </a>
      <a class="dropdown-item" href="{{ route('parameters.purchasemechanisms.index') }}">
          <i class="fas fa-shopping-cart"></i> Mecanismos de Compra
      </a>
      <a class="dropdown-item" href="{{ route('parameters.purchasetypes.index') }}">
          <i class="fas fa-shopping-cart"></i> Tipos de Compra
      </a>
      <a class="dropdown-item" href="{{ route('parameters.purchaseunits.index') }}">
          <i class="fas fa-shopping-cart"></i> Unidades de Compra
      </a>
      <a class="dropdown-item" href="{{ route('parameters.suppliers.index') }}">
          <i class="fas fa-truck"></i> Proveedores
      </a>
    </div>
  </li>
  @endif

  <!-- <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-dice-d6"></i> Bienes y/o Servicios
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
      <a class="dropdown-item" href="{{ route('request_forms.create') }}"><i class="fab fa-think-peaks"></i> Bienes y/o Servicios (Ejecución Inmediata)</a>
      <a class="dropdown-item" href="#"><i class="fas fa-handshake"></i> Pago de Bienes y Servicios</a>
      <a class="dropdown-item" href="#"><i class="fas fa-hourglass-half"></i> Bienes y/o Servicios (Ejecución en el Tiempo)</a>
    </div>
  </li> -->

<!--
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-inbox"></i> Solicitudes Pendientes
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
      <a class="dropdown-item" href="{{ route('request_forms.my_forms') }}"><i class="fas fa-ticket-alt"></i> Bienes y/o Servicios</a>
    </div>
  </li>
-->




    <!--
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('request_forms.my_request_inbox') }}">
            <i class="fas fa-inbox"></i> Mis Solicitudes
            <span class="badge badge-secondary">{{ App\Utilities::getPendingSignature() }}</span></a>
        </a>
    </li>
  -->
    <!-- <li class="nav-item">
        <a class="nav-link"
            href="{{ route('request_forms.leadership_index') }}">
            <i class="fas fa-inbox"></i> Jefatura
            <span class="badge badge-secondary">{{ App\Utilities::getPendingSignatureAuthorize() }}</span></a>
        </a>
    </li>
    @if(App\Utilities::getAmIDirector() == 1)
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('request_forms.director_inbox') }}">
            <i class="fas fa-inbox"></i> Director
            <span class="badge badge-secondary">{{ App\Utilities::getPendingDirectorAuthorize() }}</span></a>
        </a>
    </li>
    @endif

    <li class="nav-item">
        <a class="nav-link" href="{{ route('request_forms.prefinance_index') }}">
          <i class="fas fa-inbox"></i> Refrendación P.
        </a>
    </li>



    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('request_forms.finance_index') }}">
            <i class="fas fa-inbox"></i> Finanzas
            <span class="badge badge-secondary">{{ App\Utilities::getPendingDirectorAuthorize() }}</span></a>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('request_forms.supply_index') }}">
            <i class="fas fa-inbox"></i> Abastecimiento
            <span class="badge badge-secondary"></span></a>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('request_forms.supervisor_user_index') }}">
            <i class="fas fa-inbox"></i> Comprador
            <span class="badge badge-secondary"></span></a>
        </a>
    </li> -->

</ul>
