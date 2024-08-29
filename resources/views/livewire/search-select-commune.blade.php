<div>
    <div class="input-group">
        <input
            type="text"
            class="form-control {{-- $small_option ? 'form-control-sm' : '' --}}"
            placeholder="Comuna"
            aria-label="Nombre"
            wire:keydown.escape="resetx"
            @if(!$commune)
                wire:model.live.debounce.1000ms="query"
                {{ $required }}
            @else
                wire:model.live.debounce.1000ms="selectedCommuneName"
                disabled readonly
            @endif
        />

        <div class="input-group-append">
            <a class="btn btn-outline-secondary {{-- $small_option ? 'btn-sm' : '' --}}" wire:click="resetx">
                <i class="fas fa-eraser"></i> Limpiar</a>
        </div>
    </div>
    
    <input type="text" name="{{ $selected_id }}" value="{{ optional($commune)->id }}" style="display:none;" $required>
    @if(!empty($query))
        <ul class="list-group col-12" style="z-index: 3; position: absolute;">
            @if( count($communes) >= 1 )
                @foreach($communes as $commune)
                    <a wire:click="setCommune({{ $commune->id }})" wire:click.prevent="addSearchedCommune({{ $commune }})"
                        class="list-group-item list-group-item-action"
                    >{{ $commune->name }} </a>
                @endforeach
            @elseif($msg_too_many)
                <div class="list-group-item list-group-item-info">Hemos encontrado muchas coincidencias</div>
            @else
                <div class="list-group-item list-group-item-warning">No hay resultados</div>
            @endif
        </ul>
    @endif
</div>
