<div class="row mb-3">
    <div class="col-3">
        <button class="btn btn-primary form-control" wire:click="sendMail" wire:loading.attr="disabled">
            Probar envío de mail
        </button>
    </div>

    <div class="col-1">
        <div wire:loading class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="col">
        @if($mailResponse)
        <div class="alert alert-{{ $status }}" role="alert">
            <pre>{{ $mailResponse }}</pre>
        </div>
        @endif
    </div>
</div>
