<form wire:submit.prevent="searchPlace">
    <div class="row mb-3">
        <div class="col-lg-11">
            <input type="text"
                wire:model.defer="filter"
                class="form-control"
                placeholder="Buscar por nombre/descripción/ubicación/codigointerno/establecimiento"
                autocomplete="off">
        </div>
        <div class="col-lg-1">
            <button type="submit"
                class="btn btn-primary">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Ubicación</th>
                <th>Código interno Arquitectura</th>
                <th>Establecimiento</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($places as $place)
                <tr>
                    <td class="text-center">{{ $place->id }}</td>
                    <td>{{ $place->name }}</td>
                    <td>{{ $place->description }}</td>
                    <td>{{ $place->location->name }}</td>
                    <td>{{ $place->architectural_design_code }}</td>
                    <td>{{ $place->establishment->name }}</td>
                    <td class="text-center">
                        @can('Inventory: manager')
                            <button type="button"
                                class="btn btn-sm btn-outline-primary"
                                wire:click="edit({{ $place }})">
                                <i class="fas fa-edit"></i>
                            </button>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="6">
                        <em>No hay lugares</em>
                    </td>
                </tr>
            @endforelse
        </tbody>
        <caption>
            Total de resultados: {{ $places->total() }}
        </caption>
    </table>
</div>
{{ $places->links() }}
