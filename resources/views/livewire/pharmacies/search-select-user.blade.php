<div class="form-row">

    <fieldset class="form-group col-3">
        <label for="for_date">Fecha</label>
        <input 
            type="date" 
            class="form-control" 
            id="for_date" 
            name="date" 
            @if($date) value="{{ $date->format('Y-m-d') }}" @endif
            required="required"
        >
    </fieldset>

    <fieldset class="form-group col">
        <label for="for_patient">Paciente</label>
        <div class="input-group">
            <input
                type="text"
                class="form-control {{ $small_option ? 'form-control-sm' : '' }}"
                placeholder="Nombre Paciente"
                aria-label="Nombre"
                wire:keydown.escape="resetx"
            @if(!$user)
                wire:model.live.debounce.1000ms="query"
                {{ $required }}
            @else
                wire:model.live.debounce.1000ms="selectedName"
                disabled readonly
            @endif
            onkeydown="return event.key != 'Enter';"
            />

                @if($addUsers)
                <a class="btn btn-outline-secondary {{ $small_option ? 'btn-sm' : '' }}" wire:click="addUser">
                    <i class="fas fa-user"></i></a>
                @endif
                <a class="btn btn-outline-secondary {{ $small_option ? 'btn-sm' : '' }} {{ $disabled }}" wire:click="resetx">
                    <i class="fas fa-eraser"></i></a>
        </div>
    </fieldset>
    
    <input type="text" name="{{ $selected_id }}" value="{{ optional($user)->id }}" style="display:none;" {{ $required }} {{$disabled}}>

    <!-- TODO revisar si es necesario en los modulos o en que parte traer los eliminados para cambiar el comportamiento del modelo y evitar este if(!$user->trashed()) -->
    @if(!empty($query))
        <ul class="list-group" style="z-index: 3; position: absolute;">
            @if( count($users) >= 1 )
                @foreach($users as $user)
                    @if(!$user->trashed())
                    <a wire:click="setUser({{$user->id}})" wire:click.prevent="addSearchedUser({{ $user }})"
                        class="list-group-item list-group-item-action"
                    >{{ $user->full_name }} </a>
                    @endif
                @endforeach
            @elseif($msg_too_many)
                <div class="list-group-item list-group-item-info">Hemos encontrado muchas coincidencias</div>
            @else
                <div class="list-group-item list-group-item-warning">No hay resultados</div>
            @endif
        </ul>
    @endif

    <fieldset class="form-group col">
        <label for="for_origin_establishment_name">Centro de salud</label>
        <input 
            type="text" 
            class="form-control" 
            id="for_origin_establishment_name" 
            name="origin_establishment_name" 
            value="{{ $originEstablishmentName }}" 
            disabled 
            wire:model="originEstablishmentName"
        />
    </fieldset>

    <input 
        type="hidden" 
        id="for_origin_establishment_id" 
        name="origin_establishment_id" 
        value="{{ $originEstablishmentId }}" 
        wire:model="originEstablishmentId"
    />

</div>
