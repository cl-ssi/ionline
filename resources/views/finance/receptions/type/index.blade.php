<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Editar</th>
            <th>Nombre</th>
            <th>Titulo <small>(Titulo que aparecerá en el PDF)</small></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($types as $type)
            <tr>
                <td>
                    <button type="button" class="btn btn-sm btn-primary" 
                        wire:click="form({{$type}})"><i class="fas fa-edit"></i></button>
                </td>
                <td>{{ $type->name }}</td>
                <td>{{ $type->title }}</td>
                
                <td>
                    <button type="button" class="btn btn-sm btn-danger" 
                        onclick="confirm('¿Está seguro que desea borrar la clasificación {{ $type->name }}?') || event.stopImmediatePropagation()" 
                        wire:click="delete({{$type}})"><i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>