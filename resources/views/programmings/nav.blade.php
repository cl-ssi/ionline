<ul class="nav nav-tabs mb-3 small">

    <li class="nav-item">
        <a class="nav-link {{ active('programmings.index') }}" href="{{ route('programmings.index') }}">
        <i class="fas fa-file-invoice-dollar"></i> Programación Operativa</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('professionals.index') }}" href="{{ route('professionals.index') }}">
        <i class="fas fa-file-invoice-dollar"></i> Profesionales</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('agreements.create') }}" href="{{ route('agreements.create') }}">
        <i class="fas fa-plus"></i> Nuevo convenio</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('agreements.programs.index') }}" href="{{ route('agreements.programs.index') }}">
        <i class="fas fa-cog"></i> Parametros</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('programmings.professionals.index') }}" href="{{ route('agreements.tracking.index') }}">
        <i class="fas fa-paper-plane"></i> Profesionales</a>
    </li>
</ul>
