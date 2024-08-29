<!-- Modal -->
<div
    class="modal fade"
    id="sign-to-id-{{ $signatureId }}"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container">
                    <div class="row">
                        <div class="col-8 text-left">
                            <h5 class="modal-title">
                                Firmar #{{ $signatureId }}
                            </h5>
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="col-9 text-right">
                                    <div class="input-group ">
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            placeholder="Ingrese el OTP"
                                            aria-label="Ingrese el OTP"
                                            aria-describedby="button-addon2"
                                            wire:model="otp"
                                            wire:keydown.enter="signDocument"
                                            autofocus
                                            autocomplete="off"
                                        >
                                        <div class="input-group-append">
                                            <button
                                                class="btn btn-primary btn-sm"
                                                wire:click="signDocument"
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
                                <div class="col-3 text-right">
                                    <button
                                        type="button"
                                        class="close text-right" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body text-center">
                <object
                    type="application/pdf"
                    data="{{ $link }}"
                    width="100%"
                    height="400"
                    style="height: 70vh;"
                >
                </object>
            </div>
        </div>
    </div>
</div>
