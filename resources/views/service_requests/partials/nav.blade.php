<ul class="nav nav-tabs mb-3 d-print-none">

    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.service-request.home') }}"
            href="{{ route('rrhh.service-request.home') }}">
            <i class="fas fa-home"></i> Home
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.service-request.user') }}"
            href="{{ route('rrhh.service-request.user') }}">
            <i class="fas fa-search"></i>
        </a>
    </li>

    <!-- <li class="nav-item">
        <a class="nav-link {{ active('rrhh.service-request.index_bak') }}"
            href="{{ route('rrhh.service-request.index_bak') }}">
            <i class="fas fa-pencil-alt"></i> Solicitudes
            <span class="badge badge-secondary">{{ App\Models\ServiceRequests\ServiceRequest::getPendingRequests() }}</span>
        </a>
    </li> -->

    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.service-request.index','pending') }}"
            href="{{ route('rrhh.service-request.index','pending') }}">
            <i class="fas fa-pencil-alt"></i> Solicitudes
            <span class="badge badge-secondary">{{ App\Models\ServiceRequests\ServiceRequest::getPendingRequests() }}</span>
        </a>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ active(['rrhh.service-request.fulfillment.index','rrhh.service-request.report.fulfillment-pending']) }}"
        data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-clipboard-check"></i> Cumplimientos
        </a>
        <div class="dropdown-menu">

            @canany(['Service Request: fulfillments'])
                <a class="dropdown-item {{ active('rrhh.service-request.fulfillment.index') }}"
                    href="{{ route('rrhh.service-request.fulfillment.index') }}">
                    <i class="fas fa-clipboard-check"></i> Cumplimientos
                </a>
            @endcan

            @can('Service Request: fulfillments responsable')
                <!--
                <a class="dropdown-item {{ active('rrhh.service-request.report.fulfillment-pending','responsable') }}"
                -->
                <a class="dropdown-item"
                    href="{{ route('rrhh.service-request.report.fulfillment-pending','responsable') }}"
                    title="Cumplimientos pendientes por aprobar de Responsable">
                    <i class="fas fa-chess-king"></i> Pendientes Responsable
                </a>
            @endcan

            @can('Service Request: fulfillments rrhh')
                <!--
                <a class="dropdown-item {{ active('rrhh.service-request.report.fulfillment-pending','rrhh') }}"
                -->
                <a class="dropdown-item"
                    href="{{ route('rrhh.service-request.report.fulfillment-pending','rrhh') }}"
                    title="Cumplimientos pendientes por aprobar de RRHH">
                    <i class="fas fa-user-shield"></i> Pendientes RRHH
                </a>
            @endcan

            @can('Service Request: fulfillments finance')
                <!--
                <a class="dropdown-item {{ active('rrhh.service-request.report.fulfillment-pending','finance') }}"
                -->
                <a class="dropdown-item"
                    href="{{ route('rrhh.service-request.report.fulfillment-pending','finance') }}"
                    title="Cumplimientos pendientes por aprobar de finanzas">
                    <i class="fas fa-piggy-bank"></i> Pendientes Finanzas
                </a>
            @endcan

        </div>
    </li>

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
        <a class="nav-link dropdown-toggle {{
            active(
                'rrhh.service-request.pending-requests',
                'rrhh.service-request.report.consolidated_data',
                'rrhh.service-request.report.export_sirh',
                'rrhh.service-request.report.to-pay',
                'rrhh.service-request.report.payed',
                'rrhh.service-request.report.compliance',
                'rrhh.service-request.report.pay-rejected',
                'rrhh.service-request.report.with-bank-details',
                'rrhh.service-request.report.pending-resolutions',
                'rrhh.service-request.report.contract',
                'rrhh.service-request.report.duplicate-contracts',
                'rrhh.service-request.report.with-resolution-file',
                'rrhh.service-request.report.without-resolution-file',
                'rrhh.service-request.report.service-request-continuity'
            )
        }}"
        data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-archive"></i> Reportes
        </a>
        <div class="dropdown-menu">

            @can('Service Request: consolidated data')
            <a class="dropdown-item {{ active('rrhh.service-request.report.consolidated_data') }}"
                href="{{ route('rrhh.service-request.report.consolidated_data') }}">
                <i class="far fa-file-excel"></i> Consolidado
            </a>
            @endcan

            @can('Service Request: program_consolidated_report')
            <a class="dropdown-item {{ active('rrhh.service-request.report.program_consolidated_report') }}"
                href="{{ route('rrhh.service-request.report.program_consolidated_report') }}">
                <i class="far fa-file-excel"></i> Consolidado por Programa
            </a>
            @endcan

            @can('Service Request: active contracts report')
            <a class="dropdown-item {{ active('rrhh.service-request.report.active_contracts_report') }}"
                href="{{ route('rrhh.service-request.report.active_contracts_report') }}">
                <i class="far fa-file-excel"></i> Contratos activos
            </a>
            @endcan

            @can('Service Request: export sirh')
            <a class="dropdown-item  {{ active('rrhh.service-request.report.export_sirh') }}"
                href="{{ route('rrhh.service-request.report.export_sirh') }}">
                <i class="far fa-file"></i> Formato SIRH <small>(para hospital)</small>
            </a>
            @endcan

            @canany(['Service Request: pending requests'])
            <a class="dropdown-item {{ active('rrhh.service-request.pending-requests') }}"
                href="{{ route('rrhh.service-request.pending-requests') }}">
                <i class="fas fa-bomb"></i> Estado de firmas
            </a>
            @endcan

            <div class="dropdown-divider"></div>

            @canany(['Service Request: report to pay'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.to-pay') }}"
                href="{{ route('rrhh.service-request.report.to-pay') }}">
                <i class="fas fa-piggy-bank"></i> Pendientes de pago
            </a>
            @endcan

            @canany(['Service Request: report payed'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.payed') }}"
                href="{{ route('rrhh.service-request.report.payed') }}">
                <i class="fas fa-piggy-bank"></i> Pagados
            </a>
            @endcan

            @canany(['Service Request: pending requests'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.pay-rejected') }}"
                href="{{ route('rrhh.service-request.report.pay-rejected') }}">
                <i class="fas fa-ban"></i> Pagos rechazados
            </a>
            @endcan

            <div class="dropdown-divider"></div>

            @canany(['Service Request: fulfillments rrhh','Service Request: fulfillments finance', 'Service Request: compliance'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.compliance') }}"
                href="{{ route('rrhh.service-request.report.compliance') }}">
                <i class="fas fa-flag-checkered"></i> Cumplimientos
            </a>
            @endcan

            <!-- @canany(['Service Request: pending requests'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.without-bank-details') }}"
                href="{{ route('rrhh.service-request.report.without-bank-details') }}">
                <i class="fas fa-piggy-bank"></i> Sin Cuentas Bancarias
            </a>
            @endcan -->


            @canany(['Service Request: pending requests'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.with-bank-details') }}"
                href="{{ route('rrhh.service-request.report.with-bank-details') }}">
                <i class="fas fa-money-check-alt"></i> Cuentas Bancarias Honorarios
            </a>
            @endcan

            @canany(['Service Request: pending requests'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.pending-resolutions') }}"
                href="{{ route('rrhh.service-request.report.pending-resolutions') }}">
                <i class="fas fa-exclamation-circle"></i> Resoluciones pendientes
            </a>
            @endcan

            @canany(['Service Request: pending requests'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.contract') }}"
                href="{{ route('rrhh.service-request.report.contract') }}">
                <i class="fas fa-file-contract"></i> Reporte de contratos
            </a>
            @endcan

            @canany(['Service Request: pending requests'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.duplicate-contracts') }}"
                href="{{ route('rrhh.service-request.report.duplicate-contracts') }}">
                <i class="fas fa-clone"></i> Contratos Duplicados
            </a>
            @endcan
            

            @canany(['Service Request: pending requests'])
            <a class="dropdown-item {{ active('rrhh.service-request.report.overlapping-contracts') }}"
                href="{{ route('rrhh.service-request.report.overlapping-contracts') }}">
                <i class="fas fa-grip-vertical"></i> Contratos Solapados
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

            @canany(['Service Request: report sr continuity'])
              <a class="dropdown-item {{ active('rrhh.service-request.report.service-request-continuity') }}"
                  href="{{ route('rrhh.service-request.report.service-request-continuity') }}">
                  <i class="fas fa-clone"></i> Continuidad de contratos
              </a>
            @endcan

            @canany(['Service Request: my signatures','Service Request: fulfillments','Service Request: fulfillments finance',
                    'Service Request: fulfillments responsable','Service Request: fulfillments rrhh'])
                <a class="dropdown-item {{ active('rrhh.service-request.report.my-signatures') }}"
                    href="{{ route('rrhh.service-request.report.my-signatures') }}">
                    <i class="fas fa-clone"></i> Mis visaciones
                </a>
            @endcan

            <!-- <div class="dropdown-divider"></div>

            <a class="dropdown-item" href="#">Temp</a> -->

        </div>
    </li>

    @canany(['Service Request: fulfillments rrhh'])
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ active('rrhh.service-request.organizational_unit_limits.*') }}" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-cog"></i> Mantenedores
        </a>
        <div class="dropdown-menu">

          <a class="dropdown-item {{ active('rrhh.service-request.organizational_unit_limits.index') }}"
              href="{{ route('rrhh.service-request.organizational_unit_limits.index') }}">
              Topes por unidad
          </a>

        </div>
    </li>
    @endcan

</ul>
