<div>
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Código</th>
                    <th class="text-center">Cant.</th>
                    <th>Producto o Servicio</th>
                    <th>Programa</th>
                    <th>Categoría</th>
                    <th class="text-center">Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="d-none" wire:loading.class.remove="d-none">
                    <td class="text-center" colspan="7">
                        @include('layouts.bt4.partials.spinner')
                    </td>
                </tr>
                @forelse($controlItems as $controlItem)
                <tr wire:loading.remove>
                    <td class="text-center">
                        <small class="text-monospace">
                            {{ optional($controlItem->product->product)->code }}
                        </small>
                    </td>
                    <td class="text-center">{{ $controlItem->quantity }}</td>
                    <td>
                        {{ optional($controlItem->product->product)->name }}
                        <br>
                        <small>
                            @if($controlItem->product->barcode)
                                <span class="text-monospace">
                                    {{ optional($controlItem->product)->barcode }}
                                </span>
                                -
                            @endif
                            {{ optional($controlItem->product)->name }}
                        </small>
                    </td>
                    <td>{{ optional($controlItem->control)->program_name }}</td>
                    <td>{{ optional($controlItem->product)->category_name }}</td>
                    <td class="text-center">
                        <span class="badge badge-{{ $controlItem->color }}">
                            {{ $controlItem->status }}
                        </span>
                    </td>
                    <td class="text-center">
                        <button
                            class="btn btn-sm btn-danger"
                            wire:click="deleteItem({{ $controlItem }})"
                            @if($control->isClose())
                                disabled
                            @endif
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr wire:loading.remove>
                    <td class="text-center" colspan="6">
                        <em>No hay productos</em>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-md-12 text-right">
            @if($control->isSendToStore() && !$control->isConfirmed())
                <button
                    class="btn btn-success"
                    wire:click="sendToStore"
                    @if($control->items->count() == 0)
                        disabled
                    @endif
                >
                    <i class="fas fa-sync"></i> Transferir y Terminar
                </button>
            @else
                @if($control->isOpen())
                    <button
                        class="btn btn-success"
                        wire:click="finish"
                        wire:loading.attr="disabled"
                        wire:target="finish"
                        @if($control->items->count() == 0)
                            disabled
                        @endif
                    >
                        <span
                            class="spinner-border spinner-border-sm"
                            role="status"
                            wire:loading
                            wire:target="finish"
                            aria-hidden="true"
                        >
                        </span>

                        <span wire:loading.remove wire:target="finish">
                            <i class="fas fa-check"></i>
                        </span>

                        Terminar
                    </button>
                @else
                    <a
                        class="btn btn-primary"
                        href="{{ route('warehouse.controls.index', [
                            'store' => $store,
                            'type' => $control->isReceiving() ? 'receiving' : 'dispatch',
                            'nav' => $nav,
                        ]) }}"
                    >
                        <i class="fas fa-arrow-circle-left"></i> Salir
                    </a>
                @endif
            @endif
        </div>
    </div>
</div>
