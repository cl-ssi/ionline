<ul class="nav nav-tabs mb-3">
    @can('HIS Modification Request: User')
    <li class="nav-item">
        <a class="nav-link {{ active('his.modification-request.new') }}" 
            href="{{ route('his.modification-request.new') }}">
            <i class="fas fa-plus"></i> Nueva solicitud</a>
    </li>    
    <li class="nav-item">
        <a class="nav-link {{ active('his.modification-request.index') }}" 
            href="{{ route('his.modification-request.index') }}">
            <i class="fas fa-file-medical"></i>  Mis solicitudes</a>
    </li>
    @endcan
    @canany(['HIS Modification Request: Manager'])
    <li class="nav-item">
        <a class="nav-link {{ active('his.modification-request.mgr') }}" 
            href="{{ route('his.modification-request.mgr') }}">
            <i class="fas fa-chess"></i> Administrador de solicitudes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('his.modification-request.parameters') }}" 
            href="{{ route('his.modification-request.parameters') }}">
            <i class="fas fa-cog"></i> Parametros</a>
    </li>
    @endcanany
</ul>