<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ active('finance.dtes.index') }}"
            href="{{ route('finance.dtes.index') }}">
            <i class="fas fa-fw fa-file-invoice-dollar"></i> Dtes</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('finance.payments.review') }}"
            href="{{ route('finance.payments.review') }}">
            <i class="fas fa-fw fa-dollar-sign"></i> Revisión</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('finance.payments.rejected') }}"
            href="{{ route('finance.payments.rejected') }}">
            <i class="fas fa-fw fa-ban"></i> Rechazadas</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('finance.payments.ready') }}"
            href="{{ route('finance.payments.ready') }}">
            <i class="far fa-fw fa-clock"></i> Pendiente para Pagos TGR</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('finance.payments.InstitutionalPayment') }}"
            href="{{ route('finance.payments.InstitutionalPayment') }}">
            <i class="far fa-fw fa-money-bill-alt"></i> Pagos Institucionales</a>
    </li>

    @can('be god')
    <li class="nav-item">
        <a class="nav-link {{ active('finance.payments.paid') }}"
            href="{{ route('finance.payments.paid') }}">
            <i class="far fa-fw fa-check-circle"></i> Pagados</a>
    </li>
    @endcan

    <li class="nav-item">
        <a class="nav-link {{ active('finance.payments.backup') }}"
            href="{{ route('finance.payments.backup') }}">
            <i class="fas fa-fw fa-database"></i> Pagos TGR</a>
    </li>

    @cannot('Payments: viewer')
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-fw fa-cloud-upload-alt"></i> Cargar
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="{{ route('finance.dtes.upload') }}">
                        <i class="fas fa-fw fa-cloud-upload-alt"></i> Cargar DTEs desde archivo</a>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('finance.dtes.uploadTgr') }}">
                        <i class="fas fa-fw fa-cloud-upload-alt"></i> Cargar TGR
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('finance.dtes.uploadBhe') }}">
                        <i class="fas fa-fw fa-cloud-upload-alt"></i> Cargar BHE
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('finance.dtes.manual') }}">
                        <i class="fas fa-fw fa-cloud-upload-alt"></i> Cargar DTE Manual
                    </a>
                </li>
            </ul>
        </li>
    @endcannot

</ul>
