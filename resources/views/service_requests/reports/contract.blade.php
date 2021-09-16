@extends('layouts.app')

@section('title', 'Reporte de contrato')

@section('content')

@include('service_requests.partials.nav')


<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.report.contract') }}">
    <div class="form-row">

        <fieldset class="form-group col-md-3">
            <label for="for_option">Opción*</label>
            <select name="option" class="form-control" required>
                <option value="">Seleccione Opción</option>
                <option value="request_date" {{ (old('option')=='request_date')?'selected':'' }}>Solicitados entre</option>
                <option value="start_date" {{ (old('option')=='start_date')?'selected':'' }}>Que comiencen entre</option>
                <option value="end_date" {{ (old('option')=='end_date')?'selected':'' }}>Que terminen entre</option>
                <option value="vigenci" {{ (old('option')=='vigenci')?'selected':'' }}>Vigentes entre</option>
            </select>
        </fieldset>


        <fieldset class="form-group col-md-3">
            <label for="for_from">Desde*</label>
            <input type="date" class="form-control" min="2020-01-01" max="{{Carbon\Carbon::now()->toDateString()}}" name="from" value="{{ old('from') }}" required>
        </fieldset>

        <fieldset class="form-group col-md-3">
            <label for="for_to">Hasta*</label>
            <input type="date" class="form-control" min="2020-01-01" max="2022-01-01" name="to" value="{{ old('to') }}" required>
        </fieldset>

        <fieldset class="form-group col-md-3">
            <label for="for_type">Origen de financiamiento*</label>
            <select name="type" class="form-control">
                <option value="">Todos</option>
                <option value="Covid" {{ (old('type')=='Covid')?'selected':'' }}>Honorarios - Covid</option>
                <option value="Suma alzada" {{ (old('type')=='Suma alzada')?'selected':'' }}>Suma alzada</option>
            </select>
        </fieldset>

    </div>
    <div class="form-row">
        <fieldset class="form-group col-md-5">
            <label for="for_to">Unidad Organizacional</label>
            <select name="uo" class="form-control">
                <option value="">Todos</option>
                @foreach($responsabilityCenters as $key => $responsabilityCenter)
                <option value="{{$responsabilityCenter->id}}" {{ (old('uo')==$responsabilityCenter->id)?'selected':'' }}>{{$responsabilityCenter->name}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-md-1">
            <label for="">&nbsp;</label>
            <button type="submit" class="form-control btn btn-primary"><i class="fas fa-search"></i></button>
        </fieldset>


        <fieldset class="form-group col-md-1">
            <label for="">&nbsp;</label>
            <button type="submit" class="btn btn-outline-success form-control" title="Descargar Excel" name="excel"><i class="fas fa-file-excel"></i></button>
        </fieldset>
    </div>

    <!-- @livewire('select-organizational-unit') -->

</form>

<hr>

@if(!empty($srs))
<h3 class="mb-3">Reporte de contratos <small>Cantidad de registros: {{ $total_srs }}</small></h3>
<table class="table table-sm table-bordered small" id="tabla_contrato">
    <tr>
        <th>Id Sol.</th>
        <th>Tipo</th>
        <th>Origen Financiamiento</th>
        <th>Rut</th>
        <th>Nombre</th>
        <th>Unidad Organizacional</th>
        
        <th>Inicio Contrato</th>
        <th>Término Contrato</th>
        <th>Fecha Solicitud</th>
        <th>Término de contrato</th>
    </tr>

    @foreach($srs as $sr)
    <tr>
        @if ($sr->fulfillment)
        @if($sr->fulfillment->fulfillmentitems->where('type','!=','Renuncia voluntaria')->count() > 0)


        <td>
        <a href="{{ route('rrhh.service-request.fulfillment.edit',$sr) }}" target="_blank">                    
            {{ $sr->id ?? '' }}
            </a>        
        </td>
        <td>{{ $sr->program_contract_type ?? '' }}</td>
        <td>{{ $sr->type ?? '' }}</td>
        <td nowrap>{{ $sr->id ? $sr->employee->runFormat(): '' }}</td>
        <td class="text-uppercase">{{$sr->employee->fullname?? ''}}</td>
        <td>{{ $sr->responsabilityCenter->name ?? '' }}</td>
        <td nowrap>{{ $sr->start_date ? $sr->start_date->format('d-m-Y'): '' }}</td>
        <td nowrap>{{ $sr->end_date ? $sr->end_date->format('d-m-Y'): '' }}</td>
        <td nowrap>{{ $sr->request_date ? $sr->request_date->format('d-m-Y'): '' }}</td>
        @endif
        @endif

    </tr>
    @endforeach
    
</table>

{{ $srs->appends(request()->query())->links() }}
@endif
@endsection