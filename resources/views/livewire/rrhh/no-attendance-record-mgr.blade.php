<div>
    @section('title', 'Registro de justificación de asistencias')

    @if ($formActive)
        <h3 class="mb-3">Ingresar justificación de ausencia de registro de asistencia</h3>
        <h4>La autoridad que tiene usted asignada es: <strong>{{ optional($authority)->shortName }}</strong></h4>
        <small class="mb-3">Nota: Si su autoridad asignada no corresponde, por favor solicitar la corrección con su secretaria antes de hacer el registro</small>


        <form class="row mt-3 g-2">
            <div class="form-group col-md-1">
                <label for="type">Tipo</label>
                <select class="form-select" wire:model="noAttendanceRecord.type">
                    <option value=""></option>
                    <option value="1">Entrada</option>
                    <option value="0">Salida</option>
                </select>
                @error('noAttendanceRecord.type') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-md-3">
                <label for="date">Fecha y hora a justificar</label>
                <input type="datetime-local" class="form-control" wire:model="noAttendanceRecord.date" max ="{{ date('Y-m-d\T23:59') }}">
                @error('noAttendanceRecord.date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-md-3">
                <label for="reason">Motivo</label>
                <select class="form-select" wire:model="noAttendanceRecord.reason_id">
                    <option></option>
                    @foreach($reasons as $reason)
                        <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                    @endforeach
                </select>
                @error('noAttendanceRecord.reason_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-md-5">
                <label for="observation">Fundamente (otro)</label>
                <input type="text" class="form-control" wire:model="noAttendanceRecord.observation">
                @error('noAttendanceRecord.observation') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </form>
        <div class="row">
            <div class="mt-3 col-12">
                @if(!is_null($noAttendanceRecord->rrhh_status) AND $noAttendanceRecord->rrhh_status == false)
                    <button type="button" class="btn btn-primary" wire:click="saveAfterEdit()">Corregir</button>
                @else
                    <button type="button" class="btn btn-success" wire:click="saveFirstTime()">Guardar</button>
                @endif
                <button type="button" class="btn btn-outline-secondary" wire:click="index()">Cancelar</button>
            </div>
        </div>
        <br>


    @else
        <div class="row">
            <div class="col">
                <h3 class="mb-3">Justificaciones de no registro de asistencia</h3>
            </div>
            <div class="col-3 text-end">
                @if($checkAuthority)
                <button class="btn btn-success float-right" wire:click="showForm()">
                    <i class="fas fa-plus"></i> Nueva justificación
                </button>
                @else
                <h5 class="text-danger">No tiene jefatura asociada</h5>
                @endif
            </div>

        </div>

            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha inasistencia</th>
                        <th>Motivo (fundamento)</th>
                        <th>Fecha registro</th>
                        <th>Autoridad</th>
                        <th>E</th>
                        <th>Observación</th>
                        <th>Fecha revisión</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($myRecords as $record)
                        <tr>
                            <td>
                                @if(is_null($record->status))
                                <!-- <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirm('¿Está seguro que desea borrar el feriado {{ $record->date }}?') || event.stopImmediatePropagation()"
                                    wire:click="delete({{$record}})"><i class="fas fa-trash"></i>
                                </button> -->
                                @endif
                                {{ $record->id }}
                            </td>
                            <td>{{ $record->date }}</td>
                            <td>
                                {{ $record->reason->name }}
                                <span class="text-muted">
                                    {{ $record->observation }}
                                </span>
                                @if(!is_null($record->rrhh_status) AND $record->rrhh_status == false)
                                    <br>
                                    <span class="text-danger">
                                        <strong>RRHH: </strong>
                                        {{ $record->rrhh_observation }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small>
                                    {{ $record->created_at->format('Y-m-d') }}</td>
                                </small>
                            <td>{{ optional($record->authority)->shortName }}</td>
                            <td>
                                @if(is_null($record->status))
                                <i class="fas fa-clock"></i>
                                @elseif($record->status === 1)
                                <i class="fas fa-thumbs-up text-success"></i>
                                @else
                                <i class="fas fa-thumbs-down text-danger"></i>
                                @endif
                            </td>
                            <td>{{ $record->authority_observation }}</td>
                            <td>{{ $record->authority_at }}</td>
                            <td>
                                @if(is_null($record->status))
                                <button type="button" class="btn btn-sm btn-primary"
                                    wire:click="showForm({{$record}})"><i class="fas fa-fw fa-edit"></i></button>
                                @elseif($record->status == TRUE)
                                    <a class="btn btn-sm btn-outline-success" target="_blank" href="{{ route('rrhh.attendance.no-records.show',$record) }}">
                                        <i class="fas fa-fw fa-file"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        {{ $myRecords->links() }}

        <br>
        <h4 class="mt-3">Mis aprobaciones como jefatura</h4>
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Funcionario</th>
                    <th>Fecha registro</th>
                    <th>Motivo (fundamento)</th>
                    <th>Estado</th>
                    <th>Observación Jefe</th>
                    <th>Fecha revisión</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($authorityRecrods as $authorityRecord)
                    <tr>
                        <td>{{ $authorityRecord->id }}</td>
                        <td>{{ $authorityRecord->user->shortName }}</td>
                        <td>{{ $authorityRecord->date }}</td>
                        <td>
                            {{ $authorityRecord->reason->name }}
                            <span class="text-muted">
                                {{ $authorityRecord->observation }}
                            </span>
                            @if($authorityRecord->rrhh_observation)
                                <br>
                                <span class="text-danger">
                                    <strong>RRHH Observación para corregir: </strong>
                                    {{ $authorityRecord->rrhh_observation }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if(is_null($authorityRecord->status))
                            <i class="fas fa-clock"></i>
                            @elseif($authorityRecord->status === 1)
                            <i class="fas fa-thumbs-up text-success"></i>
                            @else
                            <i class="fas fa-thumbs-down text-danger"></i>
                            @endif
                        </td>
                        <td>{{ $authorityRecord->authority_observation }}</td>
                        <td>{{ $authorityRecord->authority_at }}</td>
                        <td>
                            @if(is_null($authorityRecord->status))
                            <a class="btn btn-sm btn-outline-primary"
                                href="{{ route('rrhh.attendance.no-records.confirmation',$authorityRecord) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $authorityRecrods->links() }}
    @endif
</div>
