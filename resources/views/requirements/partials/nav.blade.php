<ul class="nav nav-tabs mb-4 d-print-none">

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('requirements.create_requirement_sin_parte') }}">
            <i class="fas fa-plus"></i>
            Nuevo requerimiento
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('requirements.outbox') }}">
            <i class="fas fa-inbox"></i>
            Bandeja de requerimientos
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('requirements.categories.index') }}">
            <i class="fas fa-book"></i>
            Categorias
        </a>
    </li>

    <!-- <li class="nav-item">
        <a class="nav-link"
            href="{{ route('requirements.outbox') }}">
            <i class="fas fa-pencil-alt"></i>
            Bandeja de salida
        </a>
    </li> -->

    @if(Auth::user()->id == 9381231 || Auth::user()->id == 17430005 || Auth::user()->id == 15287582)
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('requirements.report1') }}">
            <i class="fas fa-book"></i>
            Reporte
        </a>
    </li>
    @endif

</ul>
