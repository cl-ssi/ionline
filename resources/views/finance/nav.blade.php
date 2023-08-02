<ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ active('finance.dtes.index') }}" href="{{ route('finance.dtes.index') }}">Ver dtes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('finance.dtes.upload') }}">Cargar archivo</a>
        </li>        
        <li class="nav-item">
        <a class="nav-link {{ active('finance.payments.review') }}" href="{{ route('finance.payments.review') }}">Bandeja de Revisión de Pago</a>
        </li>
        <li class="nav-item">
        <a class="nav-link {{ active('finance.payments.ready') }}" href="{{ route('finance.payments.ready') }}">Bandeja de Pendientes para Pago</a>
        </li>
    </ul>