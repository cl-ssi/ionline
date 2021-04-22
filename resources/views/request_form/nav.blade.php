<ul class="nav nav-tabs mb-3 d-print-none">

  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-dice-d6"></i> Bienes y/o Servicios
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
      <a class="dropdown-item" href="{{ route('request_forms.create') }}"><i class="fab fa-think-peaks"></i> Bienes y/o Servicios (Ejecución Inmediata)</a>
      <a class="dropdown-item" href="#"><i class="fas fa-handshake"></i> Pago de Bienes y Servicios</a>
      <a class="dropdown-item" href="#"><i class="fas fa-hourglass-half"></i> Bienes y/o Servicios (Ejecución en el Tiempo)</a>
    </div>
  </li>


  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-plane"></i> Pasajes Aéreos
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
      <a class="dropdown-item" href="{{ route('request_forms.passages.create') }}"><i class="fas fa-ticket-alt"></i> Solicitud de Cotización Pasajes Aéreos</a>
      <a class="dropdown-item" href="{{ route('request_forms.passages.index') }}"><i class="fas fa-archive"></i> Selección de Pasajes Aéreos</a>
    </div>
  </li>


  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-inbox"></i> Solicitudes Pendientes
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
      <a class="dropdown-item" href="{{ route('request_forms.index') }}"><i class="fas fa-ticket-alt"></i> Bienes y/o Servicios</a>
      <a class="dropdown-item" href="{{ route('request_forms.passages.index') }}"><i class="fas fa-archive"></i> Cotización de Pasajes Aéreos</a>
      <a class="dropdown-item" href="{{ route('request_forms.passages.index') }}"><i class="fas fa-archive"></i> Compra de Pasajes Aéreos</a>
    </div>
  </li>




    <li class="nav-item active">
        <a class="nav-link"
            href="{{ route('request_forms.index') }}">
            <i class="fas fa-inbox"></i> Mis Formularios
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('request_forms.my_request_inbox') }}">
            <i class="fas fa-inbox"></i> Mis Solicitudes
            <span class="badge badge-secondary">{{ App\Utilities::getPendingSignature() }}</span></a>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('request_forms.authorize_inbox') }}">
            <i class="fas fa-inbox"></i> Autorizar
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
    @can('Request Forms: Finance add item code')
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('request_forms.finance_inbox') }}">
            <i class="fas fa-inbox"></i> Finanzas
            <span class="badge badge-secondary">{{ App\Utilities::getPendingDirectorAuthorize() }}</span></a>
        </a>
    </li>
    @endcan
    @can('Request Forms: supplying')
    <li class="nav-item">
        <a class="nav-link"
            href="">
            <i class="fas fa-inbox"></i> Abastecimiento
            <span class="badge badge-secondary"></span></a>
        </a>
    </li>
    @endcan
</ul>
