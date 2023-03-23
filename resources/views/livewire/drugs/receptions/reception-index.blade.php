<div>
    <div class="row">
        <div class="col-8">
            <h3 class="mb-3">
                Actas de recepción
            </h3>
        </div>
        <div class="col-4">
            <fieldset class="form-group">
                <div class="input-group input-group-sm mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="filter-by">
                            Filtrar por
                        </span>
                    </div>

                    <select
                        id="filter-by"
                        wire:model.defer="filter"
                        class="form-control form-control-sm"
                    >
                        <option value="all">Todos</option>
                        <option value="">Últimos 15 días</option>
                        <option value="pending">Pendientes de Destrucción</option>
                    </select>
                </div>

            </fieldset>
        </div>
    </div>

    @can('Drugs: view receptions')

    <div class="input-group">

        @can('Drugs: create receptions')
            <div class="input-group-prepend">
                <a
                    class="btn btn-primary"
                    href="{{ route('drugs.receptions.create') }}"
                >
                    <i class="fas fa-plus"></i> Agregar nueva
                </a>
            </div>
        @endcan

        <input
            type="text"
            wire:model.defer="search"
            class="form-control"
            id="for-search"
            onkeyup="filter(0)"
            placeholder="Escriba el número de acta y presione la lupa."
        >

        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit" wire:click="getReceptions">
                <i class="fas fa-search" aria-hidden="true"></i>
            </button>
        </div>

    </div>

    <table class="table table-sm table-hover table-bordered small mt-2">
        <thead>
            <tr>
                <th>N.Acta</th>
                <th>Fecha Acta</th>
                <th>N° Doc</th>
                <th>Origen Oficio</th>
                <th>Origen Parte</th>
                <th>Items</th>
                <th>Recep</th>
                <th>Destr</th>
                <th class="d-print-none"></th>
            </tr>
        </thead>
        <tbody>
            <tr
                class="d-none"
                wire:loading.class.remove="d-none"
            >
                <td class="text-center" colspan="9">
                    @include('layouts.partials.spinner')
                </td>
            </tr>
            @forelse($receptions as $reception)
            <tr wire:loading.remove >
                <td class="text-center">{{ $reception->id }}</td>
                <td class="text-center" nowrap>{{ $reception->date->format('d-m-Y') }}</td>
                <td class="text-center">{{ $reception->document_number }}</td>
                <td>{{ $reception->documentPoliceUnit->name }}</td>
                <td>{{ $reception->partePoliceUnit->name }}</td>
                <td>{{ $reception->items->count() }}</td>
                <td class="text-center">
                    @if( $reception->items->isNotEmpty() )
                        <a
                            href="{{ route('drugs.receptions.record', $reception->id) }}"
                            class="btn btn-outline-success btn-sm"
                            target="_blank"
                        >
                            <i class="fas fa-fw fa-file-pdf"></i>
                        </a>
                    @endif
                </td>

                <td class="text-center">
                    @if( $reception->haveItemsForDestruction->isEmpty() )
                        <i class="fas fa-ban" title="Sin items para destruir"></i>
                    @else
                        @if( $reception->destruction )
                            <a
                                href="{{ route('drugs.destructions.show', $reception->destruction->id) }}"
                                class="btn btn-outline-danger btn-sm"
                                target="_blank"
                            >
                                <i class="fas fa-fw fa-file-pdf"></i>
                            </a>
                        @else
                            <span class="badge badge-secondary" title="Dias restantes para su destrucción">
                                {{ $reception->date->diffInDays(Carbon\Carbon::now()) -15 }}
                            </span>
                        @endif
                    @endif
                </td>
                <td class="text-center d-print-none">
                    <a
                        href="{{ route('drugs.receptions.show', $reception->id) }}"
                        class="btn btn-outline-primary btn-sm"
                    >
                        <i class="fas fa-fw fa-edit"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr class="text-center" wire:loading.remove>
                <td colspan="9">
                    <small>
                        No hay registros
                    </small>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="row">
        <div class="col">
            {{ $receptions->links() }}
        </div>
        <div class="col text-right">
            <small>
                Total de Resultados: {{ $receptions->total() }}
            </small>
        </div>
    </div>
    @endcan
</div>
