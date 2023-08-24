<div>
    <div class="row">
        <div class="col">
            <h3 class="mb-3">Justificaciones de "asistencia no registrada"</h3>
        </div>
        <div class="col-3 text-right">
            <a href="{{ route('rrhh.attendance.reason.mgr') }}" class="btn btn-info"> <i class="fas fa-cog"></i> Mantenedor
                de Motivos </a>
        </div>
    </div>

    <form wire:submit.prevent="searchFuncionary">
        <div class="row mb-3">
            <div class="col-lg-6">
                <input type="text" wire:model.defer="filter" class="form-control"
                    placeholder="Buscar por Nombre o Apellido">
            </div>
            <div class="col-lg-1">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Funcionario</th>
                <th width="95">Fecha registro</th>
                <th>Motivo (Fundamento)</th>
                <th>Jefatura</th>
                <th>Observación</th>
                <th width="95">Fecha revisión</th>
                <th>Registro en SIRH</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->user->shortName }}</td>
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
                </tr>
                @if ($rejectForm == $record->id)
                    <tr>
                        <td colspan="8">
                            <div class="input-group">
                                <input type="text" class="form-control" wire:model.defer="rrhh_observation"
                                    placeholder="Mensaje de rechazo para devolver el registro">
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
    {{ $records->links() }}
</div>
