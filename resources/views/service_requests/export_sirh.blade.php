@extends('layouts.app')

@section('title', 'Home')

@section('content')

@include('service_requests.partials.nav')


<form method="get" class="form-inline mb-3" action="{{ route('rrhh.service-request.report.export_sirh') }}">
    <div class="form-row">
        <div class="form-group ml-4">
            <label for="for_establishment_id">Establecimiento*</label>
            <select name="establishment" class="form-control" id="for_establishment_id" required>
                <option value="">Seleccionar</option>
                @foreach($establishments as $establishment)
                <option value="{{$establishment->id}}">
                {{$establishment->name}}
                </option>
                @endforeach
            </select>
        </div>
        <!-- <div class="form-group ml-4">
        <label for="for_sirh_id">Cargado*</label>
        <select name="sirh" class="form-control" id="for_sirh" required>
            <option value="">Seleccionar</option>
            <option value="1"{{ (old('sirh')==1)?'selected':'' }} >Sí</option>
            <option value="0" {{ (old('sirh')==0)?'selected':'' }} >No</option>
        </select>
        </div> -->
    </div>
    <div class="form-row">
        <div class="form-group ml-3">
            <label for="for_from">Fecha Inicio de Contrato Desde</label>
            <input type="datetime-local" class="form-control mx-sm-3" id="for_from" name="from" value="{{old('from') }}" required>
        </div>        
    </div>               
        
        <div class="form-row">
        <div class="form-group mr-1">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
        </div>
        
        @if(isset($request->establishment))
        <div class="float-right">
        <a type="button" class="btn btn-success" target="_blank"  href="{{ route('rrhh.service-request.report.export-sirh-txt', ['establishment' => $request->establishment, 'sirh' => $request->sirh, 'from' => $request->from, 'to' => $request->to       ]  ) }}">Formato SIRH (<small>Prueba</small>) <i class="far fa-file-excel"></i>
        </a>
        </div>
        @endif
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



<!-- <a class="btn btn-outline-success mb-3"
    href="{{ route('rrhh.service-request.report.export-sirh-txt') }}">
    <i class="far fa-file"></i> Descargar Formato SIRH
</a>
-->

@livewire('service-request.mass-update-sirh-status') 

@endsection

@section('custom_js')

@endsection