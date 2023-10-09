<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ active('finance.dtes.index') }}" 
            href="{{ route('finance.dtes.index') }}">
            <i class="fas fa-fw fa-file-invoice-dollar"></i> Dtes</a>
    </li>    
    <li class="nav-item">
        <a class="nav-link {{ active('finance.payments.review') }}"
            href="{{ route('finance.payments.review') }}">
            <i class="fas fa-fw fa-dollar-sign"></i> Bandeja de Revisión</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('finance.payments.ready') }}" 
            href="{{ route('finance.payments.ready') }}">
            <i class="fas fa-fw fa-piggy-bank"></i> Bandeja Listos para Pago</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('finance.payments.rejected') }}"
            href="{{ route('finance.payments.rejected') }}">
            <i class="fas fa-fw fa-ban"></i> Rechazadas</a>
    </li>
</ul>
