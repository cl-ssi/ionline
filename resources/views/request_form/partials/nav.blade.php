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
</ul>
