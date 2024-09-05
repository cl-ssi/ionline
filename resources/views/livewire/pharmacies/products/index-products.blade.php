<div>
    @include('pharmacies.nav')

    <div class="row mb-3">
        <div class="col">
            <h3 class="inline">Mantenedor de productos</h3>
        </div>
        <div class="col">
            <div class="input-group mb-3">
                <input type="text" class="form-control" wire:model="filterName">
                <button class="btn btn-outline-secondary" type="button" id="search" wire:click="$refresh">Buscar</button>
            </div>
        </div>

        <div class="col-1 text-end">
            <button class="btn btn-outline-success" type="button" id="search" wire:click="export">Exportar</button>
        </div>

        <div class="col-1 text-end">
            @can('Pharmacy: create products')
            <a href="{{ route('pharmacies.products.create') }}" class="btn btn-primary">Crear</a>
            @endcan
        </div>
    </div>
    

    <table class="table table-striped table-sm table-bordered" id="tabla_movimientos">
        <thead>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Nombre</th>
                <th scope="col">Unidad</th>
                <th scope="col">Stock</th>
                <th scope="col">Stock Crítico</th>
                <th scope="col">Stock Min.</th>
                <th scope="col">Stock Max.</th>
                <th scope="col">Categoría</th>
                <th scope="col">Programa</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $product)

            <tr class="small">
                <td scope="row" nowrap>{{ $product->barcode }} </td>
                <td>{{ $product->name }}</td>
                <td class="text-center">{{ $product->unit }}</td>
                <td class="text-right">@numero( $product->stock )</td>
                <td class="text-right">@numero( $product->critic_stock )</td>
                <td class="text-right">{{$product->min_stock}}</td>
                <td class="text-right">{{$product->max_stock}}</td>
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->program->name }}</td>
                <td>
                    <a href="{{ route('pharmacies.products.edit', $product) }}"
                        class="btn btn-sm btn-outline-secondary">
                        <span class="fas fa-edit" aria-hidden="true"></span>
                    </a>
                </td>
                <td>
                    <form method="POST" action="{{ route('pharmacies.products.destroy', $product) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-secondary btn-sm" onclick="return confirm('¿Está seguro de eliminar la información?');">
                            <span class="fas fa-trash-alt" aria-hidden="true"></span>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

    {{ $products->links() }}

</div>
