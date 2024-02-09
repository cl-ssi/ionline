<div>
    <div class="row">
        <div class="col">
            <h3 class="mb-3">Justificaciones de "asistencia no registrada"</h3>
        </div>
        <div class="col-3 text-end">
            <a href="{{ route('rrhh.attendance.reason.mgr') }}" class="btn btn-info"> <i class="fas fa-cog"></i> Mantenedor
                de Motivos </a>
        </div>
    </div>

    <form wire:submit.prevent="searchFuncionary">
        <div class="row mb-3 g-2">
            <div class="form-group col-md-4">
                <div class="form-group">
                    <label for="number">Nombre o Apellido</label>
                    <input type="text"
                        class="form-control"
                        wire:model.defer="name"
                        placeholder="Buscar por Nombre o Apellido">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="reception-date">Fecha Desde Registro</label>
                    <input type="date"
                        class="form-control"
                        wire:model.defer="from">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="reception-date">Fecha Hasta Registro</label>
                    <input type="date"
                        class="form-control"
                        wire:model.defer="to">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label for="rrhh_at">SIRH</label>
                    <select
                        class="form-select"
                        wire:model.defer="rrhh_at">
                        <option value="">Todos</option>
                        <option value="Si">Si</option>
                        <option value="No">No</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label for="search">&nbsp;</label>
                    <input type="submit"
                        class="form-control btn btn-primary"
                        value ="Buscar"
                        >
                </div>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" wire:model="simplified" id="simplified">
                <label class="form-check-label" for="simplified">Formato simplificado de carga</label>
            </div>
        </div>
    </form>



    @if($simplified)
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Entrada / Salida</th>
                    <th>RUN</th>
                    <th>Fecha registro</th>
                    <th>Hora registro</th>
                    <th>Motivo</th>
                    <th>Registro en SIRH</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <td>{{ $record->id }}</td>
                        <td class="text-center">{{ $record->type }}</td>
                        <td nowrap>{{ $record->user->runNotFormat() }}</td>
                        <td>{{ $record->date->format('ymd') }}</td>
                        <td>{{ $record->date->format('Hi') }}</td>
                        <td>
                            @if (is_null($record->status))
                                <i class="fas fa-clock"></i>
                            @elseif($record->status === 1)
                                <i class="fas fa-thumbs-up text-success"></i>
                            @else
                                <i class="fas fa-thumbs-down text-danger"></i>
                            @endif

                            {{ $record->reason->name }}
                            <span class="text-muted">
                                {{ $record->observation }}
                            </span>
                        </td>
                        <td>
                            @if ($record->rrhh_at)
                                {{ $record->rrhh_at }}
                            @elseif($record->status === 1)
                                <button type="button" class="btn btn-sm btn-success"
                                    wire:click="setOk({{ $record }})">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger"
                                    wire:click="reject({{ $record }})">
                                    <i class="fas fa-ban"></i>
                                </button>
                            @endif
                        </td>
                        
                    </tr>
                    @if ($rejectForm == $record->id)
                        <tr>
                            <td colspan="8">
                                <div class="input-group">
                                    <input type="text" class="form-control" wire:model.defer="rrhh_observation"
                                        placeholder="Mensaje de rechazo del registro">
                                    <div class="input-group-append" id="button-rejected">
                                        <button class="btn btn-outline-primary" title="Guardar" type="button"
                                            wire:click="saveRejectForm({{ $record }})">
                                            <i class="fas fa-save"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary" title="Cerrar" type="button"
                                            wire:click="closeRejectForm">
                                            <i class="fas fa-window-close"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Funcionario</th>
                    <th>Tipo</th>
                    <th width="95">Fecha registro</th>
                    <th>Motivo (Fundamento)</th>
                    <th>Jefatura</th>
                    <th>Observación</th>
                    <th width="95">Fecha revisión</th>
                    <th>Registro en SIRH</th>
                    <th>Fecha de solicitud de justificación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <td>{{ $record->id }}</td>
                        <td>{{ $record->user->shortName }}</td>
                        <td>{{ $record->type }}</td>
                        <td>{{ $record->date }}</td>
                        <td>
                            {{ $record->reason->name }}
                            <span class="text-muted">
                                {{ $record->observation }}
                            </span>
                            @if ($record->rrhh_observation)
                                <br>
                                <span class="text-danger">
                                    <strong>RRHH: </strong>
                                    {{ $record->rrhh_observation }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if (is_null($record->status))
                                <i class="fas fa-clock"></i>
                            @elseif($record->status === 1)
                                <i class="fas fa-thumbs-up text-success"></i>
                            @else
                                <i class="fas fa-thumbs-down text-danger"></i>
                            @endif
                            {{ $record->authority->shortName }}
                        </td>
                        <td>{{ $record->authority_observation }}</td>
                        <td>{{ $record->authority_at }}</td>

                        <td>
                            @if ($record->rrhh_at)
                                {{ $record->rrhh_at }}
                            @elseif($record->status === 1)
                                <button type="button" class="btn btn-sm btn-success"
                                    wire:click="setOk({{ $record }})">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger"
                                    wire:click="reject({{ $record }})">
                                    <i class="fas fa-ban"></i>
                                </button>
                            @endif
                        </td>
                        <td>
                            {{ $record->created_at }}
                        </td>
                        
                    </tr>
                    @if ($rejectForm == $record->id)
                        <tr>
                            <td colspan="8">
                                <div class="input-group">
                                    <input type="text" class="form-control" wire:model.defer="rrhh_observation"
                                        placeholder="Mensaje de rechazo del registro">
                                    <div class="input-group-append" id="button-rejected">
                                        <button class="btn btn-outline-primary" title="Guardar" type="button"
                                            wire:click="saveRejectForm({{ $record }})">
                                            <i class="fas fa-save"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary" title="Cerrar" type="button"
                                            wire:click="closeRejectForm">
                                            <i class="fas fa-window-close"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

    {{ $records->links() }}
</div>
