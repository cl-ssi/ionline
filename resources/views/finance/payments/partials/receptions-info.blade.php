@if($dte->purchaseOrder)

    @if($dte->payment_ready)
        <span class="badge text-bg-success">Listo para pago</span>
    @elseif($dte->all_receptions)
        <span class="badge text-bg-warning">Revisión</span>
    @endif
    <br>

    @foreach($dte->purchaseOrder->receptions->where('dte_id',$dte->id) as $reception)
        @if($reception->signedFileLegacy)
            <a class="btn btn-sm btn-outline-primary" 
                href="{{ route('file.download', $reception->signedFileLegacy) }}" 
                target="_blank">
                <i class="bi bi-file-earmark-ruled"></i>
                {{ $reception->id }}
            </a>
        @else
            @if($reception->numeration?->number )
                <a class="btn btn-sm btn-outline-primary" target="_blank"
                    href="{{ route('documents.partes.numeration.show_numerated', $reception->numeration) }}"
                    title="Recepcion Numerada">
                    <i class="bi bi-file-earmark-ruled"></i>
                    {{ $reception->id }}
                </a>
            @else
                <a class="btn btn-sm btn-outline-primary" target="_blank"
                    href="{{ route('finance.receptions.show', $reception->id) }}"
                    title="Recepcion sin numerar">
                    <i class="bi bi-file-earmark-ruled"></i>
                    {{ $reception->id }}
                </a>
            @endif
        @endif
        
    @endforeach

    <br>

    @if($dte->purchaseOrder->receptions->count() > 0)
        <span class="text-success">
            {{ $dte->purchaseOrder->receptions->count() }}
        </span>
    @endif

    @if($dte->purchaseOrder->rejections->count() > 0)
        <span class="text-danger">
            {{ $dte->purchaseOrder->rejections->count() }}
        </span>
    @endif
@endif