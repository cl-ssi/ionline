@extends('layouts.app')

@section('title', 'Valor Hora/Jornada')

@section('content')

@include('parameters/nav')
<h3 class="mb-3">Valores Hora/Jornada</h3>

<a class="btn btn-primary mb-3" href="{{ route('parameters.values.create') }}">Crear</a>


<table class="table table-sm">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tipo de Contrato</th>
            <th>Jornada</th>
            <th>Estamento</th>
            <th>Valor Hora</th>
            <th>Vigencia</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($values as $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->contract_type }}</td>
            <td>{{ $value->work_type }}</td>
            <td>{{ $value->estate }}</td>
            <td>{{ $value->amount }}</td>
            <td>{{ $value->validity_from }}</td>
            <td>
                <a href="{{ route('parameters.values.edit',$value) }}">
                <i class="fas fa-edit"></i>
                </a>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align: center; vertical-align: middle;" >No Hay Valores Creados</td></tr>
        @endforelse
    </tbody>
</table>



@endsection

@section('custom_js')

@endsection
