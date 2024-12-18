<table class="table table-sm table-bordered small">
    <thead class="table-secondary">
        <tr>
            <th width="120"></th>
            <th>Estado</th>
            <th>Nombre</th>
            <th>Órden jerárquico</th>
            @if($organizationalUnit)
            <th>Unidad Organizacional</th>
            @endif
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if(!$organizationalUnit)
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
                <td><!--Este nivel no se puede borrar, es la misma persona --></td>
            </tr>
        @endif
        @foreach($subrogations as $subrogation)
            <tr class="table-{{ $type == 'manager' ? 'primary' : 'secondary'}}">
                <td>
                    @if(auth()->user()->can('Authorities: edit') OR $subrogation->user->is(auth()->user()))
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
                    @endif
                    {{-- <button type="button" class="btn btn-sm btn-primary"
                        wire:click="edit({{$subrogation}})"><i class="fas fa-edit"></i></button> --}}
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
                @if($organizationalUnit)
                <td>{{ optional($subrogation->organizationalUnit)->name }}</td>
                @endif
                <td>
                    @if(auth()->user()->can('Authorities: edit') OR $subrogation->user->is(auth()->user()))
                    <button
                        type="button"
                        class="btn btn-sm btn-danger"
                        wire:click="delete({{ $subrogation }})"
                    >
                        <i class="fas fa-trash"></i>
                    </button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<br>


@if(!$hide_own_subrogation)
<h4><i class="fas fa-chess"></i> ¿De quienes soy subrogante?</h4>

<div class="table-responsive">
    <table class="table table-sm table-bordered small table-stripped">
        <thead class="thead-light">
            <tr>
                <th width="120"></th>
                <th>Mi Nombre</th>
                <th>A Quien Subrogo</th>
                <th>En que orden jerárquico</th>
            </tr>
        </thead>
        <tbody>
            @foreach(auth()->user()->getIAmSubrogantNoAuthorityAttribute() as $key => $subrogation)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ auth()->user()->tinyName }}</td>
                    <td>{{ $subrogation->user->tinyName }}</td>
                    <td>{{ $subrogation->level }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
