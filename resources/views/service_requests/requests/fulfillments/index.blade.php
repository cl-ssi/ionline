@extends('layouts.app')

@section('title', 'Cumplimiento solicitudes de contratación')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Cumplimiento solicitudes de contratación</h3>

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.fulfillment.index') }}">

    <div class="form-row">
        <fieldset class="form-group col-6 col-md">
            <label>Unidad</label>
            <select class="form-control" data-live-search="true" name="responsability_center_ou_id" data-size="5">
                <option value="">Todos</option>
                @foreach($responsabilityCenters as $key => $responsabilityCenter)
                  <option value="{{$responsabilityCenter->id}}" @if($responsabilityCenter->id == $request->responsability_center_ou_id) selected @endif>{{$responsabilityCenter->name}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md">
            <label>Tipo</label>
            <select class="form-control" data-live-search="true" name="program_contract_type" data-size="5">
                <option value="">Todos</option>
                <option value="Mensual" @if($request->program_contract_type == "Mensual") selected @endif>Mensual</option>
                <option value="Horas" @if($request->program_contract_type == "Horas") selected @endif>Horas</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md">
            <!-- <label>Estam.</label>
            <select class="form-control" data-live-search="true" name="estate" data-size="5">
                <option value="">Ninguno</option>
                <option value="Profesional Médico" @if($request->estate == "Profesional Médico") selected @endif>Profesional Médico</option>
                <option value="Profesional" @if($request->estate == "Profesional") selected @endif>Profesional</option>
                <option value="Técnico" @if($request->estate == "Técnico") selected @endif>Técnico</option>
                <option value="Administrativo" @if($request->estate == "Administrativo") selected @endif>Administrativo</option>
                <option value="Farmaceutico" @if($request->estate == "Farmaceutico") selected @endif>Farmaceutico</option>
                <option value="Odontólogo" @if($request->estate == "Odontólogo") selected @endif>Odontólogo</option>
                <option value="Bioquímico" @if($request->estate == "Bioquímico") selected @endif>Bioquímico</option>
                <option value="Auxiliar" @if($request->estate == "Auxiliar") selected @endif>Auxiliar</option>
            </select> -->
            <label>Profesión</label>
            <select class="form-control selectpicker" data-live-search="true" name="profession_id" data-size="5">
              <option value="">Todos</option>
              @foreach($professions as $key => $profession)
                <option value="{{$profession->id}}" @if($profession->id == $request->profession_id) selected @endif>{{$profession->name}}</option>
              @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md">
            <label>Establecimiento</label>
            <select class="form-control" data-live-search="true" name="establishment_id" data-size="5">
                <option value="">Todos</option>
                <option value="1" @if($request->establishment_id == "1") selected @endif>Hospital Ernesto Torres Galdames</option>
                <option value="12" @if($request->establishment_id == "12") selected @endif>Dr. Héctor Reyno G.</option>
                <option value="0" @if($request->establishment_id == "0") selected @endif>Dirección SSI</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-4 col-md-1">
            <label>ID</label>
            <input class="form-control" type="text" name="id" value="{{$request->id}}">
        </fieldset>

        <fieldset class="form-group col-4 col-md-1">
            <label>Profesional</label>
            <input class="form-control" type="text" name="name" value="{{$request->name}}">
        </fieldset>

        <fieldset class="form-group col-4 col-md-1">
            <label>&nbsp;</label>
            <button type="submit" class="form-control btn btn-primary"><i class="fas fa-search"></i></button>
        </fieldset>
    </div>
</form>

<hr>

    <div class="table-responsive">
    <table class="table table-bordered table-sm small">
    	<thead>
        <tr>
    			<th colspan="10"></th>
          <th></th>
    			<th colspan="3" class="text-center">Visados</th>
    		</tr>
    		<tr>
    			<th scope="col">Id</th>
          <th scope="col">Nro.Res.</th>
    			<th scope="col">Tipo</th>
          <th scope="col">T.Contrato</th>
          <th scope="col">C.Responsabilidad</th>
    			<th scope="col">F. Solicitud</th>
    			<th scope="col">Rut</th>
    			<th scope="col">Funcionario</th>
    			<th scope="col">F. Inicio</th>
    			<th scope="col">F. Término</th>
    			<!-- <th scope="col">Estado Solicitud</th> -->
    			<th scope="col">Acción</th>
          <th scope="col">Resp.</th>
          <th scope="col">RRHH</th>
          <th scope="col">Finanzas</th>
    		</tr>
    	</thead>
    	<tbody>
    	@foreach($serviceRequests->SortByDesc('id') as $serviceRequest)
    		<tr>
    			<td>{{ $serviceRequest->id }}</td>
          <td>{{ $serviceRequest->resolution_number }}</td>
    			<td>{{ $serviceRequest->type }}</td>
          <td>{{ $serviceRequest->program_contract_type }}</td>
          <td>{{ $serviceRequest->responsabilityCenter->name }}</td>
    			<td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->request_date)->format('d-m-Y') }}</td>
    			<td nowrap>{{ $serviceRequest->employee->runNotFormat() }}</td>
    			<td nowrap>{{ $serviceRequest->employee->getFullNameAttribute() }}</td>
    			<td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->start_date)->format('d-m-Y') }}</td>
    			<td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->end_date)->format('d-m-Y') }}</td>
    			<!-- <td>@if($serviceRequest->SignatureFlows->where('status','===',0)->count() > 0) Rechazada
              @elseif($serviceRequest->SignatureFlows->whereNull('status')->count() > 0) Pendiente
              @else Finalizada @endif</td> -->
    			<td nowrap class="text-center">
          @if($serviceRequest->program_contract_type == "Mensual")
    				<a href="{{ route('rrhh.service-request.fulfillment.edit',[$serviceRequest]) }}"
    					class="btn btn-sm btn-outline-secondary">
    					<span class="fas fa-edit" aria-hidden="true"></span>
    				</a>



          @endif

          @if($serviceRequest->program_contract_type == "Horas")
              <!-- @if($serviceRequest->SignatureFlows->where('status','===',0)->count() > 0)
                <a data-toggle="modal" class="btn btn-outline-secondary btn-sm" id="a_modal_flow_incomplete">
                <i class="fas fa-file" style="color:#B9B9B9"></i></a>

              @else

                  class="btn btn-outline-secondary btn-sm" target="_blank">
                <span class="fas fa-file" aria-hidden="true"></span></a>
              @endif -->
              <a href="{{ route('rrhh.service-request.fulfillment.edit',[$serviceRequest]) }}"
      					class="btn btn-sm btn-outline-secondary">
      					<span class="fas fa-edit" aria-hidden="true"></span>
      				</a>
          @endif

    			</td>

          <!-- mensual -->
          @if($serviceRequest->program_contract_type == "Mensual")
          <td nowrap class="text-center">
            <!-- @if($serviceRequest->Fulfillments->count() > 0)
              @if($serviceRequest->Fulfillments->whereNull('responsable_approver_id')->count() > 0)
                <i class="fas fa-circle" style="color:yellow"></i>
              @elseif($serviceRequest->Fulfillments->where('responsable_approbation',1)->count() > 0)
                <i class="fas fa-circle" style="color:green"></i>
              @elseif($serviceRequest->Fulfillments->where('responsable_approbation',0)->count() > 0)
                <i class="fas fa-times" style="color:red"></i>
              @endif
            @else
              <i class="far fa-circle" style="color:black"></i>
            @endif -->
            {{$serviceRequest->Fulfillments->whereNotNull('responsable_approver_id')->count()}} / {{$serviceRequest->Fulfillments->count()}}
    			</td>

          <td nowrap class="text-center">
            <!-- @if($serviceRequest->Fulfillments->count() > 0)
              @if($serviceRequest->Fulfillments->whereNull('rrhh_approver_id')->count() > 0)
                <i class="fas fa-circle" style="color:yellow"></i>
                @elseif($serviceRequest->Fulfillments->where('rrhh_approbation',1)->count() > 0)
                  <i class="fas fa-circle" style="color:green"></i>
                @elseif($serviceRequest->Fulfillments->where('rrhh_approbation',0)->count() > 0)
                  <i class="fas fa-times" style="color:red"></i>
              @endif
            @else
              <i class="far fa-circle" style="color:black"></i>
            @endif -->
            {{$serviceRequest->Fulfillments->whereNotNull('rrhh_approver_id')->count()}} / {{$serviceRequest->Fulfillments->count()}}
    			</td>

          <td nowrap class="text-center">
            <!-- @if($serviceRequest->Fulfillments->count() > 0)
              @if($serviceRequest->Fulfillments->whereNull('finances_approver_id')->count() > 0)
                <i class="fas fa-circle" style="color:yellow"></i>
                @elseif($serviceRequest->Fulfillments->where('finances_approbation',1)->count() > 0)
                  <i class="fas fa-circle" style="color:green"></i>
                @elseif($serviceRequest->Fulfillments->where('finances_approbation',0)->count() > 0)
                  <i class="fas fa-times" style="color:red"></i>
              @endif
            @else
              <i class="far fa-circle" style="color:black"></i>
            @endif -->
            {{$serviceRequest->Fulfillments->whereNotNull('finances_approver_id')->count()}} / {{$serviceRequest->Fulfillments->count()}}
    			</td>
          @endif

          <!-- x horas -->
          @if($serviceRequest->program_contract_type == "Horas")
            <!-- <td nowrap class="text-center">
              <i class="fas fa-circle" style="color:green"></i>
            </td>

            @if($serviceRequest->SignatureFlows->where('status','===',0)->count() > 0)
              <td colspan="2" class="text-center"><i class="fas fa-times" style="color:red"></i></td>
            @else
              <td nowrap class="text-center">
                @if($serviceRequest->SignatureFlows->where('ou_id',86)->count() > 0)
                  @if($serviceRequest->SignatureFlows->where('ou_id',86)->first()->status == NULL)
                    <i class="fas fa-circle" style="color:yellow"></i>
                  @elseif($serviceRequest->SignatureFlows->where('ou_id',86)->first()->status == 1)
                    <i class="fas fa-circle" style="color:green"></i>
                  @elseif($serviceRequest->SignatureFlows->where('ou_id',86)->first()->status == 0)
                    <i class="fas fa-times" style="color:red"></i>
                  @endif
                @endif
              </td>

              <td nowrap class="text-center">
                @if($serviceRequest->SignatureFlows->where('ou_id',111)->count() > 0)
                  @if($serviceRequest->SignatureFlows->where('ou_id',111)->first()->status == NULL)
                    <i class="fas fa-circle" style="color:yellow"></i>
                  @elseif($serviceRequest->SignatureFlows->where('ou_id',111)->first()->status == 1)
                    <i class="fas fa-circle" style="color:green"></i>
                  @elseif($serviceRequest->SignatureFlows->where('ou_id',111)->first()->status == 0)
                    <i class="fas fa-times" style="color:red"></i>
                  @endif
                @endif
              </td>
            @endif -->
            <td nowrap class="text-center" colspan="3">
              {{$serviceRequest->SignatureFlows->whereNotNull('status')->count()}} / {{$serviceRequest->SignatureFlows->count()}}
            </td>
          @endif
    		</tr>
    	@endforeach
    	</tbody>
    </table>
    </div>

    {{ $serviceRequests->links() }}

@endsection

@section('custom_js')o

@endsection
