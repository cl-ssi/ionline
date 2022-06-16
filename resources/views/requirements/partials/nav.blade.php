<ul class="nav nav-tabs mb-4 d-print-none">

    <li class="nav-item">
        <a class="nav-link {{active('requirements.create_requirement_sin_parte')}}"
            href="{{ route('requirements.create_requirement_sin_parte') }}">
            <i class="fas fa-plus"></i>
            Nuevo requerimiento
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{active('requirements.outbox')}}"
            href="{{ route('requirements.outbox') }}">
            <i class="fas fa-inbox"></i>
            Bandeja
        </a>
    </li>

    <!-- si es secretaria -->
    @if(count(App\Rrhh\Authority::getAmIAuthorityFromOu(date('Y-m-d'), 'secretary', Auth::user()->id)) > 0)

        <li class="nav-item">
            <a class="nav-link {{active('requirements.secretary_outbox')}}"
                href="{{ route('requirements.secretary_outbox') }}">
                <i class="fas fa-inbox"></i>
                Bandeja (Jefatura)
            </a>
        </li>
    
    @endif

    <li class="nav-item">
        <a class="nav-link {{ active('requirements.inbox')}}"
            href="{{ route('requirements.inbox') }}">
            <i class="fas fa-inbox text-danger"></i>
            Nueva
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{active('requirements.categories.index')}}"
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
        <a class="nav-link {{active('requirements.report1')}}"
            href="{{ route('requirements.report1') }}">
            <i class="fas fa-book"></i>
            Reporte
        </a>
    </li>
    @endif

</ul>
