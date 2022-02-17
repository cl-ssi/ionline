@extends('layouts.app')

@section('title', 'Item Presupuestario')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Mantenedor Item Presupuestario</h3>

<a class="btn btn-primary mb-3" href="{{ route('parameters.budgetitems.create') }}">
    Crear
</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Código</th>
            <th>Nombre</th>
        </tr>
    </thead>
    <tbody>
        @foreach($budgetItems as $budgetItem)
        <tr>
            <td>{{ $budgetItem->id }}</td>
            <td>{{ $budgetItem->code }}</td>
            <td>{{ $budgetItem->name }}</td>
            <td>
                <a href="{{ route('parameters.budgetitems.edit', $budgetItem) }}">
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
