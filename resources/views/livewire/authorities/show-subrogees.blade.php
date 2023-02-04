<div>
<h4><i class="fas fa-chess"></i> Subrogancias de Jefatura la Unidad Organizacional: </h4>
<h4>Subrogantes de {{$organizational_unit_name }}</h4>
<a class="btn btn-success" href="{{ route('rrhh.subrogations.create',$organizational_unit) }}">
  <i class="fas fa-plus"></i> Añadir subrogante de autoridad
</a>
<table class="table table-sm table-bordered small">
    <thead class="thead-light">
        <tr>
            <th width="120">Activar/Desactivar</th>
            <th>Estado</th>
            <th>Nombre</th>
            <th>Órden jerárquico</th>
            <th>Unidad Organizacional</th>
        </tr>
    </thead>
    <tbody>
        @foreach($subrogations as $subrogation)
            <tr class="table-{{ auth()->user()->subrogant == $subrogation->subrogant ? 'success' : 'warning'}}">
                <td>
                @if($absent)
                    <button type="button" class="btn btn-sm btn-warning" wire:click="toggleAbsent()">
                        <i class="fas fa-cocktail"></i> Desactivar
                    </button>
                @else
                    <button type="button" class="btn btn-sm btn-success" wire:click="toggleAbsent()">
                        <i class="fas fa-building"></i> Activar
                    </button>
                @endif
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
                <td>{{ optional($subrogation->organizationalUnit)->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>
