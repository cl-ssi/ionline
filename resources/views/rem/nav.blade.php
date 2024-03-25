<ul class="nav nav-tabs mb-3 d-print-none">
@canany(['be god','Rem: admin','Rem: user'])
    <li class="nav-item">
        <a class="nav-link" href="{{ route('rem.files.rem_original') }}">
            <i class="fas fa-file-excel fa-fw"></i> Carga
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('rem.files.rem_correccion') }}">
            <i class="fas fa-edit fa-fw"></i> Corrección
        </a>
    </li>
@endcan

@canany(['be god','Rem: admin'])
    <li class="nav-item">
        <a class="nav-link" href="{{ route('rem.users.index') }}">
            <i class="fas fa-users fa-fw"></i> Usuarios
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('rem.periods_series.index') }}">
            <i class="fas fa-calendar-check fa-fw"></i> Periodos y Series
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('rem.periods.index') }}">
            <i class="fas fa-calendar-alt fa-fw"></i> Periodos
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('rem.series.index') }}">
            <i class="fas fa-table fa-fw"></i> Series
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('parameters.establishments.index') }}">
            <i class="fas fa-fw fa-hospital"></i> Establecimientos
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('indicators.rem.import-mdb') }}" 
            href="{{ route('indicators.rem.import-mdb') }}">
            <i class="bi bi-database"></i> Subir MDB
        </a>
    </li>
@endcan

</ul>