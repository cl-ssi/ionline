<div>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ active('his.new-modification') }}" 
                href="{{ route('his.new-modification') }}">
                <i class="fas fa-plus"></i> Nueva solicitud</a>
        </li>    
        <li class="nav-item">
            <a class="nav-link {{ active('his.modification-mgr') }}" 
                href="{{ route('his.modification-mgr') }}">
                <i class="fas fa-list"></i> Listado de solicitudes</a>
        </li>    
    </ul>

    <h3 class="mb-3">Nueva solicitud Rayen</h3>

    <div class="form-row">

        <div class="form-group col">
            <label for="for_creator_id">Solicitante</label>
            <input type="text" class="form-control" id="for_creator_id" 
            value="{{ auth()->user()->shortName }}" disabled>
        </div>
        
        <div class="form-group col">
            <label for="for_creator_email">Email solicitante</label>
            <input type="email" class="form-control" id="for_creator_email" 
            value="{{ auth()->user()->email }}" disabled>
        </div>
    </div>

    <div class="form-group">
        <label for="for_type">Tipo de solicitud</label>
        <select class="form-control" id="for_type" wire:model.defer="modrequest.type">
            <option></option>
            @foreach($types as $type)
                <option>{{ $type }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="for_subject">Asunto de la solicitud</label>
        <input type="text" class="form-control" id="for_subject" wire:model.defer="modrequest.subject">
    </div>
    
    <div class="form-group">
        <label for="for_body">Detalle de la solicitud</label>
        <textarea class="form-control" id="for_body" rows="5" wire:model.defer="modrequest.body"></textarea>
    </div>

    <!-- <div class="form-group">
        <label for="exampleFormControlTextarea1">Por solicitud de: (Opcional)</label>
        <input type="text" class="form-control" id="exampleFormControlInput1">
    </div> -->
    
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Adjuntar archivos opcional (ej: norma)</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFileLang" lang="es" disabled>
            <label class="custom-file-label" for="customFileLang" data-browse="Examinar">Seleccionar Archivo</label>
        </div>
    </div>

    @include('layouts.partials.flash_message')
    
    <button class="btn btn-primary" wire:click="save">Crear</button>
</div>
