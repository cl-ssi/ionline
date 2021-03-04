<ul class="nav nav-tabs mb-3 d-print-none">

    <li class="nav-item">
        <a class="nav-link"
                      href="{{ route('replacement_staff.index') }}">
            <i class="fas fa-user-alt"></i> Staff (admin)
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
                      href="{{ route('replacement_staff.create') }}">
            <i class="fas fa-plus"></i> Nuevo Staff
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
                      href="{{ route('replacement_staff.request.index') }}">
            <i class="fas fa-inbox"></i> Solicitudes (admin)
        </a>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-cog"></i> Mantenedores
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('replacement_staff.manage.profile.index') }}"><i class="fas fa-user-nurse"></i> &nbsp;Perfiles</a>
            <a class="dropdown-item" href="{{ route('replacement_staff.manage.profession.index') }}"><i class="fas fa-id-card-alt"></i> Profesiones</a>
            <!--<div class="dropdown-divider"></div>-->
        </div>
    </li>


</ul>
