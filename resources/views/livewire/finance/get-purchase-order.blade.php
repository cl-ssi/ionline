<div>
    @if($dte->folio_oc)
        @if($dte->purchaseOrder)
            <a target="_blank" href="{{ route('finance.purchase-orders.show', $dte->purchaseOrder) }}">
                {{ $dte->folio_oc }}
            </a>
            <br>
            {{ $dte->purchaseOrder->json->Listado[0]->Estado }}
        @else
            {{ $dte->folio_oc }}
        @endif
        <br>
        <button class="btn btn-sm {{ $dte->purchaseOrder ? 'btn-outline-primary' : 'btn-primary' }}" wire:click="getPurchaseOrder" 
            wire:loading.attr="disabled"
            wire:loading.class="spinner-border">
            <i class="fab fa-markdown"></i>
        </button>
        {{ $message }}
    @endif
</div>
