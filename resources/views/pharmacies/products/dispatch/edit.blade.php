@extends('layouts.bt4.app')

@section('title', 'Editar egreso')

@section('content')

@include('pharmacies.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h3>Editar Egreso</h3>

<form method="POST" action="{{ route('pharmacies.products.dispatch.update',$dispatch) }}">
  @method('PUT')
	@csrf

<div class="form-row">
      <fieldset class="form-group col-3">
          <label for="for_date">Fecha</label>
          <input type="date" class="form-control" id="for_date" name="date" required="required" value="{{$dispatch->date->format('Y-m-d')}}">
      </fieldset>

      <fieldset class="form-group col">
          <label for="for_origin">Destino</label>
          <select name="destiny_id" class="form-control selectpicker" data-live-search="true">
            <option value=""></option>
            @foreach ($destines as $key => $destiny)
              <option value="{{$destiny->id}}" @if ($dispatch->destiny_id == $destiny->id)
                selected
              @endif>{{$destiny->name}}</option>
            @endforeach
          </select>
      </fieldset>

        <fieldset class="form-group col">
            <label for="for_origin">Receptor</label>
            @livewire('search-select-user', ['selected_id' => 'receiver_id',
                                            'user' => $dispatch->receiver])
        </fieldset>
</div>

<div class="form-row">
    <fieldset class="form-group col">
        <label for="for_note">Nota</label>
        <input type="text" class="form-control" id="for_note" placeholder="" name="notes" value="{{$dispatch->notes}}">
    </fieldset>
</div>

<button type="submit" class="btn btn-primary">Guardar</button>
</form>

<hr />

@include('pharmacies.products.dispatchitem.create')

@if($dispatch->dispatchItems->count() > 0)
  <div class="form-row">
      <fieldset class="form-group col">
      </fieldset>
      <fieldset class="form-group col-3">
          <form method="GET" action="{{ route('pharmacies.products.dispatch.sendEmailValidation',$dispatch) }}">
            <button type="submit" class="form-control btn btn-warning">Enviar correo</button>
          </form>
      </fieldset>
      <fieldset class="form-group col-3">
          <form method="GET" action="{{ route('pharmacies.products.dispatch.storePrivateVerification',$dispatch) }}">
            <button type="submit" class="form-control btn btn-success">Confirmar recepción</button>
          </form>
      </fieldset>
  </div>
@endif

@if($dispatch->verificationMailings->count() > 0)
<div class="table-responsive">
	<table class="table table-striped table-sm" id="tabla_dispatch">
		<thead>
			<tr>
				<th scope="col">Estado</th>
				<th scope="col">Observación remitente</th>
        <th scope="col">F.Envío</th>
        <th scope="col">Observación destinatario</th>
        <th scope="col">F.Confirmación</th>
			</tr>
		</thead>
		<tbody>
      @foreach($dispatch->verificationMailings as $verificationMailings)
        <tr>
          <td>{{$verificationMailings->status}}</td>
          <td>{{$verificationMailings->sender_observation}}</td>
          <td>{{$verificationMailings->delivery_date}}</td>
          <td>{{$verificationMailings->receiver_observation}}</td>
          <td>{{$verificationMailings->confirmation_date}}</td>
        </tr>
      @endforeach
		</tbody>
	</table>
</div>
@endif



@endsection

@section('custom_js')

<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/show_hide_tab.js') }}"></script>

  <script>
    $( document ).ready(function() {
      document.getElementById("for_barcode").focus();
    });

  </script>

@endsection
