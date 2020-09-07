@extends('layouts.app')

@section('title', 'Rendiciones')

@section('content')

@include('agreements/nav')

<h3 class="mb-3">Rendiciones</h3>

<a class="btn btn-primary mb-3" href="{{ route('agreements.accountability.create', $agreement) }}">Crear</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Mes</th>
            <th>Documento</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($accountabilities as $accountability)
        <tr>
            <td>
                <a href="{{ route('agreements.accountability.detail.create', [$agreement, $accountability]) }}">
                    {{ $accountability->id }}
                </a>
            </td>
            <td>{{ $accountability->month }}</td>
            <td>{{ $accountability->document }}</td>
            <td>{{ $accountability->date->format('d-m-Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('custom_js')

@endsection
