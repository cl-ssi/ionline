<div>
    <div class="input-group">
        <input
            type="text"
            class="form-control"
            placeholder="Nombre Funcionario"
            aria-label="Nombre"
            wire:keydown.escape="resetx"
        @if(!$user)
            wire:model.debounce.1000ms="query"
            required
        @else
            wire:model.debounce.1000ms="selectedName"
            disabled readonly
        @endif
        />

        <div class="input-group-append">
            <a class="btn btn-outline-secondary" wire:click="resetx">
                <i class="fas fa-eraser"></i> Limpiar</a>
        </div>
    </div>
    
    <input type="text" name="{{ $selected_id }}" value="{{ optional($user)->id }}" style="display:none;" required>
    
    @if(!empty($query))
        <ul class="list-group col-12" style="z-index: 3; position: absolute;">
            @if( count($users) >= 1 )
                @foreach($users as $user)
                    <a wire:click="setUser({{$user->id}})" wire:click.prevent="addSearchedUser({{ $user }})"
                        class="list-group-item list-group-item-action"
                    >{{ $user->fullName }} </a>
                @endforeach
            @elseif($msg_too_many)
                <div class="list-group-item list-group-item-info">Hemos encontrado muchas coincidencias</div>
            @else
                <div class="list-group-item list-group-item-warning">No hay resultados</div>
            @endif
        </ul>
    @endif
</div>
