<div>
    @if (!$user->trashed())
        <a href="{{ route('rrhh.users.edit', $user->id) }}" class="btn btn-outline-primary">
            <span class="fas fa-edit" aria-hidden="true"></span></a>
        <a href="{{ route('rrhh.users.switch', $user->id) }}" class="btn btn-outline-warning"
            @disabled(auth()->user()->godMode)>
            <span class="fas fa-redo" aria-hidden="true"></span></a>
    @else
        <a wire:click='undoUserDeletion' class="btn btn-outline-success" title="Restaurar Usuario">
            <span class="fas fa-history" aria-hidden="true"></span>
        </a>
    @endif
</div>
