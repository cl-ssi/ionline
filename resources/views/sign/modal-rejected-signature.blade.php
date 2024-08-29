<!-- Modal -->
<div
    wire:model.live
    class="modal fade"
    id="rejected-signature-to-{{ $signature->id }}"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
    data-backdrop="static"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <div class="container">
                    <div class="row">
                        <div class="col-8 text-left">
                            <h5 class="modal-title">
                                Rechazar #{{ $signature->id }}
                            </h5>
                        </div>
                        <div class="col-4">
                            <div class="row">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <fieldset class="form-group col">
                        <label for="observation">Observacion de rechazo</label>
                        <input
                            type="text"
                            class="form-control @error('observation') is-invalid @enderror"
                            id="observation"
                            wire:model="observation"
                        >
                        @error('observation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                </div>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                >
                    Cerrar
                </button>
                <button
                    type="button"
                    class="btn btn-primary"
                    wire:click="rejectedSignature({{ $signature }})"
                    wire:loading.attr="disabled"
                >
                    <span
                        wire:loading.remove
                        wire:target="rejectedSignature"
                    >
                        <i class="fas fa-times"></i>
                    </span>

                    <span
                        class="spinner-border spinner-border-sm"
                        role="status"
                        wire:loading
                        wire:target="rejectedSignature"
                        aria-hidden="true"
                    >
                    </span>

                    Rechazar y terminar
                </button>
            </div>
        </div>
    </div>
</div>
