<div class="form-row">
    <fieldset class="form-group col-12 col-md-4">
        <label for="for_establishment_id">Establecimiento</label>

        <div id="for-picker" wire:ignore>
            <select
                class="form-control selectpicker"
                id="for_establishment_id"
                wire:model.live="establishment_id"
                wire:change="change"
                data-live-search="true"
                data-size="5"
                data-container="#for-picker"
                required
            >
                <option value=""></option>
                @foreach($establishments as $establishment)
                    <option value="{{$establishment->id}}">{{$establishment->name}}</option>
                @endforeach
            </select>
        </div>
    </fieldset>

    <fieldset class="form-group col-12 col-md-8">
        <label for="for_ou_id">Unidad Organizacional</label>
        <div class="input-group">
            <input
                type="text"
                class="form-control"
                id="for_ou_id"
                placeholder="Nombre"
                aria-label="Nombre"
                wire:keydown.escape="resetx"
            @if(!$ou)
                wire:model.live.debounce.1000ms="query"
                required
            @else
                wire:model.live.debounce.1000ms="selectedName"
                disabled readonly
            @endif
            />

            <div class="input-group-append">
                <a class="btn btn-outline-secondary" wire:click="resetx">
                    <i class="fas fa-eraser"></i> Limpiar
                </a>
            </div>
        </div>

        @if($ou)
            <input type="hidden" name="{{ $selected_id }}" value="{{ $ou->id }}" required>
        @endif

        @if(!empty($query))
            <ul class="list-group col-12" style="z-index: 3; position: absolute;">
                @if( count($ous) >= 1 )
                    @foreach($ous as $ou)
                        <a
                            wire:click="setOu({{$ou->id}})"
                            class="list-group-item list-group-item-action py-1"
                        >
                            {{ $ou->name }}
                        </a>
                    @endforeach
                @elseif($msg_too_many)
                    <div class="list-group-item list-group-item-info py-1">
                        Hemos encontrado muchas coincidencias
                    </div>
                @else
                    <div class="list-group-item list-group-item-warning py-1">
                        No hay resultados
                    </div>
                @endif

            </ul>
        @endif

    </fieldset>

    <div wire:loading>
        Cargando...
    </div>

</div>
