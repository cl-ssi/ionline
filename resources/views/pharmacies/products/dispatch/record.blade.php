@extends('layouts.report_pharmacies')

@section('title', "Acta de despacho " . $dispatch->id )

@section('content')

@if(auth()->user()->pharmacies->firstWhere('id', session('pharmacy_id'))->id == 1 || auth()->user()->pharmacies->firstWhere('id', session('pharmacy_id'))->id == 2)
    <div>
        <div style="width: 49%; display: inline-block;">
            <div class="siete" style="padding-top: 3px;">
                Droguería - {{ env('APP_SS') }}
            </div>
            <div class="siete" style="padding-top: 3px;">
                <i>fernando.molina@redsalud.gob.cl</i>
            </div>
        </div>
        <div class="right" style="width: 49%; display: inline-block;">
            Iquique {{ $dispatch->date->locale('es')->isoFormat('D [de] MMMM [del] YYYY') }}<br>
        </div>
    </div>
@endif
@if(auth()->user()->pharmacies->firstWhere('id', session('pharmacy_id'))->id == 3)
    <div>
        <div style="width: 49%; display: inline-block;">
            <div class="siete" style="padding-top: 3px;">
                Bodega APS - {{ env('APP_SS') }}
            </div>
            <div class="siete" style="padding-top: 3px;">
                <i>bodega.ssi@redsalud.gov.cl</i>
            </div>
            <div class="siete" style="padding-top: 3px;">
                <i>N* minsal 576975 teléfono 572406975</i>
            </div>
        </div>
        <div class="right" style="width: 49%; display: inline-block;">
            Iquique {{ $dispatch->date->locale('es')->isoFormat('D [de] MMMM [del] YYYY') }}<br>
        </div>
    </div>
@endif
@if(auth()->user()->pharmacies->firstWhere('id', session('pharmacy_id'))->id == 4)
    <div>
        <div style="width: 49%; display: inline-block;">
            <div class="siete" style="padding-top: 3px;">
                Bodega Servicios Generales - {{ env('APP_SS') }}
            </div>
            <div class="siete" style="padding-top: 3px;">
                <i>bodega.ssi@redsalud.gov.cl</i>
            </div>
            <div class="siete" style="padding-top: 3px;">
                <i>N* minsal 576975 teléfono 572406975</i>
            </div>
        </div>
        <div class="right" style="width: 49%; display: inline-block;">
            Iquique {{ $dispatch->date->locale('es')->isoFormat('D [de] MMMM [del] YYYY') }}<br>
        </div>
    </div>
@endif


<div class="titulo">ACTA DE DESPACHO N° {{ $dispatch->id }}</div>

<div style="padding-bottom: 8px;">
    <strong>Enviado a:</strong> {{ $dispatch->destiny ? $dispatch->destiny->name : '' }} {{$dispatch->receiver ? $dispatch->receiver->shortName : ''}}<br>
    <strong>Nota:</strong> {{ $dispatch->notes }}<br>
</div>

<table class="ocho">
    <thead>
        <tr>
            <th>Cantidad</th>
            <th>Descripción del material</th>
            <th>Fecha de Venc.</th>
            <th>Lote</th>
            <th>Cond. Almacenamiento</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dispatch->dispatchItems as $item)
            <tr>
                <td class="right" style="vertical-align: top;">{{ $item->amount }} {{ $item->unity }}</td>
                <td style="vertical-align: top;">{{ $item->product->name }}</td>
                <td style="vertical-align: top;">{{ Carbon\Carbon::parse($item->due_date)->format('d/m/Y')}}</td>
                <td style="vertical-align: top;">{{ $item->batch }}</td>
                <td style="vertical-align: top;">{{ $item->product->storage_conditions }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div id="firmas" style="display: flex; justify-content: space-between;">
    <div class="center" style="width: 49%; border: 1px solid #000; padding: 10px;">
        <span class="uppercase" style="display: block; text-align: center;">
        @if(auth()->user()->pharmacies->firstWhere('id', session('pharmacy_id'))->id == 2)
            @if(auth()->id() == 18899957 || auth()->id() == 16074423)
                QF Botiquín
            @else 
                Bodeguero
            @endif
        @else
            Encargado de bodega
        @endif
        </span>
        <br>
        <span style="display: block; text-align: left;">Nombre: {{ auth()->user()->shortName }}</span>
        <br>
        <span style="display: block; text-align: left;">RUT: {{ auth()->user()->runFormat() }}</span>
        <br>
        <span style="display: block; text-align: left;">Cargo: {{ auth()->user()->position }}</span>
        <br>
        <span style="display: block; text-align: left;">Firma: </span>
    </div>
    <div class="center" style="width: 49%; border: 1px solid #000; padding: 10px;">
        <span class="uppercase" style="display: block; text-align: center;">Funcionario que recibe</span>
        <br>
        <span style="display: block; text-align: left;">Nombre: </span>
        <br>
        <span style="display: block; text-align: left;">RUT: </span>
        <br>
        <span style="display: block; text-align: left;">N° de bultos: [Número de bultos]</span>
        <br>
        <span style="display: block; text-align: left;">Firma: </span>
    </div>
</div>


@endsection
