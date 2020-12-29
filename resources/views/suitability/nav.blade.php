<ul class="nav nav-tabs mb-3 d-print-none">
    <li class="nav-item">
        <a class="nav-link"
                      href="{{ route('suitability.own') }}">
            <i class="fas fa-inbox"></i> Mis Solicitudes
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
                      href="{{ route('suitability.validaterequest') }}">
            <i class="fas fa-file"></i> Nueva Solicitud de Idoneidad
        </a>
    </li>
    

    <li class="nav-item">
        <a class="nav-link"
                      href="#">
            <i class="fas fa-clone"></i> Solicitudes (admin)
        </a>
    </li>


    <div class="dropdown show">
        <a class="nav-link  dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" >
        <i class="fas fa-file-medical-alt"></i> Examen
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="{{ route('suitability.categories.index') }}"><i class="fas fa-list"></i>  Categorías</a>
            <a class="dropdown-item" href="{{ route('suitability.questions.index') }}"><i class="fas fa-question"></i>  Preguntas</a>
            <a class="dropdown-item" href="{{ route('suitability.options.index') }}"><i class="fas fa-check"></i>  Opciones</a>
            <a class="dropdown-item" href="{{ route('suitability.results.index') }}"><i class="fas fa-check"></i>  Resultados</a>
        </div>
    </div>
    

</ul>