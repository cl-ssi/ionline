<button class="btn" wire:click="setPermission">
    <i class="fas fa-globe {{ $user->can($permission) ? 'text-success':'text-primary' }}" title="Nuevo iOnline"></i>
</button>