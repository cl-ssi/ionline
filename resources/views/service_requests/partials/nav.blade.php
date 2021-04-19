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

    @can('Service Request: fulfillments responsable')
        <li class="nav-item">
            <a class="nav-link {{ active('rrhh.service-request.report.fulfillment-pending') }}"
                href="{{ route('rrhh.service-request.report.fulfillment-pending','responsable') }}"
                title="Cumplimientos pendientes por aprobar de Responsable">
                <i class="fas fa-clipboard-check"></i>
                <i class="fas fa-user"></i>
            </a>
        </li>
    @endcan

    @can('Service Request: fulfillments rrhh')
        <li class="nav-item">
            <a class="nav-link {{ active('rrhh.service-request.report.fulfillment-pending') }}"
                href="{{ route('rrhh.service-request.report.fulfillment-pending','rrhh') }}"
                title="Cumplimientos pendientes por aprobar de RRHH">
                <i class="fas fa-clipboard-check"></i>
                <i class="fas fa-user-shield"></i>
            </a>
        </li>
    @endcan

    @can('Service Request: fulfillments finance')
        <li class="nav-item">
            <a class="nav-link {{ active('rrhh.service-request.report.fulfillment-pending') }}"
                href="{{ route('rrhh.service-request.report.fulfillment-pending','finance') }}"
                title="Cumplimientos pendientes por aprobar de finanzas">
                <i class="fas fa-clipboard-check"></i>
                <i class="fas fa-piggy-bank"></i>
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
            <i class="fas fa-sign-in-alt"></i> Transf. solicitudes
        </a>
    </li>
    @endcan

    @canany(['Service Request: change signature flow'])
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.service-request.change_signature_flow_view') }}"
            href="{{ route('rrhh.service-request.change_signature_flow_view') }}">
            <i class="fas fa-sign-in-alt"></i> Flujo de firmas
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

            @canany(['Service Request: report to pay'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.to-pay') }}"
                href="{{ route('rrhh.service-request.report.to-pay') }}">
                <i class="fas fa-piggy-bank"></i> Reporte para pagos
            </a>
            @endcan

            @canany(['Service Request: report payed'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.payed') }}"
                href="{{ route('rrhh.service-request.report.payed') }}">
                <i class="fas fa-piggy-bank"></i> Reporte pagados
            </a>
            @endcan

            @canany(['Service Request: fulfillments rrhh','Service Request: fulfillments finance'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.compliance') }}"
                href="{{ route('rrhh.service-request.report.compliance') }}">
                <i class="fas fa-flag-checkered"></i> Reporte de cumplimientos
            </a>
            @endcan


            @canany(['Service Request: pending requests'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.pay-rejected') }}"
                href="{{ route('rrhh.service-request.report.pay-rejected') }}">
                <i class="fas fa-ban"></i> Pagos rechazados
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
                <i class="fas fa-exclamation-circle"></i> Resoluciones pendientes
            </a>
            @endcan

            @canany(['Service Request: with resolution'])
                <a class="dropdown-item {{ active('rrhh.service-request.report.with-resolution-file') }}"
                   href="{{ route('rrhh.service-request.report.with-resolution-file') }}">
                    <i class="fas fa-clipboard-check"></i> Solicitudes con resolución cargada
                </a>
            @endcan

            @canany(['Service Request: with resolution'])
                <a class="dropdown-item {{ active('rrhh.service-request.report.without-resolution-file') }}"
                   href="{{ route('rrhh.service-request.report.without-resolution-file') }}">
                    <i class="fas fa-clipboard"></i> Solicitudes sin resolución cargada
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
