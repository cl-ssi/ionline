@extends('layouts.report_pharmacies')

@section('title', "Fraccionamiento " . $fractionation->id )

@section('content')

<div class="titulo">DOCUMENTO DE PRUEBA</div>

<div style="padding-bottom: 8px;">
    <strong>ID:</strong> {{ $fractionation->id}}<br>
    <strong>Nota:</strong> {{ $fractionation->notes }}<br>
</div>

@endsection
