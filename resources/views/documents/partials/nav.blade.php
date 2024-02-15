<ul class="nav nav-tabs mb-3">
    @can('Documents: create')
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('documents.create') }}">
            <i class="bi bi-pencil"></i> Nuevo documento
        </a>
    </li>
    @endcan

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('documents.index') }}">
            <i class="bi bi-book"></i> Historial
        </a>
    </li>

    @can('I play with madness')
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('documents.docdigital.documentos.creados') }}">
            <i class="bi bi-file-earmark-richtext"></i> DocDigital - Creados
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('documents.docdigital.documentos.recibidos') }}">
            <i class="bi bi-file-earmark-richtext"></i> DocDigital - Recibidos
        </a>
    </li>
    @endcan

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('documents.report') }}">
            <i class="bi bi-eye"></i> Reporte
        </a>
    </li>
</ul>
