<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Solicitante</th>
            <th>Asunto</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($meetings as $meeting)
            <tr>
                <td>{{ $meeting->date }}</td>
                <td>{{ $meeting->petitioner }}</td>
                <td>{{ $meeting->subject }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary" 
                        wire:click="form({{$meeting}})"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-sm btn-danger" 
                        onclick="confirm('¿Está seguro que desea borrar la reunión {{ $meeting->subject }}?') || event.stopImmediatePropagation()" 
                        wire:click="delete({{$meeting}})"><i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>