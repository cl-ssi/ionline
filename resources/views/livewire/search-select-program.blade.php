<div>
    <div class="input-group">
        <input
            type="text"
            class="form-control {{ $small_option ? 'form-control-sm' : '' }}"
            placeholder="Nombre de Programa"
            aria-label="Nombre"
            wire:keydown.escape="resetx"
            @if(!$program)
                wire:model.live.debounce.1000ms="query"
                {{ $required }}
            @else
                wire:model.live.debounce.1000ms="selectedProgramName"
                disabled readonly
            @endif
        />

        <div class="input-group-append">
            <a class="btn btn-outline-secondary {{ $small_option ? 'btn-sm' : '' }} {{$disabled}}" wire:click="resetx">
                <i class="fas fa-eraser"></i></a>
        </div>
    </div>
    
    <input type="text" name="{{ $selected_id }}" value="{{ optional($program)->id }}" style="display:none;" {{ $required }} {{$disabled}}>
    @if(!empty($query))
        <ul class="list-group col-12" style="z-index: 3; position: absolute;">
            @if( count($programs) >= 1 )
                @foreach($programs as $program)
                    <a wire:click="setProgram({{ $program->id }})" wire:click.prevent="addSearchedProgram({{ $program }})"
                        class="list-group-item list-group-item-action"
                    >{{ $program->name }} {{$program->period}} subtítulo {{$program->Subtitle->name}} </a>
                @endforeach
            @elseif($msg_too_many)
                <div class="list-group-item list-group-item-info">Hemos encontrado muchas coincidencias</div>
            @else
                <div class="list-group-item list-group-item-warning">No hay resultados</div>
            @endif
        </ul>
    @endif
</div>
