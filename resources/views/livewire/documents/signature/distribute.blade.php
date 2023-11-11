<div>
    @if( $signature->status == 'completed' AND $signature->created_at > now()->create(2023, 11, 01) )
    <button class="btn btn-sm btn-primary" title="Volver a distribuir" wire:loading.attr="disabled"
        wire:click="distributeDocument({{ $signature }})">
        <i class="fas fa-paper-plane"></i>
    </button>
    @endif
</div>
