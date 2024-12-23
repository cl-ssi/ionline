@extends('layouts.bt4.app')

@section('title', 'Modificar flujo de firmas')

@section('content')

@include('service_requests.partials.nav')

<h3>Modificar flujo de firmas</h3><br>

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.change_signature_flow_view') }}">
  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text">Id</span>
    </div>
    <input type="text" name="id" value="{{$request->id}}">
    <div class="input-group-append">
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
    </div>
  </div>

</form>

<div class="row">
    <fieldset class="form-group col-12">
      @if($serviceRequests)
        <table class="table table-sm table-bordered">
          @foreach($serviceRequests->signatureFlows->where('status','<>',2) as $key => $signatureFlow)
            <tr>
              <form method="POST" enctype="multipart/form-data" action="{{ route('rrhh.service-request.change_signature_flow') }}">
              @csrf
                <input type="hidden" name="signature_flow_id" value="{{$signatureFlow->id}}">
                <td>{{$signatureFlow->responsable_id}}</td>
                <td>{{$signatureFlow->sign_position}}</td>
                <td>{{$signatureFlow->user->fullName}}</td>
                <td><i class="fas fa-sign-in-alt"></i></td>
                <td>
                  <select class="form-control selectpicker" name="user_id" data-live-search="true" data-size="5" required>
                      <option value=""></option>
                      @foreach($users as $key => $user)
                      <option value="{{$user->id}}">{{$user->fullName}}</option>
                      @endforeach
                  </select>
                </td>
                <td><button type="submit" class="btn btn-primary">Cambiar usuario</button>
                </td>
              </form>

              <form method="POST" enctype="multipart/form-data" action="{{ route('rrhh.service-request.delete_signature_flow') }}">
              @csrf
                <input type="hidden" name="signature_flow_id" value="{{$signatureFlow->id}}">
  							<td><button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro/a de eliminar este visador?');">Eliminar usuario</button>
  						</form>

            </tr>
          @endforeach
        </table>
      @endif
    </fieldset>
</div>

@endsection

@section('custom_js')

<script>

</script>

@endsection
