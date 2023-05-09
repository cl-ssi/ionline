<div>
    @if(is_null($dte->confirmation_send_at))
    <button type="button" class="btn btn-primary" wire:click="sendConfirmation()">
        <i class="fas fa-paper-plane"></i>
    </button>
    @else
        {{ $dte->confirmation_send_at }}
    @endif
</div>
