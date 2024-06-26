<ul class="nav nav-tabs mb-3 d-print-none">

    <li class="nav-item">
        <a class="nav-link {{ active('prof_agenda.home') }}"
            href="{{ route('prof_agenda.home') }}">
            <i class="fas fa-home"></i> Home
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('prof_agenda.agenda.booking') }}"
            href="{{ route('prof_agenda.agenda.booking') }}">
            <i class="fa fa-calendar"></i> Agendar hora
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('prof_agenda.open_hour.my-bookings') }}"
            href="{{ route('prof_agenda.open_hour.my-bookings') }}">
            <i class="fa fa-calendar"></i> Mis reservas
        </a>
    </li>

    @canany(['Agenda UST: Administrador','Agenda UST: Funcionario','Agenda UST: Secretaria'])
        <li class="nav-item">
            <a class="nav-link {{ active('prof_agenda.agenda.index') }}"
                href="{{ route('prof_agenda.agenda.index') }}">
                <i class="fa fa-calendar"></i> Gestor de agenda
            </a>
        </li>
    @endcanany

    @canany(['Agenda UST: Administrador','Agenda UST: Funcionario','Agenda UST: Secretaria'])
        <li class="nav-item">
            <a class="nav-link {{ active('prof_agenda.open_hour.index') }}"
                href="{{ route('prof_agenda.open_hour.index') }}">
                <i class="fa fa-book"></i> Reservas
            </a>
        </li>
    @endcanany

    @canany(['Agenda UST: Administrador','Agenda UST: Funcionario'])
        <li class="nav-item">
            <a class="nav-link {{ active('prof_agenda.proposals.index') }}"
                href="{{ route('prof_agenda.proposals.index') }}">
                <i class="fa fa-list"></i> Propuestas
            </a>
        </li>
    @endcanany

    @canany(['Agenda UST: Administrador','Agenda UST: Funcionario','Agenda UST: Secretaria'])
        <li class="nav-item">
            <a class="nav-link {{ active('prof_agenda.proposals.open_calendar') }}"
                href="{{ route('prof_agenda.proposals.open_calendar') }}">
                <i class="fa fa-folder-open"></i> Aperturar agenda
            </a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{active('prof_agenda.activity_types.*')}}"
            data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-clipboard-check"></i> Mantenedores
            </a>
            <div class="dropdown-menu">

                <a class="dropdown-item {{ active('prof_agenda.activity_types.index') }}"
                    href="{{ route('prof_agenda.activity_types.index') }}">
                    <i class="fas fa-clipboard-check"></i> Tipos de actividad
                </a>

                <a class="dropdown-item {{ active('prof_agenda.profession_messages.index') }}"
                    href="{{ route('prof_agenda.profession_messages.index') }}">
                    <i class="fas fa-clipboard-check"></i> Mensaje por especialidad
                </a>

            </div>
        </li>
    @endcanany

    @canany(['Agenda UST: Administrador','Agenda UST: Funcionario'])
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{active('prof_agenda.reports.*')}}"
            data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-clipboard-check"></i> Reportes
            </a>
            <div class="dropdown-menu">

                <a class="dropdown-item {{ active('prof_agenda.reports.sirsap') }}"
                    href="{{ route('prof_agenda.reports.sirsap') }}">
                    <i class="fas fa-clipboard-check"></i> SIRSAP
                </a>

                <a class="dropdown-item {{ active('prof_agenda.reports.clinicalreport') }}"
                    href="{{ route('prof_agenda.reports.clinicalreport') }}">
                    <i class="fas fa-clipboard-check"></i> Ficha paciente
                </a>

            </div>
        </li>
    @endcanany

</ul>
