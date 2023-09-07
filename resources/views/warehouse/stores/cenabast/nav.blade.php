<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ $tray === null ? 'active' : '' }}" href="{{ route('warehouse.cenabast.index') }}">Todos los Dtes de Cenabast</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $tray === 'sin_adjuntar' ? 'active' : '' }}" href="{{ route('warehouse.cenabast.index', ['tray' => 'sin_adjuntar']) }}">Dtes de Cenabast sin Adjuntar Acta</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $tray === 'adjuntados' ? 'active' : '' }}" href="{{ route('warehouse.cenabast.index', ['tray' => 'adjuntados']) }}">Dtes de Cenabast Adjuntados</a>
    </li>
</ul>
