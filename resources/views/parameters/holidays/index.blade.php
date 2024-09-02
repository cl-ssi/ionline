<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Editar</th>
            <th>Fecha</th>
            <th>Nombre</th>
            <th>Región</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($holidays as $holiday)
            <tr>
                <td>
                    <button class="btn btn-sm btn-primary" 
                        wire:click="edit({{$holiday}})"><i class="fas fa-edit"></i></button>
                </td>
                <td>{{ $holiday->date->format('Y-m-d') }}</td>
                <td>{{ $holiday->name }}</td>
                <td>{{ optional($holiday->region)->name ?? 'Todas' }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" 
                        onclick="confirm('¿Está seguro que desea borrar el feriado {{ $holiday->name }}?') || event.stopImmediatePropagation()" 
                        wire:click="delete({{$holiday}})"><i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>