<div class="modal fade" id="modal-ppl-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-shopping-cart"></i> Detalle de envíos, cantidad y meses de despacho
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                @livewire('purchase-plan.detail-month-purchase-plan', [
                    'item' => $item
                ])
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>