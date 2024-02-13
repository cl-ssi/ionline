<ul class="nav nav-tabs mb-3">
    @can('Documents: create')
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('documents.create') }}">
            <i class="fas fa-pencil-alt"></i> Nuevo documento
        </a>
    </li>
    @endcan

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('documents.index') }}">
            <i class="fas fa-book"></i> Historial
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('documents.report') }}">
            <i class="fas fa-eye"></i> Reporte
        </a>
    </li>

    @can('I play with madness')
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('documents.docdigital.documentos.creados') }}">
            <i class="fas fa-file"></i> DocDigital - Creados
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('documents.docdigital.documentos.recibidos') }}">
            <i class="fas fa-file"></i> DocDigital - Recibidos
        </a>
    </li>

    @endcan
</ul>
