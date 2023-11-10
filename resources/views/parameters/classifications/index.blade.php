<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Editar</th>
            <th>Nombre</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($classifications as $classification)
            <tr>
                <td>
                    <button type="button" class="btn btn-sm btn-primary" 
                        wire:click="form({{$classification}})"><i class="fas fa-edit"></i></button>
                </td>
                <td>{{ $classification->name }}</td>
                
                <td>
                    <button type="button" class="btn btn-sm btn-danger" 
                        onclick="confirm('¿Está seguro que desea borrar la clasificación {{ $classification->name }}?') || event.stopImmediatePropagation()" 
                        wire:click="delete({{$classification}})"><i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>