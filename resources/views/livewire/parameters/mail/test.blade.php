<div class="row mb-3">
    <div class="col-4">
        <button class="btn btn-primary form-control" wire:click="sendMail" wire:loading.attr="disabled">
            <span wire:loading class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
            </span>
            Probar envío de mail
        </button>
    </div>

    <div class="col">
        @if($mailResponse)
        <div class="alert alert-{{ $status }}" role="alert">
            <pre>{{ $mailResponse }}</pre>
        </div>
        @endif
    </div>
</div>
