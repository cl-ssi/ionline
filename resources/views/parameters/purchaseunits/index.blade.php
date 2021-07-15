@extends('layouts.app')

@section('title', 'Unidad de Compra')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Mantenedor Unidad de Compra</h3>

<a class="btn btn-primary mb-3" href="{{ route('parameters.purchaseunits.create') }}">
    Crear
</a>

<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchaseUnits as $purchaseUnit)
        <tr>
            <td>{{ $purchaseUnit->name }}</td>
            <td>
                <a href="{{ route('parameters.purchaseunits.edit', $purchaseUnit) }}">
                    <i class="fas fa-edit"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


@endsection

@section('custom_js')

@endsection
