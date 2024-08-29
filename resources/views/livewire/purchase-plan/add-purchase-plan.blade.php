<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="modal-{{$purchasePlan->id}}" tabindex="-1" aria-labelledby="modalAddPurchasePlanId" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalAddPurchasePlanId">
                    Ingreso ID de Mercado Público (ID iOnline: {{ $purchasePlan->id }})
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3 mb-3">
                    <fieldset class="form-group col-12 col-md-4">
                        <label for="for_telephone">ID Mercado Público</label>
                        <input class="form-control" type="text" autocomplete="off" wire:model="mercadoPublicoId">
                        @error('mercadoPublicoId') <span class="text-danger error small">{{ $message }}</span> @enderror
                    </fieldset>

                    <fieldset class="form-group col-12 col-sm-4">
                        <label for="for_date">Publicacion en Mercado Público</label>
                        <input type="date" class="form-control" wire:model="date" id="for_date">
                        @error('date') <span class="text-danger error small">{{ $message }}</span> @enderror
                    </fieldset>

                    <fieldset class="form-group col-12 col-sm-4">
                        <label for="forFileAttached" class="form-label"></label>
                        <input class="form-control" type="file" wire:model="fileAttached" id="upload({{ $iterationFileClean }})">
                        <div wire:loading wire:target="fileAttached">Cargando archivo...</div>
                        @error('fileAttached') <span class="text-danger error small">{{ $message }}</span> @enderror
                    </fieldset>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-sm" wire:click="save" wire:loading.attr="disabled"><i class="fas fa-save"></i> Guardar</button>
            </div>
            </div>
        </div>
    </div>
</div>
