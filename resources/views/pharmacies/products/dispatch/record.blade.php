@extends('layouts.report_pharmacies')

@section('title', "Acta de despacho " . $dispatch->id )

@section('content')

<?php setlocale(LC_ALL, 'es_CL.UTF-8');?>

@canany(['Pharmacy: SSI (id:1)', 'Pharmacy: REYNO (id:2)'])
    <div>
        <div style="width: 49%; display: inline-block;">
            <div class="siete" style="padding-top: 3px;">
                Droguería - {{ config('app.ss') }}
            </div>
            <div class="siete" style="padding-top: 3px;">
                <i>fernando.molina@redsalud.gob.cl</i>
            </div>
        </div>
        <div class="right" style="width: 49%; display: inline-block;">
            Iquique {{ $dispatch->date->formatLocalized('%d de %B del %Y') }}<br>
        </div>
    </div>
@endcan
@can('Pharmacy: APS (id:3)')
    <div>
        <div style="width: 49%; display: inline-block;">
            <div class="siete" style="padding-top: 3px;">
                Bodega APS - {{ config('app.ss') }}
            </div>
            <div class="siete" style="padding-top: 3px;">
                <i>bodega.ssi@redsalud.gov.cl</i>
            </div>
            <div class="siete" style="padding-top: 3px;">
                <i>N* minsal 576975 teléfono 572406975</i>
            </div>
        </div>
        <div class="right" style="width: 49%; display: inline-block;">
            Iquique {{ $dispatch->date->formatLocalized('%d de %B del %Y') }}<br>
        </div>
    </div>
@endcan
@can('Pharmacy: Servicios generales (id:4)')
    <div>
        <div style="width: 49%; display: inline-block;">
            <div class="siete" style="padding-top: 3px;">
                Bodega Servicios Generales - {{ config('app.ss') }}
            </div>
            <div class="siete" style="padding-top: 3px;">
                <i>bodega.ssi@redsalud.gov.cl</i>
            </div>
            <div class="siete" style="padding-top: 3px;">
                <i>N* minsal 576975 teléfono 572406975</i>
            </div>
        </div>
        <div class="right" style="width: 49%; display: inline-block;">
            Iquique {{ $dispatch->date->formatLocalized('%d de %B del %Y') }}<br>
        </div>
    </div>
@endcan


<div class="titulo">ACTA DE DESPACHO N° {{ $dispatch->id }}</div>

<div style="padding-bottom: 8px;">
    <strong>Enviado a:</strong> {{ $dispatch->establishment->name }}<br>
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


<div id="firmas">
    <!-- <div class="center" style="width: 49%;">
        <span class="uppercase">Encargado de bodega</span>
    </div> -->
    <div class="center" style="width: 49%">
      @if( Auth::user()->can('Pharmacy: REYNO (id:2)'))
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
    <div class="center" style="width: 49%">
        <span class="uppercase">Funcionario que recibe</span>
    </div>
</div>
@endsection
