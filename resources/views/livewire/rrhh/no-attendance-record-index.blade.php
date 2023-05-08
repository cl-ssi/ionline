<div>
    <h3 class="mb-3">Listado de constancias de "asistencia no registrada"</h3>
    
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Funcionario</th>
                <th>Fecha registro</th>
                <th>Fundamento</th>
                <th>Jefatura</th>
                <th></th>
                <th>Observación</th>
                <th>Fecha revisión</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record->user->shortName }}</td>
                    <td>{{ $record->date }}</td>
                    <td>{{ $record->observation }}</td>
                    <td>{{ $record->authority->shortName }}</td>
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

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $records->links() }}
</div>
