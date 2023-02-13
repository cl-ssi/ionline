<div>
    @section('title', 'Mis subrogantes')

    @switch($view)

        @case('index')
            @if($organizationalUnit)
                <h5 class="mb-3">
                    <i class="fas fa-chess"></i> Subrogantes de Autoridad {{$organizationalUnit->name?? ''}} de tipo @if($type) {{$type}} @endif
                    <button class="btn btn-success float-right"
                        wire:click="create"><i class="fas fa-plus"></i> Agregar nuevo</button>
                </h5>
                @include('profile.subrogation.index')
            @else
                <h5 class="mb-3">
                    <i class="fas fa-chess"></i> ¿Quienes son mis subrogantes? 
                    <button class="btn btn-success float-right"
                        wire:click="create"><i class="fas fa-plus"></i> Agregar nueva persona que me subrogaría</button>
                </h5>
                @include('profile.subrogation.index')
            @endif
            @break

        @case('create')
            <h5 class="mb-3">Crear nueva subrogancia @if($type)de tipo {{$type}} @endif</h5>
            @include('profile.subrogation.form')
            <button type="button" class="btn btn-primary"
                wire:click="store">Crear</button>
            <button type="button" class="btn btn-outline-secondary"
                wire:click="index">Cancelar</button>
            @break

        @case('edit')
            <h5 class="mb-3">Editar subrogancia</h5>
            @include('profile.subrogation.form')
            <button type="button" class="btn btn-primary"
                wire:click="update({{$subrogation}})">Guardar</button>
            <button type="button" class="btn btn-outline-secondary"
                wire:click="index">Cancelar</button>
            @break

    @endswitch
</div>