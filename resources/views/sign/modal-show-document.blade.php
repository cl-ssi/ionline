<!-- Modal -->
<div class="modal fade" id="sign-to-id-{{ $signature->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Firmar Solicitud #{{ $signature->id }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <object
                    type="application/pdf"
                    data="{{ $signature->link }}"
                    width="100%" height="400" style="height: 70vh;">
                </object>
            </div>

            <div class="modal-footer">
                <div class="form-row">
                    <div class="col-8">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Ingrese el OTP"
                            aria-label="Recipient's username"
                            aria-describedby="button-addon2"
                            wire:model.defer="otp"
                        >
                    </div>
                    <div class="col-4">

                        <button
                            class="btn btn-primary"
                            type="button"
                            id="button-addon2"
                            wire:click="signDocument({{ $signature }})"
                            wire:loading.attr="disabled"
                            wire:target='signDocument'
                        >
                            <span
                                wire:loading.remove
                                wire:target="signDocument"
                            >
                            <i class="fas fa-signature"></i>
                            </span>

                            <span
                                class="spinner-border spinner-border-sm"
                                role="status"
                                wire:loading
                                wire:target="signDocument"
                                aria-hidden="true"
                            >
                            </span>

                            Firmar
                        </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
