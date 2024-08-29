<div>
    <div class="row mb-3">
        <div class="col-4">
            <div class="input-group">
                <input
                    type="text"
                    class="form-control"
                    placeholder="OTP"
                    aria-label="OTP"
                    wire:model="otp"
                    maxlength="6"
                    minlength="6"
                    required="required"
                >
                <div class="input-group-append">
                    <button
                        class="btn btn-primary"
                        wire:click="sign"
                        wire:target="sign"
                        wire:loading.attr="disabled"
                    >
                        <span
                            class="spinner-border spinner-border-sm"
                            role="status"
                            wire:loading
                            wire:target="sign"
                            aria-hidden="true"
                        >
                        </span>

                        <span
                            wire:loading.remove
                            wire:target="sign"
                        >
                        </span>
                        Prueba Firma
                    </button>
                </div>
            </div>
        </div>
        <div class="col-8">
            @if($type_message && $message)
            <div class="alert alert-{{ $type_message }}" role="alert">
                {{ $message }}
            </div>
            @endif
        </div>
    </div>
</div>
