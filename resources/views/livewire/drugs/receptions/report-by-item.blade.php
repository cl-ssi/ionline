<div>

<div class="row">
    <div class="col-4">
        <div class="form-group">
            <label for="search">Filtrar por rama</label>
            <!-- filtro por rama de la sustancia -->
            <select wire:model.live="rama" class="form-control">
                <option value="">Todas las sustancias</option>
                @foreach($ramas as $rama)
                    <option value="{{ $rama }}">{{ $rama }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <!-- spin wire:loading -->
    <div wire:loading>
        <div class="col-2 text-center">
            <label>&nbsp;</label>
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>
<!-- hide table on wire:loading -->
<table class="table table-sm table-bordered small table-hover vrt-header" wire:loading.remove>
    <thead>
        <tr>
            <th>Autor</th>
            <th>N° Rec</th>
            <th>Fecha</th>
            <th>Oficio</th>
            <th>Policia</th>
            <th>Funcionario que entrega</th>
            <th style="width: 30px; word-wrap: break-word">Parte</th>
            <th>Fiscalia</th>
            <th>NUE</th>
            {{-- <th>Imputado</th> --}}
            <th>Sustancia Presunta</th>
            <th>Sustancia Determinda</th>
            <th>P.Oficio</th>
            <th>P.Bruto</th>
            <th>P.Neto</th>
            <th>Cant.Muestra</th>
            <th>Peso.Muestra</th>
            <th>Cant.CMuestra</th>
            <th>Peso.CMuestra</th>
            <th>Autor</th>
            <th>Por Destruir</th>
            <th>Fecha</th>
            <th>Destruido</th>
            <th>Envío a ISP</th>
            <th>Envío a Fiscalía</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td class="text-center">{{ $item->reception->user->Initials }}</td>
            <td class="text-right"><a href="{{ route('drugs.receptions.show', $item->reception_id) }}">{{ $item->reception_id }}</a></td>
            <td nowrap>{{ $item->reception->date->format('d-m-Y') }}</td>
            <td class="text-center">{{ $item->reception->document_number }}</td>
            <td class="text-center">{{ $item->reception->partePoliceUnit->name ?? '' }}</td>
            <td class="text-center">{{ $item->reception->delivery }}</td>
            <td class="text-center">{{ $item->reception->parte }}</td>
            <td>{{ $item->reception->court->name }}</td>
            <td>{{ $item->nue }}</td>
            {{-- <td></td> --}}
            <td>{{ $item->substance->name }}</td>
            <td>
                @foreach($item->protocols as $protocol )
                    {{ ( $protocol->result == 'Positivo' ) ? 'Marihuana' : 'Hierba' }}
                @endforeach
                {{ ($item->resultSubstance) ? $item->resultSubstance->name:'' }}
            </td>
            <td class="text-right">{{ $item->document_weight }}</td>
            <td class="text-right">{{ $item->gross_weight }}</td>
            <td class="text-right">{{ $item->net_weight }}</td>
            <td class="text-right">{{ $item->sample_number }}</td>
            <td class="text-right">{{ $item->sample }}</td>
            <td class="text-right">{{ $item->countersample_number }}</td>
            <td class="text-right">{{ $item->countersample }}</td>
            <td class="text-center">{{ @$item->reception->destruction->user->Initials ?: '' }}</td>
            <td class="text-right">
                @if( ! $item->reception->wasDestructed() )
                    {{ $item->destruct }}
                @endif
            </td>
            <td nowrap>
                @if( $item->reception->wasDestructed() )
                    {{ $item->reception->destruction->destructed_at->format('d-m-Y') }}
                @endif
            </td>
            <td class="text-right">
                @if( $item->reception->wasDestructed() )
                    {{ $item->destruct }}
                @endif
            </td>
            <td>
                {{ ($item->reception->sampleToIsp AND $item->reception->sampleToIsp->number) ? $item->reception->sampleToIsp->number : '' }}
            </td>
            <td>
                {{ ($item->reception->recordToCourt AND $item->reception->recordToCourt->number) ? $item->reception->recordToCourt->number : '' }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


{{ $items->links() }}
</div>
