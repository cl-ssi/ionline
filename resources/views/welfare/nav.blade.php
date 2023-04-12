<ul class="nav nav-tabs mb-3 d-print-none">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('welfare.index') }}">
            <i class="fas fa-home"></i> home
        </a>
    </li>

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

    @canany(['amiPASS'])
    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle"
            href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-file-invoice"></i> amiPASS</a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

            <a class="dropdown-item"
                href="{{ route('welfare.amipass.index') }}">
                <i class="fas fa-file-upload"></i> Carga archivo
            </a>
        </div>
    </li>
    @endcanany
</ul>