@extends('layouts.bt4.app')

@section('title', 'Dashboard amiPASS')

@section('content')

@include('welfare.nav')

<table class="table table-striped table-sm table-bordered" id="tabla_movimientos">
    <thead>
        <tr>
            <th scope="col">Rut</th>
            <th scope="col">Nombre</th>
            <th scope="col">F.Inicio</th>
            <th scope="col">F.Término</th>
            <th scope="col">Estab.</th>
            
        </tr>
    </thead>
    <tbody>
    @foreach($employeeInformations as $employeeInformation)

        <tr class="small">
            <td>{{ $employeeInformation->rut }}-{{ $employeeInformation->dv }}</td>
            <td>{{ $employeeInformation->nombre_funcionario }}</td>
            <td>@if($employeeInformation->fecha_inicio_contrato) {{ $employeeInformation->fecha_inicio_contrato->format('Y-m-d') }}@endif</td>
            <td>@if($employeeInformation->fecha_termino_contrato) {{ $employeeInformation->fecha_termino_contrato->format('Y-m-d') }}@endif</td>
            <td>{{ $employeeInformation->establecimiento }}</td>
        </tr>
        @endforeach
    </tbody>

</table>

{{ $employeeInformations->links() }}

@endsection