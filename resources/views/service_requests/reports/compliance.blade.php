@extends('layouts.app')

@section('title', 'Reporte - Cumplimiento')

@section('content')

@include('service_requests.partials.nav')

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.report.compliance') }}">

    <div class="form-row">
        <fieldset class="form-group col-6 col-md-6">
            <label for="for_rut">Rut</label>
            <input name="rut" class="form-control" placeholder="rut sin digito verificador ni punto ej: 18006504" @if($request->input('rut')) value="{{$request->input('rut')}}" @endif >
            </input>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-2 col-md-2">
            <label for="for_year">Año</label>
            <select name="year" class="form-control">
                <option value=""></option>
                <option value="2020" @if($request->input('year')==2020) selected @endif>2020</option>
                <option value="2021" @if($request->input('year')==2021) selected @endif>2021</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-2 col-md-2">
            <label for="for_month">Mes</label>
            <select name="month" class="form-control">
                <option value=""></option>
                <option value="1" @if($request->input('month')==1) selected @endif>Enero</option>
                <option value="2" @if($request->input('month')==2) selected @endif>Febrero</option>
                <option value="3" @if($request->input('month')==3) selected @endif>Marzo</option>
                <option value="4" @if($request->input('month')==4) selected @endif>Abril</option>
                <option value="5" @if($request->input('month')==5) selected @endif>Mayo</option>
                <option value="6" @if($request->input('month')==6) selected @endif>Junio</option>
                <option value="7" @if($request->input('month')==7) selected @endif>Julio</option>
                <option value="8" @if($request->input('month')==8) selected @endif>Agosto</option>
                <option value="9" @if($request->input('month')==9) selected @endif>Septiembre</option>
                <option value="10" @if($request->input('month')==10) selected @endif>Octubre</option>
                <option value="11" @if($request->input('month')==11) selected @endif>Noviembre</option>
                <option value="12" @if($request->input('month')==12) selected @endif>Diciembre</option>

            </select>
        </fieldset>

        <fieldset class="form-group col-2 col-md-2">
            <label for="for_type">Tipo</label>
            <select name="type" class="form-control">
                <option value=""></option>
                <option value="Covid" @if($request->input('type')=='Covid') selected @endif>Covid</option>
                <option value="Suma Alzada" @if($request->input('type')=='Suma Alzada') selected @endif>Suma Alzada</option>
            </select>
        </fieldset>


        <fieldset class="form-group col-2 col-md-2">
            <label for="for_program_contract_type">Tipo de contrato</label>
            <select name="program_contract_type" class="form-control">
                <option value=""></option>
                <option value="Mensual" @if($request->input('program_contract_type')=='Mensual') selected @endif>Mensual</option>
                <option value="Horas" @if($request->input('program_contract_type')=='Horas') selected @endif>Horas</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-2 col-md-2">
            <label for="for_program_contract_type">Pagado/No Pagado</label>
            <select name="payment_date" class="form-control">
                <option value=""></option>
                <option value="P" @if($request->input('payment_date')=='P') selected @endif>Pagado</option>
                <option value="SP" @if($request->input('payment_date')=='SP')) selected @endif>No Pagado</option>
            </select>
        </fieldset>
    </div>
    <div class="form-row">
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
    </div>
</form>

<hr>

<h3 class="mb-3">Reporte de Cumplimiento</h3>


<table class="table table-sm table-bordered table-stripped">
    <tr>

        <th>Id Sol.</th>
        <th class="small">Id Cump.</th>
        <th nowrap>Rut</th>
        <th>Nombre</th>
        <th>Año</th>
        <th>Mes</th>
        <th>Tipo</th>
        <th>Tipo de Contrato</th>
        <th>Pago</th>
        <th></th>
    </tr>
    @foreach($fulfillments as $fulfillment)
    <tr>
        <td>{{$fulfillment->servicerequest->id?? ''}}</td>
        <td class="small">{{$fulfillment->id}}</td>
        <td>{{$fulfillment->servicerequest?$fulfillment->servicerequest->employee->runFormat(): ''}}</td>
        <td>{{$fulfillment->servicerequest->employee->fullname?? ''}}</td>
        <td>{{$fulfillment->year}}</td>
        <td>{{$fulfillment->month}}</td>
        <td>{{$fulfillment->servicerequest->type?? ''}}</td>
        <td>{{$fulfillment->servicerequest->program_contract_type?? ''}}</td>
        <td>
            @if($fulfillment->payment_date)
            PAGADO
            @else
            NO PAGADO
            @endif
        </td>
        <td>
            @if($fulfillment->servicerequest)
            <a href="{{ route('rrhh.service-request.fulfillment.edit',$fulfillment->servicerequest) }}" title="Editar">
                <span class="fas fa-edit" aria-hidden="true"></span>
            </a>
            @endif
        </td>

    </tr>

    @endforeach
</table>
{{ $fulfillments->appends(request()->query())->links() }}




@endsection

@section('custom_js')


@endsection