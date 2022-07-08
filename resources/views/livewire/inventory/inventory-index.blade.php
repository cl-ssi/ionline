<div>

    @section('title', 'Inventario')

    @include('inventory.nav')

    <div class="form-row my-3">
        <fieldset class="col-sm-3">
            <label for="locations" class="form-label">Ubicaciones</label>
            <input type="text" id="locations" class="form-control" placeholder="Ingresa una ubicacion">
        </fieldset>

        <fieldset class="col-sm-3">
            <label for="places" class="form-label">Lugares</label>
            <input type="text" id="places" class="form-control"  placeholder="Ingresa un lugar">
        </fieldset>

        <fieldset class="col-sm-3">
            <label for="article" class="form-label">Articulo</label>
            <input type="text" id="article" class="form-control"  placeholder="Ingresa un articulo">
        </fieldset>

        <fieldset class="col-sm-3">
            <label for="responsability" class="form-label">Responsable</label>
            <input type="text" id="responsability" class="form-control"  placeholder="Ingresa un responsable">
        </fieldset>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Nro. Inventario</th>
                    <th>Producto</th>
                    <th>Ubicacion</th>
                    <th>Lugar</th>
                    <th>Fecha Entrega</th>
                    <th>Responsable</th>
                    <th class="text-center">Valor</th>
                    <th>Subtitulo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventories as $inventory)
                <tr>
                    <td class="text-center">
                        <small class="text-monospace">
                            {{ $inventory->number }}
                        </small>
                    </td>
                    <td>
                        {{ $inventory->product->product->name }}
                        <br>
                        <small>
                            {{ $inventory->product->name }}
                        </small>
                    </td>
                    <td>
                        {{ optional($inventory->place)->location->name }}
                    </td>
                    <td>
                        {{ optional($inventory->place)->name }}
                    </td>
                    <td class="text-center">
                        {{ $inventory->date }}
                    </td>
                    <td>
                        {{ optional($inventory->responsible)->full_name }}
                    </td>
                    <td class="text-center">
                        ${{ $inventory->price }}
                    </td>
                    <td></td>
                    <td class="text-center">
                        <a
                            class="btn btn-sm btn-primary"
                            href="{{ route('inventories.edit', $inventory) }}"
                        >
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr class="text-center">
                    <td colspan="9">
                        <em>No hay registros</em>
                    </td>
                </tr>
                @endforelse
            </tbody>
            <caption>
                Total de resultados: {{ $inventories->total() }}
            </caption>
        </table>

        {{ $inventories->links() }}
    </div>
</div>
