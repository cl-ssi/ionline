<ul class="nav nav-tabs mb-3 small">

    <li class="nav-item">
        <a class="nav-link {{ active('agreements.index') }}" href="{{ route('agreements.index') }}"><i class="fas fa-file-invoice-dollar"></i> Convenios</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('agreements.create') }}" href="{{ route('agreements.create') }}"><i class="fas fa-plus"></i> Nuevo convenio</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('agreements.programs.index') }}" href="{{ route('agreements.programs.index') }}"><i class="fas fa-cog"></i> Parametros</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('agreements.programs.index') }}" href="{{ route('agreements.tracking.index') }}"><i class="fas fa-paper-plane"></i> Seguimiento Convenio</a>
    </li>
</ul>
