@extends('layouts.bt4.app')

@section('title', 'Reporte')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Reporte</h3>

@foreach ($years as $year)
    <a href="{{ route('drugs.receptions.export', ['year'=>$year->year]) }}">{{ $year->year }}</a> - 
@endforeach

<h4 class="mt-3">Cantidades sin destruir</h4>

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
                @foreach($items_sin_destruir as $nombre => $data)
                <tr>
                    <td>{{ $nombre }}</td>
                    <td class="text-center">{{ $data['sum'] }} {{ $data['unit'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@livewire('drugs.receptions.report-by-item')

@endsection

@section('custom_js')

@endsection
