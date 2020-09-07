<ul class="nav nav-tabs mb-3">
    @can('Partes: oficina')
    <li class="nav-item">
        <a class="nav-link {{ active('documents.partes.create') }}"
            href="{{ route('documents.partes.create') }}">
            <i class="fas fa-plus"></i> Nuevo Ingreso
        </a>
    </li>
    @endcan

    @canany(['Partes: oficina', 'Partes: director'])
    <li class="nav-item">
        <a class="nav-link {{ active('documents.partes.index') }}"
            href="{{ route('documents.partes.index') }}">
            <i class="fas fa-folder-open"></i> Bandeja de Entrada
        </a>
    </li>
    @endcan

    <!-- @canany(['Partes: user'])
    <li class="nav-item">
        <a class="nav-link {{ active('documents.partes.inbox') }}"
            href="{{ route('documents.partes.inbox') }}">
            <i class="fas fa-inbox"></i> Bandeja de Entrada
        </a>
    </li>
    @endcan -->

    @canany(['Partes: oficina'])
    <li class="nav-item">
        <a class="nav-link {{ active('documents.add_number') }}"
            href="{{ route('documents.add_number') }}">
            <i class="fas fa-certificate"></i> Nuevo Egreso
        </a>
    </li>
    @endcan

    @canany(['Partes: oficina'])
    <li class="nav-item">
        <a class="nav-link {{ active('documents.partes.outbox') }}"
            href="{{ route('documents.partes.outbox') }}">
            <i class="fas fa-inbox"></i> Bandeja de Salida
        </a>
    </li>
    @endcan

    @can('be god')
    <li class="nav-item">
        <a class="nav-link {{ active('documents.partes.admin') }}"
            href="{{ route('documents.partes.admin') }}">
            <i class="fas fa-cog"></i> Admin
        </a>
    </li>
    @endcan
</ul>
