<div>
    <h3 class="mb-3">Justificaciones de "asistencia no registrada"</h3>
    
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Funcionario</th>
                <th>Fecha registro</th>
                <th>Fundamento</th>
                <th>Jefatura</th>
                <th>Observación</th>
                <th>Fecha revisión</th>
                <th></th>
                <th>Registro RRHH</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->user->shortName }}</td>
                    <td>{{ $record->date }}</td>
                    <td>{{ $record->observation }}</td>
                    <td>{{ $record->authority->shortName }}</td>
                    <td>{{ $record->authority_observation }}</td>
                    <td>{{ $record->authority_at }}</td>
                    <td>
                        @if(is_null($record->status))
                        <i class="fas fa-clock"></i>
                        @elseif($record->status === 1)
                        <i class="fas fa-thumbs-up text-success"></i>
                        @else
                        <i class="fas fa-thumbs-down text-danger"></i>
                        @endif
                    </td>
                    <td>
                        @if($record->rrhh_at)
                            {{ $record->rrhh_at }}
                        @elseif($record->status === 1)
                            <button type="button" class="btn btn-sm btn-primary" wire:click="setOk({{$record}})">
                                <i class="fas fa-check"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $records->links() }}
</div>
