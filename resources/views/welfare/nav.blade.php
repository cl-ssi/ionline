<ul class="nav nav-tabs mb-3 d-print-none">

    @canany(['amiPASS', 'be god'])
        <li class="nav-item">
            <a class="nav-link" href="{{ route('welfare.index') }}">
                <i class="fas fa-home"></i> home
            </a>
        </li>
    @endcanany


    @canany(['be god'])
        <li class="nav-item">
            <a class="nav-link" href="{{ route('welfare.balances') }}">
                <i class="fas fa-balance-scale"></i> Balance
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('welfare.dosfile.index') }}">
                <i class="fas fa-file-upload"></i> Carga archivo
            </a>
        </li>

        <!--li class="nav-item">
                <a class="nav-link" href="{{ route('welfare.loans.index') }}">
                    <i class="fas fa-file-excel"></i> Carga Excel de préstamos
                </a>
            </li-->

        <li class="nav-item">
            <a class="nav-link" href="{{ route('welfare.report') }}">
                <i class="fas fa-chart-bar"></i> Gráficos
            </a>
        </li>
    @endcanany

    @canany(['be god'])
        <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-file-invoice"></i> amiPASS</a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                <a class="dropdown-item" href="{{ route('welfare.amipass.upload') }}">
                    <i class="fas fa-file-upload"></i> Carga archivo
                </a>

                <a class="dropdown-item" href="{{ route('welfare.amipass.dashboard') }}">
                    <i class="fas fa-file-upload"></i> Dashboard
                </a>
            </div>
        </li>
    @endcanany

        @canany(['amiPASS', 'be god'])
            <li class="nav-item">
                <a class="nav-link" href="{{ route('welfare.amipass.requests-manager') }}">
                    <i class="fas fa-utensils"></i> Solicitudes Amipass
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="{{ route('welfare.amipass.question-all-index') }}">
                    <i class="fas fa-question-circle"></i> Consultas/Sugerencia Amipass
                </a>
            </li>


        @endcanany
    </ul>
