@extends('layouts.app')

@section('title', 'Solicitudes de Contratación')

@section('content')

  <h3>Listado de Solicitudes de Contratación de Servicio</h3>
  <br><hr>

    <div class="table-responsive">
    <table class="table table-bordered table-sm small">
    	<thead>
    		<tr>
    			<th scope="col">Id</th>
    			<th scope="col">Tipo</th>
          <th scope="col">T.Contrato</th>
    			<th scope="col">F. Solicitud</th>
    			<th scope="col">Rut</th>
    			<th scope="col">Funcionario</th>
    			<th scope="col">F. Inicio</th>
    			<th scope="col">F. Término</th>
    			<th scope="col">Estado Solicitud</th>
    			<th scope="col">Acción</th>
          <th scope="col">Estado</th>
    		</tr>
    	</thead>
    	<tbody>
    	@foreach($serviceRequests as $serviceRequest)
    		<tr>
    			<td>{{ $serviceRequest->id }}</td>
    			<td>{{ $serviceRequest->type }}</td>
          <td>{{ $serviceRequest->program_contract_type }}</td>
    			<td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->request_date)->format('d-m-Y') }}</td>
    			<td nowrap>{{ $serviceRequest->rut }}</td>
    			<td nowrap>{{ $serviceRequest->name }}</td>
    			<td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->start_date)->format('d-m-Y') }}</td>
    			<td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->end_date)->format('d-m-Y') }}</td>
    			<td>@if($serviceRequest->SignatureFlows->whereNull('status')->count() > 0) Pendiente	@else Finalizada @endif</td>
    			<td nowrap>
    				<a href="{{ route('rrhh.fulfillments.edit_fulfillment', $serviceRequest) }}"
    					class="btn btn-sm btn-outline-secondary">
    					<span class="fas fa-edit" aria-hidden="true"></span>
    				</a>
    			</td>
          <td nowrap>
            @if($serviceRequest->Fulfillments->count()>0)
              <i class="fas fa-circle" style="color:green"></i>
            @else
              <i class="far fa-circle" style="color:red"></i>
            @endif
    			</td>
    		</tr>
    	@endforeach
    	</tbody>
    </table>
    </div>

@endsection

@section('custom_js')

</script>

@endsection
