@extends('layouts.app')

@section('title', 'Reporte')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Reporte</h3>

<h4>Cantidades sin destruir</h4>

<div class="row">
    <div class="col-6">
        <table class="table table-sm table-bordered small">
            <thead>
                <tr>
                    <th>Sustancia Presunta</th>
                    <th class="text-center">Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items_sin_destruir as $nombre => $cantidad)
                <tr>
                    <td>{{ $nombre }}</td>
                    <td class="text-center">{{ $cantidad }} g</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<table class="table table-sm table-bordered small table-hover vrt-header">
    <thead>
        <tr>
            <th>Autor</th>
            <th>N° Rec</th>
            <th>Fecha</th>
            <th>Oficio</th>
            <th style="width: 30px; word-wrap: break-word">Parte</th>
            <th>Fiscalia</th>
            <th>NUE</th>
            <th>Imputado</th>
            <th>Sustancia Presunta</th>
            <th>Sustancia Determinda</th>
            <th>P.Neto</th>
            <th>Muestra</th>
            <th>C.Muestra</th>
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
            <td class="text-center">{{ $item->reception->parte }}</td>
            <td>{{ $item->reception->court->name }}</td>
            <td>{{ $item->nue }}</td>
            <td>{{ $item->reception->imputed }}</td>
            <td>{{ $item->substance->name }}</td>
            <td>
                @foreach($item->protocols as $protocol )
                    {{ ( $protocol->result == 'Positivo' ) ? 'Marihuana' : 'Hierba' }}
                @endforeach
                {{ ($item->resultSubstance) ? $item->resultSubstance->name:'' }}
            </td>
            <td class="text-right">{{ $item->net_weight }}</td>
            <td class="text-right">{{ $item->sample }}</td>
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


@endsection

@section('custom_js')

@endsection
