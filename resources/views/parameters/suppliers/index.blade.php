@extends('layouts.app')

@section('title', 'Mecanismo de Compra')

@section('content')

<h3 class="mb-3">Mantenedor de Proveedores</h3>

<a class="btn btn-primary mb-3" href="{{ route('parameters.suppliers.create') }}">
    Crear
</a>

<div class="table-responsive">
    <table class="table table-bordered table-sm small">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Run</th>
                <th>Dirección</th>
                <th>Región</th>
                <th>Comuna</th>
                <th>Teléfono</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($suppliers as $key => $supplier)
            <tr>
                <td class="text-center">{{ $supplier->id }}</td>
                <th>{{ $supplier->name }}</th>
                <td>{{ $supplier->run }}-{{ $supplier->dv }}</td>
                <td>{{ $supplier->address }}</td>
                <td>{{ $supplier->region->name ?? '' }}</td>
                <td>{{ $supplier->commune->name ?? '' }}</td>
                <td>{{ $supplier->telephone }}</td>
                <td>
                    <a href="{{ route('parameters.suppliers.edit', $supplier) }}">
                      <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
<div>


@endsection

@section('custom_js')

@endsection
