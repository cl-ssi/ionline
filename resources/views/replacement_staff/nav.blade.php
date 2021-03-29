<ul class="nav nav-tabs mb-3 d-print-none">

    @can('Replacement Staff: list')
    <li class="nav-item">
        <a class="nav-link"
                      href="{{ route('replacement_staff.index') }}">
            <i class="fas fa-inbox"></i> Listado Staff
        </a>
    </li>
    @endcan

    @can('Replacement Staff: manage')
    <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-cog"></i> Configuración
       </a>
       <div class="dropdown-menu">
           <a class="dropdown-item" href="{{ route('replacement_staff.manage.profession.index') }}">Profesiones</a>
           <a class="dropdown-item" href="{{ route('replacement_staff.manage.profile.index') }}">Perfiles</a>
       </div>
   </li>
   @endcan
</ul>
