<ul class="nav nav-tabs mb-3 d-print-none">

    @canany(['Replacement Staff: list rrhh', 'Replacement Staff: staff manage'])
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                <i class="fas fa-user"></i> Staff
            </a>

            <div class="dropdown-menu">
              @can('Replacement Staff: list rrhh')
                    <a class="dropdown-item" href="{{ route('replacement_staff.index') }}"><i class="fas fa-user"></i> Listado Staff</a>
              @endcan
              @can('Replacement Staff: staff manage')
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('replacement_staff.staff_manage.index') }}"><i class="fas fa-cog fa-fw"></i> Gestión de Staff</a>
                    @foreach(App\Models\ReplacementStaff\StaffManage::getStaffByOu() as $staff)
                        <a class="dropdown-item" href="{{ route('replacement_staff.staff_manage.edit', ['id' => $staff->organizationalUnit]) }}"><i class="fas fa-home"></i> {{ $staff->organizationalUnit->name }}</a>
                    @endforeach
              @endcan
           </div>
        </li>
    @endcan

    @if(Auth::user()->hasPermissionTo('Replacement Staff: create request') ||
        Auth::user()->hasPermissionTo('Replacement Staff: technical evaluation') ||
        App\Rrhh\Authority::getAmIAuthorityFromOu(Carbon\Carbon::now(), 'manager', auth()->user()->id)->count() > 0 ||
        Auth::user()->hasRole('Replacement Staff: personal sign'))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                <i class="fas fa-inbox"></i> Solicitudes
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('replacement_staff.request.own_index') }}"><i class="fas fa-inbox"></i> Mis Solicitudes</a>

                <a class="dropdown-item" href="{{ route('replacement_staff.request.ou_index') }}"><i class="fas fa-inbox"></i> Solicitudes de mi U.O.</a>
                
                @can('Replacement Staff: create request')
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header">Crear Solicitudes</h6>
                    <a class="dropdown-item" href="{{ route('replacement_staff.request.create_replacement') }}"><i class="fas fa-plus"></i> Formulario de Reemplazos</a>
                    <a class="dropdown-item" href="{{ route('replacement_staff.request.create_announcement') }}"><i class="fas fa-plus"></i> Formulario de Convocatorias</a>
                @endif
                @if(App\Rrhh\Authority::getAmIAuthorityFromOu(Carbon\Carbon::today(), 'manager', auth()->user()->id)->count() > 0 ||
                    Auth::user()->hasRole('Replacement Staff: personal sign'))
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('replacement_staff.request.to_sign') }}">
                    <i class="fas fa-check-circle"></i> Gestión de solicitudes
                </a>
                @endif
           </div>
       </li>
    @endif

    @canany(['Replacement Staff: assign request', 'Replacement Staff: technical evaluation'])
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-users"></i> Reclutamiento
        </a>

        <div class="dropdown-menu">
            @can('Replacement Staff: assign request')
            <a class="dropdown-item" href="{{ route('replacement_staff.request.index') }}"><i class="fas fa-user-tag"></i> Asignar Solicitud</a>
            @endcan
            @can('Replacement Staff: technical evaluation')
            <a class="dropdown-item" href="{{ route('replacement_staff.request.assign_index') }}"><i class="fas fa-inbox"></i> Reclutamiento: Evaluación Técnica</a>
            @endcan
        </div>
    </li>
    @endcan

    @if(Auth::user()->hasPermissionTo('Replacement Staff: view requests') ||
      Auth::user()->hasRole('Replacement Staff: admin') ||
      App\Rrhh\Authority::getAuthorityFromDate(46, Carbon\Carbon::now(), 'manager')->user_id == Auth::user()->id)
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-users"></i> Personal y Ciclo de Vida laboral
        </a>

        <div class="dropdown-menu">
            <!-- <a class="dropdown-item" href="{{ route('replacement_staff.request.pending_personal_index') }}">
              <i class="fas fa-inbox"></i> Solicitudes Pendientes
            </a> -->
            <a class="dropdown-item" href="{{ route('replacement_staff.request.personal_index') }}">
                <i class="fas fa-inbox"></i> Todas las solicitudes
            </a>
        </div>
    </li>
    @endif


    @canany(['Replacement Staff: manage', 'Replacement Staff: view requests'])
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-file"></i> Reportes
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('replacement_staff.reports.replacement_staff_historical') }}">Historico por Persona</a>
            <a class="dropdown-item" href="{{ route('replacement_staff.reports.request_by_dates') }}">Consolidado por fecha</a>
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
           <div class="dropdown-divider"></div>
           <a class="dropdown-item" href="{{ route('replacement_staff.manage.legal_quality.index') }}">Calidad Jurídica</a>
           <a class="dropdown-item" href="{{ route('replacement_staff.manage.fundament.index') }}">Fundamentos</a>
           @endcan
       </div>
  </li>
  @endcan
</ul>
