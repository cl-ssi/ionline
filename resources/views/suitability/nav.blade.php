<ul class="nav nav-tabs mb-3 d-print-none">


    <li class="nav-item">
        <a class="nav-link" href="{{ route('suitability.own') }}">
            <i class="fas fa-clone"></i> Todas las Solicitudes
        </a>
    </li>

    <div class="dropdown show">
        <a class="nav-link  dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true">
            <i class="fas fa-gavel"></i> Idoneidad
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="{{ route('suitability.pending') }}"><i class="fas fa-list"></i>
                Aceptar/Rechazar</a>
            <a class="dropdown-item" href="{{ route('suitability.configSignature') }}"><i class="fas fa-signature"></i>
                Configurar Firmantes</a>
            <hr>
            <a class="dropdown-item" href="{{ route('suitability.approved') }}"><i class="fas fa-check"></i> Listado
                Aceptados</a>
            <a class="dropdown-item" href="{{ route('suitability.rejected') }}"><i class="fas fa-minus-circle"></i>
                Listado Rechazados</a>

        </div>
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('suitability.results.index') }}">
            <i class="fas fa-trophy"></i> Resultados Test
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('suitability.report') }}">
            <i class="fas fa-book-open"></i> Reporte
        </a>
    </li>

    @can('be god')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('suitability.reportsigned') }}">
                <i class="fas fa-signature"></i> Reporte Firmados (en Desarrollo)
            </a>
        </li>
    @endcan

    <li class="nav-item">
        <a class="nav-link" href="{{ route('suitability.reportAllRequest') }}">
            <i class="far fa-file-excel"></i> Reporte Todas las Solicitudes
        </a>
    </li>

    <div class="dropdown show">
        <a class="nav-link  dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true">
            <i class="fas fa-file-medical-alt"></i> Configuración Examen
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="{{ route('suitability.schools.index') }}"><i class="fas fa-school"></i>
                Colegios</a>
            <a class="dropdown-item" href="{{ route('suitability.users.index') }}"><i class="fas fa-user"></i>
                Usuarios</a>
            <hr>
            <a class="dropdown-item" href="{{ route('suitability.categories.index') }}"><i class="fas fa-list"></i>
                Examen</a>
            <a class="dropdown-item" href="{{ route('suitability.questions.index') }}"><i class="fas fa-question"></i>
                Preguntas</a>
            <a class="dropdown-item" href="{{ route('suitability.options.index') }}"><i class="fas fa-check"></i>
                Opciones</a>

        </div>
    </div>



</ul>
