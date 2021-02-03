<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('vaccination.index') }}">
            <i class="fas fa-home"></i> Listado</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('vaccination.create') }}">
            <i class="fas fa-plus-circle"></i> Nuevo</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('vaccination.report') }}">
            <i class="fas fa-chart-line"></i> Reporte</a>
    </li>
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('vaccination.export') }}">
            <i class="fas fa-file-csv"></i> Exportar</a>
    </li>
</ul>
