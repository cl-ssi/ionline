<div>
    @if ($bt == 5)
        <div class="input-group @if ($smallInput) input-group-sm @endif">
            <span class="input-group-text"
                wire:loading.remove
                wire:target="search">
                @if ($user_id == null)
                    <i class="fas fa-times text-danger"></i>
                @else
                    <i class="fas fa-check text-success"></i>
                @endif
            </span>
            <span class="input-group-text"
                wire:loading
                wire:target="search">
                <span class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true">
                </span>
                <span class="sr-only">...</span>
            </span>

            <input type="text"
                id="{{ $tagId }}"
                class="form-control @if ($smallInput) form-control-sm @endif"
                wire:model.live.debounce.1500ms="search"
                placeholder="{{ $placeholder }}"
                @if ($user_id) disabled @endif
                autocomplete="off">

            <button class="btn @if ($smallInput) btn-sm @endif btn-secondary"
                type="button"
                wire:click="clearSearch"
                title="Limpiar">
                <i class="fas fa-eraser"></i>
            </button>

            @error('user_id')
                <span class="invalid-feedback @if ($users->count() > 0) d-none @endif"
                    role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <ul class="list-group"
            style="z-index: 3; position: absolute;">
            @if ($showResult)
                @forelse($users as $user)
                    <a wire:click.prevent="handleSearchedUser({{ $user->id }})"
                        class="list-group-item list-group-item-action">
                        <small>{{ $user->full_name }}</small>
                    </a>
                @empty
                    <div class="list-group-item list-group-item-danger">
                        <small>No hay resultados</small>
                    </div>
                @endforelse
            @endif
        </ul>
    @else
        <div class="input-group @if ($smallInput) input-group-sm @endif has-validation">
            <div class="input-group-prepend">
                <span class="input-group-text"
                    wire:loading.remove
                    wire:target="search">
                    @if ($user_id == null)
                        <i class="fas fa-times text-danger"></i>
                    @else
                        <i class="fas fa-check text-success"></i>
                    @endif
                </span>
                <span class="input-group-text"
                    wire:loading
                    wire:target="search">
                    <span class="spinner-border spinner-border-sm"
                        role="status"
                        aria-hidden="true">
                    </span>
                    <span class="sr-only">...</span>
                </span>
            </div>

            <input type="text"
                id="{{ $tagId }}"
                class="form-control @if ($smallInput) form-control-sm @endif"
                wire:model.live.debounce.1500ms="search"
                placeholder="{{ $placeholder }}"
                @if ($user_id) disabled @endif>
            <div class="input-group-append">
                <button class="btn @if ($smallInput) btn-sm @endif btn-secondary"
                    type="button"
                    wire:click="clearSearch"
                    title="Limpiar">
                    <i class="fas fa-eraser"></i>
                </button>
            </div>

            @error('user_id')
                <span class="invalid-feedback @if ($users->count() > 0) d-none @endif"
                    role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <ul class="list-group col-12"
            style="z-index: 3; position: absolute;">
            @if ($showResult)
                @forelse($users as $user)
                    <a wire:click.prevent="addSearchedUser({{ $user }})"
                        class="list-group-item list-group-item-action py-1">
                        <small>{{ $user->full_name }}</small>
                    </a>
                @empty
                    <div class="list-group-item list-group-item-danger py-1">
                        <small>No hay resultados</small>
                    </div>
                @endforelse
            @endif
        </ul>
    @endif
</div>
