<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="modal-assign-{{$purchasePlan->id}}" tabindex="-1" aria-labelledby="modalAssignPurchasePlan" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalAssignPurchasePlan">
                    Asignar Plan de Compra: {{ $purchasePlan->id }}
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label>Comprador</label>
                <select class="form-select" aria-label="Default select example" wire:model="assignUserId">
                    <option value="">Selecione...</option>
                    @foreach($purchasers as $purchaser)
                        <option value="{{ $purchaser->id }}">{{ $purchaser->fullName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-sm" wire:click="save"><i class="fas fa-save"></i> Guardar</button>
            </div>
            </div>
        </div>
    </div>
</div>
