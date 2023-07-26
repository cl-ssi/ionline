<div>
    <div class="input-group">
        <input
            type="text"
            class="form-control {{ $small_option ? 'form-control-sm' : '' }}"
            placeholder="Nombre Funcionario"
            aria-label="Nombre"
            wire:keydown.escape="resetx"
        @if(!$user)
            wire:model.debounce.1000ms="query"
            {{ $required }}
        @else
            wire:model.debounce.1000ms="selectedName"
            disabled readonly
        @endif
        onkeydown="return event.key != 'Enter';"
        />

        <div class="input-group-append">
            @if($addUsers)
            <a class="btn btn-outline-secondary {{ $small_option ? 'btn-sm' : '' }}" wire:click="addUser">
                <i class="fas fa-user"></i></a>
            @endif
            <a class="btn btn-outline-secondary {{ $small_option ? 'btn-sm' : '' }}" wire:click="resetx">
                <i class="fas fa-eraser"></i></a>
        </div>
    </div>
    
    <input type="text" name="{{ $selected_id }}" value="{{ optional($user)->id }}" style="display:none;" {{ $required }}>
    
    <!-- TODO revisar si es necesario en los modulos o en que parte traer los eliminados para cambiar el comportamiento del modelo y evitar este if(!$user->trashed()) -->
    @if(!empty($query))
        <ul class="list-group col-12" style="z-index: 3; position: absolute;">
            @if( count($users) >= 1 )
                @foreach($users as $user)
                    @if(!$user->trashed())
                    <a wire:click="setUser({{$user->id}})" wire:click.prevent="addSearchedUser({{ $user }})"
                        class="list-group-item list-group-item-action"
                    >{{ $user->fullName }} </a>
                    @endif
                @endforeach
            @elseif($msg_too_many)
                <div class="list-group-item list-group-item-info">Hemos encontrado muchas coincidencias</div>
            @else
                <div class="list-group-item list-group-item-warning">No hay resultados</div>
            @endif
        </ul>
    @endif
</div>
