@extends('layouts.app')

@section('title', 'Mecanismo de Compra')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Mantenedor Mecanismo de Compra</h3>

<a class="btn btn-primary mb-3" href="{{ route('parameters.purchasemechanisms.create') }}">
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
        @foreach($purchaseMechanisms as $purchaseMechanism)
        <tr>
            <td>{{ $purchaseMechanism->name }}</td>
            <td>
                <a href="{{ route('parameters.purchasemechanisms.edit', $purchaseMechanism) }}">
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
