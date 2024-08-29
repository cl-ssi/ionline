<div>
    @section('title', 'Solicitudes Rayen')

    @include('his.partials.nav')

    @if ($form)
        <h3>Editar Solicitud</h3>
        <div class="row">

            <div class="form-group col">
                <label for="for_creator_id">Solicitante</label>
                <input type="text" class="form-control" id="for_creator_id" value="{{ $modrequest->creator->shortName }}"
                    disabled>
            </div>

            <div class="form-group col">
                <label for="for_creator_email">Email solicitante</label>
                <input type="email" class="form-control" id="for_creator_email"
                    value="{{ $modrequest->creator->email }}" disabled>
            </div>
        </div>

        <div class="form-group">
            <label for="for_type">Tipo de solicitud</label>
            <select class="form-select" id="for_type" wire:model="modificationRequestType">
                <option></option>
                @foreach ($param_types as $type)
                    <option>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="for_subject">Asunto de la solicitud</label>
            <input type="text" class="form-control" id="for_subject" wire:model="modificationRequestSubject">
            @error('modificationRequestSubject')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="for_body">Detalle de la solicitud</label>
            <textarea class="form-control" id="for_body" rows="5" wire:model="modificationRequestBody"></textarea>
            @error('modificationRequestBody')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <ul>
            @foreach ($modrequest->files as $file)
                <li>
                    <a href="{{ route('his.modification-request.files.download', $file) }}"
                        target="_blank">{{ $file->name }}</a>
                </li>
            @endforeach
        </ul>
        <hr>

        <h3 class="mb-2">La poderosa herramienta</h3>

        <div class="row">

            @if ($modrequest->approvals->isEmpty())
                <div class="col-9">
                    @foreach ($ous as $ou)
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="for_switch_{{ $ou->id }}"
                                wire:model="vb.{{ $ou->id }}">
                            <label class="custom-control-label" for="for_switch_{{ $ou->id }}">
                                {{ $ou->name }}
                                ({{ $ou->currentManager?->user->shortName }})
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="col-3">
                    <button type="button" class="btn btn-primary" wire:click="setApprovals({{ $modrequest->id }})">
                        <i class="fas fa-paper-plane"></i> Enviar para VB
                    </button>
                </div>
            @else
                <div class="col-12">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Unidad Organizacional</th>
                                <th>Autoridad</th>
                                <th>Fecha</th>
                                <th>Observación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modrequest->approvals as $approval)
                                <tr class="table-{{ $approval->color }}">
                                    <td>{{ $approval->sentToOu->name }}</td>
                                    <td>{{ $approval->sentToOu->currentManager?->user->shortName }}</td>
                                    <td>{{ $approval->approver_at }}</td>
                                    <td>{{ $approval->approver_observation }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>

        <div class="form-group mt-3">
            <label for="for_observation">Observacion interna</label>
            <textarea class="form-control" id="for_observation" rows="5" wire:model="modificationRequestObservation"></textarea>
            @error('modificationRequestObservation')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="row mt-3">
            <div class="form-group col-3">
                <label for="for_status">Estado de la solicitud</label>
                <select class="form-select" id="for_status" wire:model="modificationRequestStatus">
                    <option value="">Pendiente VBs</option>
                    <option value="1">Realizado</option>
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
    @else
        <h3 class="mb-3">Listado de modificaciones</h3>

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>VBs</th>
                    <th>Solicitante</th>
                    <th>Tipo</th>
                    <th>Asunto</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($modifications as $modification)
                    <tr class="table-{{ $modification->color }}">
                        <td>{{ $modification->id }}</td>
                        <td>
                            @foreach ($modification->approvals as $approval)
                                <i class="fa fa-fw fa-lg {{ $approval->icon }} text-{{ $approval->color }}"
                                    title="{{ $approval->sentToOu->name }}"></i>
                            @endforeach
                        </td>
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

                            @foreach ($modification->approvals as $approval)
                                @if ($approval->approver_observation)
                                    <br><span class="smal text-danger">{{ $approval->approver_observation }} </span>
                                @endif
                            @endforeach
                        </td>
                        <td nowrap>
                            <a class="btn btn-sm btn-outline-danger" target="_blank"
                                href="{{ route('his.modification-request.show', $modification->id) }}">
                                <i class="fas fa-fw fa-file-pdf"></i>
                            </a>
                            <button class="btn btn-sm btn-primary" wire:click="edit({{ $modification->id }})">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $modifications->links() }}

    @endif

</div>
