@extends('layouts.app')

@section('title', 'Home')

@section('content')

@include('service_requests.partials.nav')


<form method="get" class="form-inline mb-3" action="{{ route('rrhh.service-request.report.export_sirh') }}">
    <div class="form-row">
        <div class="form-group ml-4">
            <label for="for_run">Run</label>
            <input name="run" class="form-control" id="for_run_id" placeholder="opcional. EJ: 123456">
            
        </div>        
    </div>
    <br>
    <br>
    <div class="form-row">
        <div class="form-group ml-3">
            <label for="for_from">Fecha Inicio de Contrato Desde*</label>
            <input type="datetime-local" class="form-control mx-sm-3" id="for_from" name="from" value="{{old('from') }}" required>
        </div>
        <div class="form-group ml-3">
            <label for="for_to">Fecha Inicio de Contrato Hasta*</label>
            <input type="datetime-local" class="form-control mx-sm-3" id="for_to" name="to" value="{{old('to') }}" required>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
    </div>
        
        <div class="form-row">
        
        
        
        <div class="float-right">
        <a type="button" class="btn btn-success" target="_blank"  href="{{ route('rrhh.service-request.report.export-sirh-txt', ['establishment' => $request->establishment, 'sirh' => $request->sirh, 'from' => $request->from, 'to' => $request->to       ]  ) }}">Formato SIRH (Todos los Resultados Busqueda) (<small>{{$filitas->total()}} Registros</small>) <i class="far fa-file-excel"></i>
        </a>
        </div>
        
        <br>
        
        
        </div>
        
        
    
</form>


<table class="table table-sm table-bordered table-responsive small text-uppercase" id="tabla_sirh">
    <thead>
        <tr>
            <th>ID Service Request</th>
            <th>Run</th>
            <th>DV</th>            
            <th>Fecha inicio contrato</th>
            <th>Fecha fin contrato</th>
            <th>Establecimiento</th>
            <th>Cargado SIRH</th>
        </tr>
    </thead>
    @forelse($filitas?: [] as $fila)
    <tr>
    <td>{{$fila->id}}</td>
    <td>{{$fila->employee->id}}</td>
    <td>{{$fila->employee->dv}}</td>
    <td>{{$fila->start_date->format('d/m/Y')}}</td>
    <td>{{$fila->end_date->format('d/m/Y')}}</td>
    <td>{{$fila->establishment->name}}</td>
    <td>{{$fila->sirh_contract_registration}}</td>
    </tr>    
    

    @empty


    @endforelse   




</table>

{{ $filitas->appends(request()->query())->links() }}



<!-- <a class="btn btn-outline-success mb-3"
    href="{{ route('rrhh.service-request.report.export-sirh-txt') }}">
    <i class="far fa-file"></i> Descargar Formato SIRH
</a>
-->

@livewire('service-request.mass-update-sirh-status') 

@endsection

@section('custom_js')

@endsection