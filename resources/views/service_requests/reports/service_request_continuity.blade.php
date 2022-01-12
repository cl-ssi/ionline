@extends('layouts.app')

@section('title', 'Reporte de contrato')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte continuidad de contratos </h3>
@if(!empty($results))
<small>Cantidad de registros: {{ count($results) }}</small>
@endif

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.report.service-request-continuity') }}">
    <div class="form-row">
        <fieldset class="form-group col-md-3">
            <label for="for_from">Desde*</label>
            <input type="date" class="form-control" name="from" value="{{ $request->from }}" required>
        </fieldset>

        <fieldset class="form-group col-md-3">
            <label for="for_to">Hasta*</label>
            <input type="date" class="form-control" name="to" value="{{ $request->to }}" required>
        </fieldset>

        <fieldset class="form-group col-md-1">
            <label for="">&nbsp;</label>
            <button type="submit" class="form-control btn btn-primary"><i class="fas fa-search"></i></button>
        </fieldset>
    </div>
</form>

<hr>

@if(!empty($results))
<table class="table table-sm table-bordered small" id="tabla_contrato">
    <tr>
        <th>Funcionario</th>
        <th></th>
        <th></th>
    </tr>

    @foreach($results as $key => $result)
    <tr>
      <td>{{$key}}</td>
      @foreach($result as $key2 => $serviceRequest)
        <tr>
          <td></td>
          <td>
            <a href="{{ route('rrhh.service-request.edit',$serviceRequest) }}" target="_blank">
                {{ $serviceRequest->id ?? '' }}
            </a>
          </td>
          <td>{{$key2}}</td>
        </tr>
      @endforeach
    </tr>
    @endforeach

</table>
@endif

@endsection
