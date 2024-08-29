<!-- Modal -->
<div
    class="modal fade"
    data-backdrop="static"
    id="sign-multiple"
    tabindex="-1"
    {{-- role="dialog" --}}
    aria-labelledby="modalTitle"
    aria-hidden="true"
    >
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5
                    class="modal-title"
                    id="modalTitle"
                >
                    Firmar Multiples
                </h5>
            </div>
            <div class="modal-body text-center">
                Documentos a firmar:
                @foreach($selectedSignatures as $selectedSignature)
                    {{ $selectedSignature }},
                @endforeach
                <br>
                <br>
                <label for="otp">OTP</label>
                <input
                    type="text"
                    class="form-control"
                    wire:model="otp"
                    id="otp"
                >
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
                    wire:click="signToMultiple"
                >
                    Enviar a firmar
                </button>
            </div>
        </div>
    </div>
</div>