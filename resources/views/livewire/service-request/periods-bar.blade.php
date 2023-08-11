<ul class="nav nav-tabs card-header-tabs mx-auto">
    @foreach($meses as $numero => $mes)
    <li class="nav-item">
        <a class="nav-link @disabled(!$periods[$numero]) @if($period == $numero) active @endif" 
            href="{{ route('rrhh.service-request.show', ['user' => $user_id, 'year' => $year, 'type' => $type, 'serviceRequest' => $serviceRequest, 'period' => $numero]) }}#periods-card">
            {{ $mes }}
            @if($periods[$numero] == null) 
            <span class="badge badge-pill badge-secondary">&nbsp;</span>
            @elseif($numero > date('n') AND $year == date('Y'))
            <span class="badge badge-pill badge-primary">&nbsp;</span>
            @elseif($periods[$numero] === true)
            <span class="badge badge-pill badge-warning">$</span>
            @else
            <span class="badge badge-pill badge-success">$</span>
            @endif
        </a>
    </li>
    @endforeach
    <!-- Código para agregar un periodo -->
    <li class="nav-item small">
        <button type="submit" class="nav-link text-success small" title="Agregar un nuevo periodo" wire:click="add_period()">
        <i class="fas fa-plus"></i>
        </button>
    </li>
</ul>
