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

    <!-- @can('Documents: add number')
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('documents.add_number') }}">
            <i class="fas fa-certificate"></i> Agregar Numero
        </a>
    </li>
    @endcan -->

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('documents.report') }}">
            <i class="fas fa-eye"></i> Reporte
        </a>
    </li>
</ul>
