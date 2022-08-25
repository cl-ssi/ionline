<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th width="120"></th>
            <th>Estado</th>
            <th>Nombre</th>
            <th width="100">Órden jerárquico</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr class="table-{{ auth()->user()->subrogant == auth()->user() ? 'success' : 'warning'}}">
            <td>
                @if($absent)
                    <button type="button" class="btn btn-sm btn-success"
                    wire:click="toggleAbsent()"><i class="fas fa-building"></i> Activar</button>
                @else
                    <button type="button" class="btn btn-sm btn-warning"
                    wire:click="toggleAbsent()"><i class="fas fa-cocktail"></i> Desactivar</button>
                @endif
            </td>
            <td>
                @if($absent)
                    <i class="fas fa-cocktail"></i> Fuera de la oficina
                @else
                    <i class="fas fa-building"></i> En la oficina
                @endif
            </td>
            <td>{{ auth()->user()->fullName }}</td>
            <td> 0 </td>
            <td></td>
        </tr>
        @foreach($subrogations as $subrogation)
            <tr class="table-{{ auth()->user()->subrogant == $subrogation->subrogant ? 'success' : 'warning'}}">
                <td>
                    <button
                        type="button"
                        class="btn btn-sm btn-primary"
                        wire:click="up({{ $subrogation }})"
                        @if($subrogation->level == 1)
                            disabled
                        @endif
                    >
                        <i class="fas fa-caret-up"></i>
                    </button>

                    <button
                        type="button"
                        class="btn btn-sm btn-primary"
                        wire:click="down({{ $subrogation }})"
                        @if($subrogation->level == $subrogations->count())
                            disabled
                        @endif
                    >
                        <i class="fas fa-caret-down"></i>
                    </button>
                    <!-- <button type="button" class="btn btn-sm btn-primary"
                        wire:click="edit({{$subrogation}})"><i class="fas fa-edit"></i></button> -->
                </td>
                <td>
                    @if($subrogation->subrogant->absent)
                        <i class="fas fa-cocktail"></i> Fuera de la oficina
                    @else
                        <i class="fas fa-building"></i> En la oficina
                    @endif
                </td>
                <td>{{ $subrogation->subrogant->fullName }}</td>
                <td>{{ $subrogation->level }}</td>
                <td>
                    <button
                        type="button"
                        class="btn btn-sm btn-danger"
                        wire:click="delete({{ $subrogation }})"
                    >
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
