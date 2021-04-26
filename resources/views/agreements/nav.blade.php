<ul class="nav nav-tabs mb-3 small">

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('agreements.index*') || request()->routeIs('agreements.show*')  ? 'active' : '' }}" href="{{ route('agreements.index') }}"><i class="fas fa-file-invoice-dollar"></i> Convenios</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('agreements.create') ? 'active' : '' }}" href="{{ route('agreements.create') }}"><i class="fas fa-plus"></i> Nuevo convenio</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('agreements.programs.*') ? 'active' : '' }}" href="{{ route('agreements.programs.index') }}"><i class="fas fa-cog"></i> Programas</a>
    </li>
    @can('Agreement: manage municipalities and signers')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('agreements.municipalities.*') ? 'active' : '' }}" href="{{ route('agreements.municipalities.index') }}"><i class="fas fa-building"></i> Municipios</a>
    </li>
    @endcan
    
    @can('Agreement: manage municipalities and signers')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('agreements.signers.*') ? 'active' : '' }}" href="{{ route('agreements.signers.index') }}"><i class="fas fa-file-signature"></i> Firmantes</a>
    </li>
    @endcan
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('agreements.tracking.*') ? 'active' : '' }}" href="{{ route('agreements.tracking.index') }}"><i class="fas fa-paper-plane"></i> Seguimiento Convenio</a>
    </li>
</ul>
