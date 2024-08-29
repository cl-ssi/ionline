<div>
    <div class="input-group @if($smallInput) input-group-sm @endif">
        <div class="input-group-prepend">
            <span class="input-group-text" wire:loading.remove>
                @if($results->count() == 0)
                    <i class="fas fa-times text-danger"></i>
                @else
                    <i class="fas fa-check text-success"></i>
                @endif
            </span>
            <span class="input-group-text" wire:loading>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span class="sr-only">...</span>
            </span>
        </div>
        <select
            id="product-id"
            wire:model.live.debounce.1500ms="product_id"
            class="form-control @if($smallInput) form-control-sm @endif"
            wire:loading.attr="disabled"
            wire:target="updatedSearch"
            required
        >
            <option value="">Selecciona un producto</option>
            @forelse($results as $item)
                <option value="" disabled>
                    --{{ $item['title'] }}
                </option>
                @foreach($item['products'] as $product)
                    <option value="{{ $product['id'] }}">
                        @if($showCode)
                            {{ $product['code']}} -
                        @endif
                         {{ $product['name'] }}
                    </option>
                @endforeach
            @empty
                <option value="">Sin resultados</option>
            @endforelse
        </select>
    </div>
    <small id="product-id" class="form-text text-muted">{{ $results->count() }} resultados</small>
</div>
