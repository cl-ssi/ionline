<ul class="nav nav-tabs mb-3 d-print-none">

    @can('Replacement Staff: list rrhh')
    <li class="nav-item">
        <a class="nav-link"
                      href="{{ route('replacement_staff.index') }}">
            <i class="fas fa-inbox"></i> Listado Staff
        </a>
    </li>
    @endcan

    @canany(['Replacement Staff: create request',
             'Replacement Staff: technical evaluation',
             ''])

    {{-- @role('Replacement Staff: admin|Replacement Staff: user') --}}
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-inbox"></i> Solicitudes
        </a>
        <div class="dropdown-menu">
            @can('Replacement Staff: technical evaluation')
            <a class="dropdown-item" href="{{ route('replacement_staff.request.index') }}"><i class="fas fa-inbox"></i> Reclutamiento: Gestión de Solicitudes</a>
            @endcan
            @can('Replacement Staff: create request')
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('replacement_staff.request.own_index') }}"><i class="fas fa-inbox"></i> Mis Solicitudes</a>
            @endcan
            <a class="dropdown-item disabled" href="{{ route('replacement_staff.request.ou_index') }}"><i class="fas fa-inbox"></i> Solicitudes de mi U.O.</a>

            @can('Replacement Staff: create request')
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('replacement_staff.request.create') }}"><i class="fas fa-plus"></i> Nueva Solicitud</a>
            @endcan
            @can('Replacement Staff: create request')
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('replacement_staff.request.to_sign') }}">
                <i class="fas fa-check-circle"></i> Gestión de solicitudes
                {{-- @if(App\Models\ReplacementStaff\RequestReplacementStaff::getPendingRequestToSign() > 0) --}}
                    <!-- <span class="badge badge-secondary">{{-- App\Models\ReplacementStaff\RequestReplacementStaff::getPendingRequestToSign() --}} </span> -->
                {{-- @endif --}}
            </a>
            @endcan
       </div>
   </li>
    @endcan

    @canany(['Replacement Staff: manage'])
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-cog"></i> Configuración
        </a>
        <div class="dropdown-menu">
            @can('Replacement Staff: manage')
            <a class="dropdown-item" href="{{ route('replacement_staff.manage.profession.index') }}">Profesiones</a>
            <a class="dropdown-item" href="{{ route('replacement_staff.manage.profile.index') }}">Perfiles</a>
            @endcan
        </div>
   </li>
   @endrole
</ul>
