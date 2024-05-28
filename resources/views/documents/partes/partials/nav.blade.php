<ul class="nav nav-tabs mb-3">
    @canany(['Partes: oficina', 'Partes: director'])
    <li class="nav-item">
        <a class="nav-link {{ active('documents.partes.index') }}"
            href="{{ route('documents.partes.index') }}">
            <i class="fas fa-folder-open"></i> Bandeja de Entrada
        </a>
    </li>
    @endcan

    @can('Partes: oficina')
    <li class="nav-item">
        <a class="nav-link {{ active('documents.partes.create') }}"
            href="{{ route('documents.partes.create') }}">
            <i class="fas fa-plus"></i> Nuevo Ingreso
        </a>
    </li>


    <li class="nav-item">
        <a class="nav-link {{ active('documents.partes.numeration.inbox') }}"
            href="{{ route('documents.partes.numeration.inbox') }}">
            <i class="fas fa-certificate"></i> Numerar y distribuir
        </a>
    </li>

    {{--
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('documents.add_number') }}">
            <i class="fas fa-certificate"></i> Editar
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('documents.partes.outbox') }}">
            <i class="fas fa-inbox"></i> Bandeja de Salida
        </a>
    </li>
    --}}

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('documents.partes.access-log') }}">
            <i class="fas fa-clipboard-list"></i> Log
        </a>
    </li>
    @endcan

    @canany(['Partes: user','Partes: oficina', 'Partes: director'])
    <li class="nav-item">
        <a class="nav-link {{ active('documents.partes.report-by-dates') }}"
            href="{{ route('documents.partes.report-by-dates') }}">
            <i class="fas fa-search"></i> Buscar por fecha
        </a>
    </li>
    @endcan

    @canany(['Partes: director'])
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('requirements.createFromParte') }}">
            <i class="fas fa-hands"></i> Derivar Pendientes (Director)
        </a>
    </li>
    @endcan

    <!-- Preguntar que permisos debería tener -->
    @can('be god')
        <li class="nav-item">
            <a class="nav-link {{ active('documents.partes.parameters')}}"
                href="{{ route('documents.partes.parameters') }}">
                <i class="fas fa-cog"></i> 
            </a>
        </li>
    @endcan
</ul>
