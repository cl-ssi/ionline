<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.users.profile') }}" 
            href="{{ route('rrhh.users.profile',auth()->id()) }}">
            <i class="bi bi-person-circle"></i> Mi Perfil
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('profile.subrogations') }}" 
            href="{{ route('profile.subrogations') }}">
            <i class="bi bi-people"></i> Subrogancia
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('profile.signature') }}" 
            href="{{ route('profile.signature') }}#">
            <i class="bi bi-envelope"></i> Plantilla Firma Correo
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" 
            href="{{ route('filament.intranet.rrhh.resources.monthly-attendances.index') }}">
            <i class="bi bi-clock"></i> Mi Asistencia
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.users.password.edit') }}" 
            href="{{ route('rrhh.users.password.edit') }}#">
            <i class="bi bi-key"></i> Cambio de clave
        </a>
    </li>
</ul>