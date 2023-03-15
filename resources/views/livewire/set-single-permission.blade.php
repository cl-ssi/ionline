<button class="btn" wire:click="setPermission">
    <i class="fas fa-{{ $icon }} {{ $user->can($permission) ? 'text-success':'text-primary' }}" 
        title="{{ $permission }}">
    </i>
</button>