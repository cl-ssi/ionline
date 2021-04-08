<ul class="nav nav-tabs mb-3 d-print-none">

    @role('Replacement Staff: admin')
    <li class="nav-item">
        <a class="nav-link"
                      href="{{ route('replacement_staff.index') }}">
            <i class="fas fa-inbox"></i> Listado Staff
        </a>
    </li>
    @endrole

    @role('Replacement Staff: admin|Replacement Staff: user')
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-inbox"></i> Solicitudes
        </a>
        <div class="dropdown-menu">
            @role('Replacement Staff: admin')
            <a class="dropdown-item" href="{{ route('replacement_staff.request.index') }}"><i class="fas fa-inbox"></i> Reclutamiento: Gestión de Solicitudes</a>
            <div class="dropdown-divider"></div>
            @endrole
            <a class="dropdown-item" href="{{ route('replacement_staff.request.own_index') }}"><i class="fas fa-inbox"></i> Mis Solicitudes</a>
            <a class="dropdown-item" href="{{ route('replacement_staff.request.ou_index') }}"><i class="fas fa-inbox"></i> Solicitudes de mi U.O.</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('replacement_staff.request.create') }}"><i class="fas fa-plus"></i> Nueva Solicitud</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('replacement_staff.request.to_sign') }}"><i class="fas fa-check-circle"></i> Gestión de Solicitudes</a>
       </div>
   </li>
    @endrole

    @role('Replacement Staff: admin')
    <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-cog"></i> Configuración
       </a>
       <div class="dropdown-menu">
           <a class="dropdown-item" href="{{ route('replacement_staff.manage.profession.index') }}">Profesiones</a>
           <a class="dropdown-item" href="{{ route('replacement_staff.manage.profile.index') }}">Perfiles</a>
       </div>
   </li>
   @endrole
</ul>
