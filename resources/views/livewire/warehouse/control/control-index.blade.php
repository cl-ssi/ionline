<div>
    <div class="row">
        <div class="col mb-2">
            <h3>
                Listado de
                @if($type == 'receiving')
                    Ingreso
                @else
                    Egreso
                @endif
            </h3>
        </div>
        <div class="col text-right">
            @if($type == 'receiving')
                @if(Auth::user()->active_store)
                <a
                    class="btn btn-primary"
                    href="{{ route('warehouse.controls.create', [
                        'store' => Auth::user()->active_store,
                        'type' => 'receiving'
                    ]) }}"
                >
                    <i class="fas fa-plus"></i> Nuevo Ingreso
                </a>
                @endif
            @else
                @if(Auth::user()->active_store)
                <a
                    class="btn btn-primary"
                    href="{{ route('warehouse.controls.create', [
                        'store' => Auth::user()->active_store,
                        'type' => 'dispatch'
                    ]) }}"
                >
                    <i class="fas fa-plus"></i> Nuevo Egreso
                </a>
                @endif
            @endif
        </div>
    </div>

    <div class="table table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>
                        @if($type == 'receiving')
                            Origen
                        @else
                            Destino
                        @endif
                    </th>
                    <th>Programa</th>
                    <th class="text-center"># Productos</th>
                    <th>Nota</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="d-none" wire:loading.class.remove="d-none" wire:target="search">
                    <td class="text-center" colspan="8">
                        @include('layouts.partials.spinner')
                    </td>
                </tr>
                @forelse($controls as $control)
                <tr>
                    <td>
                        <a
                            href="{{ route('warehouse.controls.edit', [
                                'store' => $store,
                                'control' => $control
                            ]) }}"
                            class="btn btn-sm btn-outline-secondary"
                        >
                            <i class="fas fa-edit"></i> {{ $control->id }}
                        </a>
                    </td>
                    <td>{{ $control->date_format }}</td>
                    <td>
                        @if($control->isReceiving())
                            {{ optional($control->origin)->name }}
                        @else
                            @if($control->isAdjustInventory())
                                {{ $control->type_dispatch }}
                            @else
                                {{ optional($control->destination)->name }}
                            @endif
                        @endif
                    </td>
                    <td>{{ $control->program_name }}</td>
                    <td class="text-center">{{ $control->items->count() }}</td>
                    <td>{{ $control->short_note }}</td>
                    <td class="text-center">
                        @if($control->isDispatch())
                        <a
                            href="{{ route('warehouse.control.pdf', [
                                'store' => $store,
                                'control' => $control
                            ]) }}"
                            class="btn btn-sm btn-outline-secondary"
                        >
                            <i class="fas fa-file-pdf"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr class="text-center">
                    <td colspan="8">
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
