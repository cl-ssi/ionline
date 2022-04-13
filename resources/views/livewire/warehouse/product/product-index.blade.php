<div>
    <h5>Productos</h5>
    <p><small>{{ $segment->name }} / {{ $family->name }} / {{ $class->name }}</small></p>

    <div class="input-group my-2">
        <div class="input-group-prepend">
          <span class="input-group-text">Buscar</span>
        </div>
        <input type="text" class="form-control" wire:model="search">
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Código</th>
                    <th>Nombre</th>
                    <th class="text-center">Estatus</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="text-center">{{ $product->code }}</td>
                    <td>{{ $product->name }}</td>
                    <td class="text-center">
                        <span class="badge badge-{{ $product->status_color }}">
                            {{ $product->status }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-sm btn-outline-secondary"
                            title="Editar producto"
                            href="{{ route('products.edit',  [
                                'segment' => $segment,
                                'family' => $family,
                                'class' => $class,
                                'product' => $product
                            ]) }}">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr class="text-center">
                    <td colspan="4"><em>No hay resultados</em></td>
                </tr>
                @endforelse
            </tbody>
            <caption>
                Total resultados : {{ $products->total() }}
            </caption>
        </table>

        {{ $products->links() }}
    </div>
</div>
