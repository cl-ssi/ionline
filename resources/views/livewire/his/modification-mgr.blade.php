<div>
    @section('title', 'Solicitudes Rayen')
    
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

    @if ($form)
        <h3>Editar Solicitud</h3>
        <div class="form-row">

            <div class="form-group col">
                <label for="for_creator_id">Solicitante</label>
                <input type="text" class="form-control" id="for_creator_id" 
                value="{{ $modrequest->creator->shortName }}" disabled>
            </div>

            <div class="form-group col">
                <label for="for_creator_email">Email solicitante</label>
                <input type="email" class="form-control" id="for_creator_email" 
                value="{{ $modrequest->creator->email }}" disabled>
            </div>
        </div>

        <div class="form-group">
            <label for="for_type">Tipo de solicitud</label>
            <select class="form-control" id="for_type" wire:model.defer="modrequest.type">
                <option></option>
                @foreach($param_types as $type)
                    <option>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="for_subject">Asunto de la solicitud</label>
            <input type="text" class="form-control" id="for_subject" wire:model.defer="modrequest.subject">
            @error('modrequest.subject') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="for_body">Detalle de la solicitud</label>
            <textarea class="form-control" id="for_body" rows="5" wire:model.defer="modrequest.body"></textarea>
            @error('modrequest.body') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <ul>
            <li>
                <a href="#">Archivo 1</a> (pendiente vincular con modelo archivos)
            </li>
            <li>
                <a href="#">Archivo 2</a>
            </li>
        </ul>
        <hr>

        <h3 class="mb-2">Herramienta de Papá Cristian</h3>

        <div class="row">

            <div class="col-9">

                @foreach($ous as $ou)
                <div class="custom-control custom-switch">
                    <input type="checkbox" 
                        class="custom-control-input" 
                        id="for_switch_{{$ou->id}}" 
                        wire:model.defer="vb.{{$ou->id}}"
                        checked>
                    <label class="custom-control-label" for="for_switch_{{$ou->id}}">
                        {{ $ou->name }}
                        ({{ $ou->currentManager?->user->shortName }})
                    </label>
                </div>
                @endforeach

            </div>
            <div class="col-3">
                <button type="button" class="btn btn-primary" wire:click="setApprovals({{$modrequest}})">
                    <i class="fas fa-paper-plane"></i> Enviar para VB</button>
            </div>
        </div>

        <div class="form-group mt-3">
            <label for="for_observation">Observacion interna</label>
            <textarea class="form-control" id="for_observation" rows="5" wire:model.defer="modrequest.observation"></textarea>
            @error('modrequest.observation') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-row mt-3">
            <div class="form-group col-3">
                <label for="for_type">Estado de la wea</label>
                <select class="form-control" id="for_type" wire:model.defer="modrequest.status">
                    <option value="">Pendiente VBs</option>
                    <option value="1">Ta lista la wea</option>
                    <option value="0">Rechazada</option>
                </select>
            </div>
        </div>
            
        <div class="form-row mt-2">
            <div class="mt-3 col-12">
                <button type="button" class="btn btn-success" wire:click="save()">Guardar</button>
                <button type="button" class="btn btn-outline-secondary" wire:click="index()">Cancelar</button>
            </div>
        </div>

        {{ print_r($vb) }}
    @else

        <h3 class="mb-3">Listado de modificaciones</h3>

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Solicitante</th>
                    <th>Tipo</th>
                    <th>Asunto</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($modifications as $modification)
                <tr>
                    <td>{{ $modification->id }}</td>
                    <td>{{ $modification->creator->shortName }}</td>
                    <td>{{ $modification->type }}</td>
                    <td>{{ $modification->subject }}</td>
                    <td>{{ $modification->created_at }}</td>
                    <td>
                        @switch($modification->status)
                            @case('1')
                                Listo
                            @break
                            @case('0')
                                Rechazado
                            @break
                            @default
                                Pendiente VBs
                            @break
                        @endswitch
                        </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary" 
                            wire:click="form({{$modification}})"><i class="fas fa-edit"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $modifications->links() }}
        
        
        <h5>Pendientes:</h5>
        <ol>
            <li>Agregar campo observación en la BD</li>
            <li>Crear modelo para arhivos, una solicitud puede tener n archivos</li>
            <li>Habilitar la subida de archivos al crear la solicitud</li>
            <li>En el mgr (manager) listar los archivos asociados a la solicitud</li>
            <li>Crear las aprobaciones (Atorres)</li>
        </ol>

        @livewire('parameters.parameter.single-manager',[
            'module'=>'his_modifications',
            'parameterName' => 'tipos_de_solicitudes',
            'type' => 'value'
        ])

        <label for="for-unidades">Ids de las unidades que vendrán después de la jefatura de la persona que hizo la solicitud</label>
        @livewire('parameters.parameter.single-manager',[
            'module'=>'his_modifications',
            'parameterName' => 'ids_unidades_vb',
            'type' => 'value'
        ])

    @endif

</div>
