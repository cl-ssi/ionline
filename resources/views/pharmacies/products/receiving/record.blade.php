@extends('layouts.report_pharmacies')

@section('title', "Acta de ingreso " . $receiving->id )

@section('content')

<?php setlocale(LC_ALL, 'es_CL.UTF-8');?>

@if(Auth::user()->pharmacies->first()->id == 1 || Auth::user()->pharmacies->first()->id == 2)
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
            Iquique {{ $receiving->date->formatLocalized('%d de %B del %Y') }}<br>
        </div>
    </div>
@endif
@if(Auth::user()->pharmacies->first()->id == 3)
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
            Iquique {{ $receiving->date->formatLocalized('%d de %B del %Y') }}<br>
        </div>
    </div>
@endif
@if(Auth::user()->pharmacies->first()->id == 4)
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
            Iquique {{ $receiving->date->formatLocalized('%d de %B del %Y') }}<br>
        </div>
    </div>
@endif

<div class="titulo">ACTA DE INGRESO N° {{ $receiving->id }}</div>

<div style="padding-bottom: 8px;">
    <strong>Recibido de:</strong> {{ $receiving->establishment->name }}<br>
    <strong>Nota:</strong> {{ $receiving->notes }}<br>
</div>

<table class="ocho">
    <thead>
        <tr>
            <th>Cantidad</th>
            <th>Descripción del material</th>
            <th>Fecha de Venc.</th>
            <th>Lote</th>
        </tr>
    </thead>
    <tbody>
        @foreach($receiving->receivingItems as $item)
            <tr>
                <td class="right">{{ $item->amount }} {{ $item->unity }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ Carbon\Carbon::parse($item->due_date)->format('d/m/Y')}}</td>
                <td>{{ $item->batch }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


<div id="firmas">
    <div class="center" style="width: 49%;">
        <span class="uppercase"></span>
    </div>
    <div class="center" style="width: 49%">
      @if(Auth::user()->pharmacies->first()->id == 2)
        <span class="uppercase">{{Auth::user()->name}}</span><br>
        @if(Auth::user()->id == 18899957 || Auth::user()->id == 16074423)
          <span class="uppercase">QF Botiquín</span>
        @else <!-- 12093932 -->
          <span class="uppercase">Bodeguero</span>
        @endif
      @else
        <span class="uppercase">Encargado de bodega</span>
      @endif
    </div>
</div>
@endsection
