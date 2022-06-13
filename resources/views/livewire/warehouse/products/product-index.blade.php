<div>
    <div class="row my-2">
        <div class="col">
            <h5>Productos: {{ $store->name }}</h5>
        </div>
        <div class="col text-right">
            <a href="{{ route('warehouse.products.create', $store) }}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> Crear producto
            </a>
        </div>
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Buscar</span>
        </div>
        <input type="text" class="form-control" wire:model.debounce.600ms="search">
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Código</th>
                    <th>Producto o Servicio</th>
                    <th>Categoría</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr class="d-none" wire:loading.class.remove="d-none" wire:target="search">
                    <td class="text-center" colspan="5">
                        @include('layouts.partials.spinner')
                    </td>
                </tr>
                @forelse($products as $product)
                <tr wire:loading.remove wire:target="search">
                    <td class="text-center">
                        <a
                            href="{{ route('warehouse.products.edit', ['store' => $store, 'product' => $product]) }}"
                            class="btn btn-sm btn-outline-secondary"
                        >
                            <i class="fas fa-edit"></i>
                            {{ $product->id }}
                        </a>
                    </td>
                    <td class="text-center">
                        <small class="text-monospace">
                            {{ optional($product->product)->code }}
                        </small>
                    </td>
                    <td>
                        {{ optional($product->product)->name }}
                        <br>
                        <small>
                            @if($product->barcode)
                                <span class="text-monospace">{{ $product->barcode }}</span>
                                -
                            @endif
                            {{ $product->name }}
                        </small>
                    </td>
                    <td>
                        {{ $product->category_name }}
                    </td>
                    <td class="text-center">
                        <button
                            class="btn btn-sm btn-outline-danger"
                            wire:click="deleteProduct({{ $product }})"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr wire:loading.remove>
                    <td class="text-center" colspan="5">
                        <em>No hay resultados</em>
                    </td>
                </tr>
                @endforelse
            </tbody>
            <caption>
                Total resultados: {{ $products->total() }}
            </caption>
        </table>
        {{ $products->links() }}
    </div>
</div>
