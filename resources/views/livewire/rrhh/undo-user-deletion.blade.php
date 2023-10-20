<div>
    @if (!$user->trashed())
        <a href="{{ route('rrhh.users.edit', $user->id) }}" class="btn btn-outline-primary">
            <i class="bi bi-pencil-square"></i></a>
        <a href="{{ route('rrhh.users.switch', $user->id) }}" class="btn btn-outline-warning"
            @disabled(auth()->user()->godMode)>
            <i class="bi bi-arrow-clockwise"></i></a>
    @else
        <a wire:click='undoUserDeletion' class="btn btn-outline-success" title="Restaurar Usuario">
            <i class="bi bi-clock-history"></i>
        </a>
    @endif
</div>
