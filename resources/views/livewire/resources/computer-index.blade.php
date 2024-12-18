<div>
    <div class="form-row g-2 my-4">
        <fieldset class="form-group col-md-3">
            <label for="type-resource">Tipo Recurso</label>
            <select
                class="custom-select"
                wire:model.live.debouce.1500ms="type_resource"
                id="type-resource"
            >
                <option value="">Todos</option>
                <option value="merged">Fusionados</option>
                <option value="not-merged">No Fusionados</option>
            </select>
        </fieldset>
        <fieldset class="form-group col-md-9">
            <label for="search">Buscador</label>
            <input
                type="text"
                class="form-control"
                id="search"
                wire:model.live.debounce.1500ms="search"
                placeholder="Ingrese una marca, modelo, IP, número de inventario o serial"
            >
        </fieldset>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm" id="TableFilter">
            <thead>
                <tr>
                    <th scope="col">Inventario</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Serial</th>
                    <th scope="col">IP</th>
                    <th scope="col">Asignado a</th>
                    <th scope="col">Lugar</th>
                    <th scope="col">Accion</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="d-none"
                    wire:loading.class.remove="d-none"
                >
                    <td class="text-center" colspan="8">
                        @include('layouts.bt4.partials.spinner')
                    </td>
                </tr>
                @forelse($computers as $key => $computer)
                <tr wire:loading.remove>
                    <td>{{ $computer->inventory_number }}</td>
                    <td>{{ $computer->brand }}</td>
                    <td>{{ $computer->model }}</td>
                    <td>{{ $computer->serial }}</td>
                    <td>{{ $computer->ip }}</td>
                    <td>
                        @foreach($computer->users as $user)
                            {{ $user->tinyName }}<br>
                        @endforeach
                    </td>
                    <td>
                        {{ $computer->place ? $computer->place->name : 'Asignar Lugar' }}
                    </td>
                    <td>
                        <a
                            @if($computer->isMerged())
                                class="btn btn-outline-primary btn-sm"
                                href="{{ route('resources.computer.fusion', [
                                    'computer' => $computer,
                                    'inventory' => $computer->inventory
                                ]) }}"
                            @else
                                class="btn btn-outline-secondary btn-sm"
                                href="{{ route('resources.computer.edit', $computer) }}"
                            @endif
                        >
                            <span class="fas fa-edit" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="text-center" colspan="8">
                        <em>
                            No hay registros
                        </em>
                    </td>
                </tr>
                @endforelse
            </tbody>
            <caption>
                Total de resultados: {{ $computers->total() }}
            </caption>
        </table>
    </div>

    {{ $computers->links() }}
</div>
