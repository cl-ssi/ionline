<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th></th>
            <th>Órden jerárquico</th>
            <th>Nombre</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($subrogations as $subrogation)
            <tr>
                <td>
                    <button type="button" class="btn btn-sm btn-primary" 
                        wire:click="edit({{$subrogation}})"><i class="fas fa-edit"></i></button>
                </td>
                <td>{{ $subrogation->level }}</td>
                <td>{{ $subrogation->subrogant->fullName }}</td>
                <td>
                <button type="button" class="btn btn-sm btn-danger" 
                    wire:click="delete({{$subrogation}})"><i class="fas fa-trash"></i></button>
            </td>
            </tr>
        @endforeach
    </tbody>
</table>
