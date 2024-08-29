<div class="d-inline">
    <button
        class="{{ $btn_class }}"
        wire:click='show'
    >
        <i class="{{ $btn_icon }}"></i> {{ $btn_title }}
    </button>


    @if($showModal)
        <!-- Modal -->
        <div class="modal {{ $showModal }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="container">
                            <div class="row">
                                <div class="col-7 text-left">
                                    <h5 class="modal-title">
                                        Firmará como {{ $signer->shortName }}
                                    </h5>
                                </div>
                                <div class="col-5">
                                    <div class="row text-right">
                                        <div class="col-10 text-right">
                                            <div class="input-group ">
                                                <input
                                                    id="otp"
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    placeholder="OTP"
                                                    aria-label="OTP"
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
                                            <div class="text-left mt-1" style="line-height: 15px; font-height: 10px">
                                                @if(isset($message))
                                                    <small id="otp" class="text-danger">
                                                        {{ $message }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-2 text-right">
                                            <button
                                                type="button"
                                                class="close text-right"
                                                data-dismiss="modal"
                                                aria-label="Close"
                                                wire:click="dismiss"
                                            >
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <embed
                            src="data:application/pdf;base64,{{ $pdfBase64 }}"
                            type="application/pdf"
                            width="100%"
                            height="600px"
                        />
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
    @endif
</div>
