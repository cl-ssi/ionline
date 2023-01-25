<ul class="nav nav-tabs mb-3 d-print-none">
@canany(['be god','Rem: admin','Rem: user'])
    <li class="nav-item">
        <a class="nav-link" href="{{ route('rem.files.rem_original') }}">
            <i class="fas fa-file-excel fa-fw"></i> Carga de REMS
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('rem.files.rem_correccion') }}">
            <i class="fas fa-edit fa-fw"></i> Corrección de REMS
        </a>
    </li>
@endcan

@canany(['be god','Rem: admin'])
    <li class="nav-item">
        <a class="nav-link" href="{{ route('rem.users.index') }}">
            <i class="fas fa-users fa-fw"></i> Usuarios REM
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('rem.periods_series.index') }}">
            <i class="fas fa-calendar-check fa-fw"></i> Periodos y Series REM
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('rem.periods.index') }}">
            <i class="fas fa-calendar-alt fa-fw"></i> Periodos REM
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('rem.series.index') }}">
            <i class="fas fa-table fa-fw"></i> Series REM
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('parameters.establishments.index') }}">
            <i class="fas fa-fw fa-hospital"></i> Establecimientos
        </a>
    </li>
@endcan

</ul>