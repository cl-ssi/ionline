<div>
    <button
        type="button"
        class="btn btn-primary btn-sm"
        data-toggle="modal"
        title="Firmar documento"
        data-target="#sign-to-id-{{ $signatureId }}"
        @if($disabled) disabled @endif
    >
        <i class="fas fa-signature"></i> Firmar
    </button>

    <div class="row">
        @include('sign.modal-show-document')
    </div>
</div>
