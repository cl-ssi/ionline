<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.performance-report.received_report') }}" aria-current="page" href="{{route('rrhh.performance-report.received_report')}}">
            <i class="bi bi-inbox"></i>
            Informes de desempeño recibidos
        </a>
    </li>
    @if(auth()->user()->getAmIAuthorityFromOuAttribute()->isNotEmpty())
        <li class="nav-item">
            <a class="nav-link {{ active('rrhh.performance-report.submitted_report') }}" href="{{route('rrhh.performance-report.submitted_report')}}">
                <i class="bi bi-file-earmark-text"></i>
                Mis informes de desempeño realizados
            </a>
        </li>
    @endif
    
    <!-- <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-card-checklist"></i>
            Administrador de informes de desempeño
        </a>
    </li> -->
    @can('be god')
        <li class="nav-item">
            <a class="nav-link {{ active('rrhh.performance-report.period') }}" href="{{route('rrhh.performance-report.period')}}">
                <i class="bi bi-gear"></i>
                Periodos de Informes
            </a>
        </li>
    @endcan
</ul>