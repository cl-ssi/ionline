<div>
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Código de Barra</th>
                    <th>Producto</th>
                    <th>Programa</th>
                    <th>Categoría</th>
                    <th class="text-center">Cantidad</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="d-none" wire:loading.class.remove="d-none">
                    <td class="text-center" colspan="6">
                        @include('layouts.partials.spinner')
                    </td>
                </tr>
                @forelse($controlItems as $controlItem)
                <tr wire:loading.remove>
                    <td class="text-center">
                        <small>
                            {{ optional($controlItem->product)->barcode }}
                        </small>
                    </td>
                    <td>
                        {{ optional($controlItem->product->product)->name }}
                        <br>
                        <small>
                            {{ optional($controlItem->product)->name }}
                        </small>
                    </td>
                    <td>{{ optional($controlItem->control)->program_name }}</td>
                    <td>{{ optional($controlItem->product)->category_name }}</td>
                    <td class="text-center">{{ $controlItem->quantity }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-danger" wire:click="deleteItem({{ $controlItem }})">
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
</div>
