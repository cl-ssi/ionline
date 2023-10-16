<div>
    <div class="row">
        <div class="col my-2">
            <h5>
                Listado de
                Egresos:
                {{ $store->name }}
            </h5>
        </div>

        <div class="col text-right">
            @if($store)
                @can('Store: create dispatch')
                    <a
                        class="btn btn-primary"
                        href="{{ route('warehouse.controls.create', [
                            'store' => $store,
                            'type' => 'dispatch',
                            'nav' => $nav,
                        ]) }}"
                    >
                        <i class="fas fa-plus"></i> Nuevo Egreso
                    </a>
                @endcan
            @endif
        </div>
    </div>

    <div class="table table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th>Fecha</th>
                    <th>Destino</th>
                    <th>Programa</th>
                    <th class="text-center"># Productos</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Acta Despacho</th>
                </tr>
            </thead>
            <tbody>
                <tr class="d-none" wire:loading.class.remove="d-none" wire:target="search">
                    <td class="text-center" colspan="7">
                        @include('layouts.bt4.partials.spinner')
                    </td>
                </tr>
                @forelse($controls as $control)
                <tr>
                    <td class="text-center">
                        <a
                            @if($control->isClose())
                                href="{{ route('warehouse.control.add-product', [
                                    'store' => $store,
                                    'control' => $control,
                                    'type' => $control->isReceiving() ? 'receiving' : 'dispatch',
                                    'nav' => $nav,
                                ]) }}"
                            @else
                                href="{{ route('warehouse.controls.edit', [
                                    'store' => $store,
                                    'control' => $control,
                                    'type' => $control->isReceiving() ? 'receiving' : 'dispatch',
                                    'nav' => $nav,
                                ]) }}"
                            @endif
                            class="btn btn-sm btn-outline-secondary"
                        >
                            <i class="fas fa-edit"></i> {{ $control->id }}
                        </a>
                    </td>
                    <td>{{ $control->date_format }}</td>
                    <td>
                        @switch($control->type_dispatch_id)
                            @case(\App\Models\Warehouse\TypeDispatch::internal())
                                {{ optional($control->organizationalUnit)->establishment->name }}
                                <br>
                                {{ optional($control->organizationalUnit)->name }}
                                @break
                            @case(\App\Models\Warehouse\TypeDispatch::external())
                                {{ optional($control->destination)->name }}
                                @break
                            @case(\App\Models\Warehouse\TypeDispatch::adjustInventory())
                                {{ optional($control->typeDispatch)->name }}
                                @break
                            @case(\App\Models\Warehouse\TypeDispatch::sendToStore())
                                {{ optional($control->destinationStore)->name }}
                                @break
                        @endswitch
                        <br>
                        <small>
                            {{ optional($control->typeDispatch)->name }}
                        </small>
                    </td>
                    <td>{{ $control->program_name }}</td>
                    <td class="text-center">{{ $control->items->count() }}</td>
                    <td class="text-center">
                        <span class="badge badge-{{ $control->color_confirm }}">
                            {{ $control->confirm_format }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a
                            href="{{ route('warehouse.control.pdf', [
                                'store' => $store,
                                'control' => $control,
                            ]) }}"
                            class="btn btn-sm btn-outline-success"
                            target="_blank"
                            title="Acta de Egreso"
                        >
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </td>
                </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="7">
                            <em>No hay resultados</em>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <caption>
                Total de resultados: {{ $controls->total() }}
            </caption>
        </table>
    </div>

    {{ $controls->links() }}
</div>
