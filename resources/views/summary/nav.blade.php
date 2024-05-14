<ul class="nav nav-tabs mb-3 d-print-none">

    @canany(['be god', 'Summary: user', 'Summary: admin', 'Summary: admin viewer'])
        <li class="nav-item">
            <a class="nav-link {{ active('summary.index') }}" href="{{ route('summary.index') }}">
                <i class="fas fa-book"></i> Mis Sumarios
            </a>
        </li>
    @endcanany

    @canany(['be god', 'Summary: admin'])
        <li class="nav-item">
            <a class="nav-link {{ active('summary.event-types.*') }}" href="{{ route('summary.event-types.index') }}">
                <i class="fas fa-list-alt"></i> Tipos de Eventos
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ active('summary.links.*') }}" href="{{ route('summary.links.index') }}">
                <i class="fas fa-link"></i> Vínculos entre tipos de eventos
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ active('summary.templates.*') }}" href="{{ route('summary.templates.index') }}">
                <i class="far fa-file-alt"></i> Plantillas
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ active('summary.types.*') }}" href="{{ route('summary.types.index') }}">
                <i class="far fa-file-alt"></i> Procesos
            </a>
        </li>
    @endcanany
</ul>
