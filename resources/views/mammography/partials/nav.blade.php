<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('mammography.index') }}">
            <i class="fas fa-home"></i> Listado</a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('mammography.schedule') }}">
            <i class="fas fa-calendar-alt"></i> Agenda</a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('mammography.create') }}">
            <i class="fas fa-plus-circle"></i> Nuevo</a>
    </li>


    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('mammography.export') }}">
            <i class="fas fa-file-csv"></i> Exportar</a>
    </li>

    <!-- <li class="nav-item">
        <a class="nav-link"
            href="{{ route('mammography.slots') }}">
            <i class="fas fa-running"></i> Llegadas</a>
    </li> -->
</ul>
