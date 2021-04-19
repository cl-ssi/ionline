@extends('layouts.app')

@section('title', 'Reporte - Cumplimiento')

@section('content')

@include('service_requests.partials.nav')

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.report.compliance') }}">

    <div class="form-row">
        <fieldset class="form-group col-4 col-md-2">
            <label for="for_year">Estab</label>
            <select name="establishment" class="form-control">
                <option value=""></option>
                <option value="1">HETG</option>
                <option value="12">Reyno</option>
                <option value="38">SSI</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_rut">Rut/Nombre</label>
            <input name="rut" class="form-control" 
                placeholder="Run o nombre" value="{{ old('rut') }}" aucomplete="off">
            </input>
        </fieldset>

        <fieldset class="form-group col-4 col-md-1">
            <label for="for_year">Año</label>
            <select name="year" class="form-control">
                <option value=""></option>
                <option value="2020" @if($request->input('year')==2020) selected @endif>2020</option>
                <option value="2021" @if($request->input('year')==2021) selected @endif>2021</option>
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

        <fieldset class="form-group col-4 col-md-2">
            <label for="for_type">Tipo</label>
            <select name="type" class="form-control">
                <option value=""></option>
                <option value="Covid" @if($request->input('type')=='Covid') selected @endif>Covid</option>
                <option value="Suma Alzada" @if($request->input('type')=='Suma Alzada') selected @endif>Suma Alzada</option>
            </select>
        </fieldset>


        <fieldset class="form-group col-6 col-md-2">
            <label for="for_program_contract_type">Tipo de contrato</label>
            <select name="program_contract_type" class="form-control">
                <option value=""></option>
                <option value="Mensual" @if($request->input('program_contract_type')=='Mensual') selected @endif>Mensual</option>
                <option value="Horas" @if($request->input('program_contract_type')=='Horas') selected @endif>Horas</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-2 col-md-1">
            <label for="">&nbsp;</label>
            <button type="submit" class="form-control btn btn-primary"><i class="fas fa-search"></i></button>
        </fieldset>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="for_resolution" 
                    name="resolution" {{ (old('resolution') == true) ? 'checked':'' }}>
                <label class="form-check-label" for="for_resolution">Resolución</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="for_certificate" 
                    name="certificate" {{ (old('certificate') == true) ? 'checked':'' }}>
                <label class="form-check-label" for="for_certificate">Certificado</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="for_ok_responsable" 
                    name="ok_responsable" {{ (old('ok_responsable') == true) ? 'checked':'' }}>
                <label class="form-check-label" for="for_ok_responsable">Aprobado Responsable</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="for_ok_rrhh" 
                    name="ok_rrhh" {{ (old('ok_rrhh') == true) ? 'checked':'' }}>
                <label class="form-check-label" for="for_ok_rrhh">Aprobado RRHH</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="for_ok_finanzas" 
                    name="ok_finanzas" {{ (old('ok_finanzas') == true) ? 'checked':'' }}>
                <label class="form-check-label" for="for_ok_finanzas">Aprobado Finanzas</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="for_invoice" 
                    name="invoice" {{ (old('invoice') == true) ? 'checked':'' }}>
                <label class="form-check-label" for="for_invoice">Boleta</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="for_payed" 
                    name="payed" {{ (old('payed') == true) ? 'checked':'' }}>
                <label class="form-check-label" for="for_payed">Pagado</label>
            </div>
        </div>
    </div>

</form>

<hr>

<h3 class="mb-3">Reporte de cumplimiento</h3>

<div class="table-responsive">
    <table class="table table-sm table-bordered table-stripped">
        <tr>
            <th>Ct.</th>
            <th>Id Sol.</th>
            <th nowrap>Rut</th>
            <th>Nombre</th>
            <th>Año</th>
            <th>Mes</th>
            <th>Tipo</th>
            <th>Tipo de Contrato</th>
            <th>Hitos</th>
            <th></th>
        </tr>
        @foreach($fulfillments as $key => $fulfillment)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{$fulfillment->servicerequest->id?? ''}}
                <span class="small">({{$fulfillment->id}})</span>
            </td>
            <td>{{$fulfillment->servicerequest?$fulfillment->servicerequest->employee->runFormat(): ''}}</td>
            <td class="text-uppercase">{{$fulfillment->servicerequest->employee->fullname?? ''}}</td>
            <td>{{$fulfillment->year}}</td>
            <td>{{$fulfillment->month}}</td>
            <td>{{$fulfillment->servicerequest->type?? ''}}</td>
            <td>{{$fulfillment->servicerequest->program_contract_type?? ''}}</td>
            <td>
                <i title="Resolución" class="fas fa-file-signature 
                    {{ ($fulfillment->serviceRequest->has_resolution_file)?'text-primary':'text-secondary'}}"></i>
                
                <i title="Certificado" class="fas fa-certificate 
                    {{ ($fulfillment->signatures_file_id)?'text-primary':'text-secondary'}}"></i>
                
                <i title="Aprobado Responsable" class="fas fa-chess-king 
                    {{ ($fulfillment->responsable_approbation)?'text-primary':'text-secondary'}}"></i>
                
                <i title="Aprobado RRHH" class="fas fa-user-shield 
                    {{ ($fulfillment->rrhh_approbation)?'text-primary':'text-secondary'}}"></i>
                
                <i title="Aprobado Finanzas" class="fas fa-piggy-bank 
                    {{ ($fulfillment->finances_approbation)?'text-primary':'text-secondary'}}"></i>

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