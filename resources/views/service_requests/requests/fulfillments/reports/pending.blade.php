@extends('layouts.app')

@section('title', 'Cumplimiento')

@section('content')

@include('service_requests.partials.nav')

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.report.fulfillment-pending',$who) }}">

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-4">
            <label for="for_establishment_id">Establecimiento</label>
            <select name="establishment" class="form-control" id="for_establishment_id">
                <option value="">Seleccionar</option>
                @foreach($establishments as $establishment)
                <option value="{{$establishment->id}}" @if(old('establishment') == $establishment->id) selected @endif >{{$establishment->name}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-4 col-md-5">
            <label for="for_establishment_id">Unidad</label>
            <select name="responsability_center" class="form-control" id="for_responsability_center">
                <option value="">Seleccionar</option>
                @foreach($responsabilityCenters as $responsabilityCenter)
                <option value="{{$responsabilityCenter->id}}" @if(old('responsability_center') == $responsabilityCenter->id) selected @endif >{{$responsabilityCenter->name}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-4 col-md-1">
            <label for="for_year">Año</label>
            <select name="year" class="form-control">
                <option value=""></option>
                <option value="2020" @if($request->input('year')==2020) selected @endif>2020</option>
                <option value="2021" @if($request->input('year')==2021) selected @endif>2021</option>
                <option value="2022" @if($request->input('year')==2022) selected @endif>2022</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-4 col-md-2">
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
    </div>

    <div class="form-row">
        <fieldset class="form-group col-6 col-md-3">
            <label for="for_type">Origen Financiacion</label>
            <select name="type" class="form-control">
                <option value=""></option>
                <option value="Covid" @if($request->input('type')=='Covid') selected @endif>Covid</option>
                <option value="Suma Alzada" @if($request->input('type')=='Suma Alzada') selected @endif>Suma Alzada</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-3">
            <label for="for_program_contract_type">Tipo de contrato</label>
            <select name="program_contract_type" class="form-control">
                <option value=""></option>
                <option value="Mensual" @if($request->input('program_contract_type')=='Mensual') selected @endif>Mensual</option>
                <option value="Horas" @if($request->input('program_contract_type')=='Horas') selected @endif>Horas</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-3 col-md-1">
            <label for="for_program_contract_type">ID</label>
            <input class="form-control" type="text" name="sr_id" value="{{ old('sr_id') }}">
        </fieldset>

        <fieldset class="form-group col-7 col-md-4">
            <label for="for_rut">Rut (sin dv) o nombre</label>
            <input name="rut" class="form-control" placeholder="Run o nombre" value="{{ old('rut') }}" aucomplete="off">
            </input>
        </fieldset>

        <fieldset class="form-group col-2 col-md-1">
            <label>&nbsp;</label>
            <button type="submit" class="form-control btn btn-primary"><i class="fas fa-search"></i></button>
        </fieldset>
    </div>
</form>

<hr>

<h3 class="mb-3">Cumplimientos pendientes por aprobar de {{$who}}</h3>

<div class="table-responsive">
    <table class="table table-sm table-bordered table-stripped">
        <tr>

            <th>Id Sol.</th>
            <th>C.Responsabilidad</th>
            <th nowrap>Rut</th>
            <th>Nombre</th>
            <th>Periodo</th>
            <th>Tipo</th>
            <th>Tipo de Contrato</th>
            <th>Hitos</th>
            <th></th>
        </tr>

        @foreach($fulfillments as $fulfillment)
        @if($periodo != $fulfillment->month.'-'.$fulfillment->year)
        @php $periodo= $fulfillment->month.'-'.$fulfillment->year; @endphp
        <tr>
            <td colspan="11">
                <h3>Periodo {{ $periodo }}</h3>
            </td>
        </tr>
        @endif
        <tr>
            <td>{{$fulfillment->servicerequest->id?? ''}}
                <span class="small">({{$fulfillment->id}})</span>
            </td>
            <td>{{$fulfillment->servicerequest->responsabilityCenter->name?? ''}}</td>
            <td>{{$fulfillment->servicerequest?$fulfillment->servicerequest->employee->runFormat(): ''}}</td>
            <td>{{$fulfillment->servicerequest->employee->fullName ?? ''}}</td>
            <td>{{$fulfillment->year}} - {{$fulfillment->month}}</td>
            <td>{{$fulfillment->servicerequest->type?? ''}}</td>
            <td>{{$fulfillment->servicerequest->program_contract_type?? ''}}</td>
            <td>
                <i title="Contrato" class="fas fa-file-signature
                    {{ ($fulfillment->serviceRequest->has_resolution_file)?'text-primary':'text-secondary'}}"></i>
                <i title="Certificado" class="fas fa-certificate
                    {{ ($fulfillment->signatures_file_id)?'text-primary':'text-secondary'}}"></i>
                <i title="Boleta" class="fas fa-file-invoice-dollar
                    {{ ($fulfillment->has_invoice_file)?'text-primary':'text-secondary'}}"></i>
                <i title="Pago" class="fas fa-money-bill
                    {{ ($fulfillment->payment_date)?'text-primary':'text-secondary'}}"></i>
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

</div>


@endsection

@section('custom_js')


@endsection
