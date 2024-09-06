<div>
    @if($document->number)
        {{ $document->number }}
        @if($delete)
            <button class="btn btn-sm btn-outline-danger" wire:click.prevent="deleteNumber"><i class="fas fa-trash"></i> </button>
        @endif
    @else
        <button class="btn btn-sm btn-outline-primary" wire:click.prevent="enumerate">Numerar</button>
    @endif
</div>
