<div>

    <h3>Todos los Productos de UNSPSC</h3>

    <div class="input-group my-2">
        <div class="input-group-prepend">
          <span class="input-group-text">Buscar</span>
        </div>
        <input type="text" class="form-control" wire:model.live.debounce.500ms="search">
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Código</th>
                    <th class="text-left" colspan="3">Nombre</th>
                </tr>
            </thead>
            <tbody>
                <tr class="d-none" wire:loading.class.remove="d-none" wire:target="search">
                    <td class="text-center" colspan="4">
                        @include('layouts.bt4.partials.spinner')
                    </td>
                </tr>
                @forelse($products as $index => $item)
                    <tr wire:loading.remove>
                        <td class="table-secondary" colspan="2">
                            <strong>
                                {{ $index + 1 }}. {{ $item['title'] }}
                                <small>({{ count($item['products']) }} productos)</small>
                            </strong>
                        </td>
                    </tr>
                    @foreach($item['products'] as $product)
                    <tr wire:loading.remove>
                        <td class="text-center">
                            {{ $product['code']}}
                        </td>
                        <td>
                            {{ $product['name'] }}
                            <br>
                        </td>
                    </tr>
                    @endforeach
                @empty
                <tr class="text-center" wire:loading.remove>
                    <td colspan="2"><em>No hay resultados</em></td>
                </tr>
                @endforelse
            </tbody>
            <caption>
                Total de rubros: {{ $products->count() }}
            </caption>
        </table>
    </div>
</div>
