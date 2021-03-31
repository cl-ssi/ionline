<ul class="nav nav-tabs mb-3">

    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.service-request.home') }}"
            href="{{ route('rrhh.service-request.home') }}">
            <i class="fas fa-home"></i> Home
        </a>
    </li>


    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.service-request.index') }}"
            href="{{ route('rrhh.service-request.index') }}">
            <i class="fas fa-pencil-alt"></i> Solicitudes
            <span class="badge badge-secondary">{{ App\Models\ServiceRequests\ServiceRequest::getPendingRequests() }}</span>
        </a>
    </li>

    @canany(['Service Request: fulfillments'])
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.service-request.fulfillment.index') }}"
            href="{{ route('rrhh.service-request.fulfillment.index') }}">
            <i class="fas fa-clipboard-check"></i> Cumplimientos
        </a>
    </li>
    @endcan

    @canany(['Service Request: additional data'])
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.service-request.aditional_data_list') }}"
            href="{{ route('rrhh.service-request.aditional_data_list') }}">
            <i class="fas fa-file-alt"></i> Info. adicional
        </a>
    </li>
    @endcan

    @canany(['Service Request: transfer requests'])
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.service-request.transfer_requests') }}"
            href="{{ route('rrhh.service-request.transfer_requests') }}">
            <i class="fas fa-sign-in-alt"></i> Transferir solicitudes
        </a>
    </li>
    @endcan

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ active('rrhh.service-request.report.*') }}" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-archive"></i> Reportes
        </a>
        <div class="dropdown-menu">

            @can('Service Request: consolidated data')
            <a class="dropdown-item"
                href="{{ route('rrhh.service-request.report.consolidated_data') }}">
                <i class="far fa-file-excel"></i> Consolidado
            </a>
            @endcan

            @can('Service Request: consolidated data')
            <a class="dropdown-item"
                href="{{ route('rrhh.service-request.report.export_sirh') }}">
                <i class="far fa-file"></i> Formato SIRH
            </a>
            @endcan

            @canany(['Service Request: pending requests'])
            <a class="dropdown-item {{ active('rrhh.service-request.pending-requests') }}"
                href="{{ route('rrhh.service-request.pending-requests') }}">
                <i class="fas fa-bomb"></i> Estado de firmas
            </a>
            @endcan

            @canany(['Service Request: pending requests'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.to-pay') }}"
                href="{{ route('rrhh.service-request.report.to-pay') }}">
                <i class="fas fa-file-invoice-dollar"></i> Reporte para pagos
            </a>
            @endcan


            <!-- @canany(['Service Request: pending requests'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.without-bank-details') }}"
                href="{{ route('rrhh.service-request.report.without-bank-details') }}">
                <i class="fas fa-piggy-bank"></i> Sin Cuentas Bancarias
            </a>
            @endcan -->

            @canany(['Service Request: pending requests'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.pending-resolutions') }}"
                href="{{ route('rrhh.service-request.report.pending-resolutions') }}">
                <i class="fas fa-file-invoice-dollar"></i> Resoluciones pendientes
            </a>
            @endcan

            @canany(['Service Request: with resolution'])
                <a class="dropdown-item {{ active('rrhh.service-request.report.with-resolution-file') }}"
                   href="{{ route('rrhh.service-request.report.with-resolution-file') }}">
                    <i class="fas fa-file-invoice-dollar"></i> Solicitudes con resolución cargada
                </a>
            @endcan


            <!-- <div class="dropdown-divider"></div>

            <a class="dropdown-item" href="#">Temp</a> -->

        </div>
    </li>

    @canany(['Service Request: maintainers'])
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ active('parameters.values.report.*') }}" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-cog"></i>
        </a>
        <div class="dropdown-menu">

          <a class="dropdown-item {{ active('parameters.values.index') }}"
              href="{{ route('parameters.values.index') }}">
              <i class="fas fa-money-bill-alt"></i> Valor Hora/Jornada</a>
          </a>

        </div>
    </li>
    @endcan

</ul>
