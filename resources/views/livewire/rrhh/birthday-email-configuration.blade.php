<div>

    <h3 class="mb-3">Configuración correo de cumpleaños</h3>


    @if($configuration)
    <div class="card">
        <div class="card-header">
            {{$configuration->subject}}
            <span style="float:right">
                <a href="">Editar</a>
            </span>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{$configuration->tittle}}</h5>
            <p class="card-text">Estimado(a) @nombre,</p>
            <p class="card-text">{!!$configuration->message!!}</p>
        </div>
    </div>
    @endif


    <!-- <div class="form-row">
        <fieldset class="form-group col-12">
            <label>Asunto</label>
            <input type="text" class="form-control" wire:model="subject">
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12">
            <label>Título</label>
            <input type="text" class="form-control" wire:model="tittle">
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12">
            <label>Mensaje</label>
            <input type="text" class="form-control" wire:model="message">
        </fieldset>
    </div>
    
    <button type="button" class="btn btn-primary mt-1 mb-4" wire:click="save()">Guardar</button> -->

</div>
