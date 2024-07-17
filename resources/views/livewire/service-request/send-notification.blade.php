<div>
    @if (!$notificationSent)
        <div wire:loading.remove>
            <button type="button" class="btn btn-outline-warning" wire:click='sendNotification'>
                <i class="fas fa-envelope" title="Enviar notificación"></i>
            </button>
        </div>

        <i class="fa fa-spinner fa-spin" wire:loading></i>
    @else
        <div class="alert alert-success">
            OK
        </div>
    @endif
</div>