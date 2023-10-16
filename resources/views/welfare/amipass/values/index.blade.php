@extends('layouts.bt4.app')

@section('title', 'Valor Anual Amipass')

@section('content')

    @include('welfare.nav')

    <a class="btn btn-primary mb-3" href="{{ route('welfare.amipass.value.createValue') }}">Agregar Valor para Amipass</a>

    <table class="table table-striped table-sm table-bordered" id="tabla_movimientos">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Periodo</th>
                <th scope="col">Tipo</th>
                <th scope="col">Monto</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($values as $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->period }}</td>
                    <td>{{ $value->type }}</td>
                    <td>{{ $value->amount }}</td>
                </tr>
            @endforeach
        </tbody>
    @endsection
