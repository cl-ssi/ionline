<ul class="nav nav-tabs mb-3 d-print-none">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('finance.dtes.pendingReceiptCertificate') }}">
            <i class="fas fa-file-alt"></i> Todos los Dte pendiente de Acta
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('finance.dtes.pendingReceiptCertificate', ['tray' => 'servicios']) }}">
            <i class="fas fa-cogs"></i> Dtes de tipo Servicio pendiente de Acta
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('finance.dtes.pendingReceiptCertificate', ['tray' => 'bienes']) }}">
            <i class="fas fa-cube"></i> Dtes de tipo Bienes pendiente de Acta
        </a>
    </li>

</ul>
