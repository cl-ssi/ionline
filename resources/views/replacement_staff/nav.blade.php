<ul class="nav nav-tabs mb-3 d-print-none">

    <li class="nav-item">
        <a class="nav-link"
                      href="{{ route('replacement_staff.index') }}">
            <i class="fas fa-inbox"></i> Indice de staffs (admin)
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
                      href="{{ route('replacement_staff.create') }}">
            <i class="fas fa-inbox"></i> Nuevo Staff
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
                      href="{{ route('replacement_staff.request.index') }}">
            <i class="fas fa-inbox"></i> Solicitudes (admin)
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
                      href="{{ route('replacement_staff.request.create') }}">
            <i class="fas fa-inbox"></i> Nueva Solicitud
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
                      href="{{ route('replacement_staff.request.own') }}">
            <i class="fas fa-inbox"></i> Mis Solicitudes
        </a>
    </li>


</ul>
