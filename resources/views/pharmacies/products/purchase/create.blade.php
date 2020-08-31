@extends('layouts.app')

@section('title', 'Crear nueva compra')

@section('content')

@include('pharmacies.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h3>Nueva compra</h3>

<form method="POST" action="{{ route('pharmacies.products.purchase.store') }}">
	@csrf

		<div class="row">
      <fieldset class="form-group col-3">
          <label for="for_date">Fecha</label>
          <input type="date" class="form-control" id="for_date" name="date" required="required">
      </fieldset>

      <fieldset class="form-group col">
          <label for="for_origin">Proveedor</label>
					<select name="supplier_id" class="form-control selectpicker" data-live-search="true" required="">
						@foreach ($suppliers as $key => $supplier)
							<option value="{{$supplier->id}}">{{$supplier->name}}</option>
						@endforeach
					</select>
      </fieldset>
		</div>

		<div class="row">
			<fieldset class="form-group col-2">
					<label for="for_text">OC</label>
					<input type="text" class="form-control" id="for_text" placeholder="" name="purchase_order" required="">
			</fieldset>
			<fieldset class="form-group col-2">
					<label for="for_text">Año</label>
					<input type="text" class="form-control" id="for_text" placeholder="" name="purchase_order_dato">
			</fieldset>
			<fieldset class="form-group col-4">
          <label for="for_date">Fecha OC</label>
          <input type="date" class="form-control" id="for_date" name="purchase_order_date" required="required">
      </fieldset>
			<fieldset class="form-group col-4">
					<label for="for_text">Monto total neto</label>
					<input type="number" class="form-control" id="for_text" placeholder="" name="purchase_order_amount" required="">
			</fieldset>
		</div>

		<div class="row">
			<fieldset class="form-group col-4">
					<label for="for_text">Guía</label>
					<input type="number" class="form-control" id="for_text" name="despatch_guide">
			</fieldset>
			<fieldset class="form-group col-4">
					<label for="for_text">Factura</label>
					<input type="number" class="form-control" id="for_text" name="invoice">
			</fieldset>
			<fieldset class="form-group col-4">
          <label for="for_text">Fecha Doc.</label>
          <input type="date" class="form-control" id="for_text" name="invoice_date">
      </fieldset>
		</div>

    <div class="row">
      <fieldset class="form-group col">
          <label for="for_note">Nota</label>
          <input type="text" class="form-control" id="for_note" placeholder="" name="notes" required="">
      </fieldset>

			<!--<fieldset class="form-group col">
          <label for="for_note">Contenido</label>
          <input type="text" class="form-control" id="for_note" placeholder="" name="content" required="">
      </fieldset>-->
    </div>

		<div class="row">
      <!--<fieldset class="form-group col-3">
          <label for="for_note">Acta recep.</label>
          <input type="text" class="form-control" id="for_note" placeholder="" name="acceptance_certificate" required="">
      </fieldset>-->

			<fieldset class="form-group col">
          <label for="for_note">Destino</label>
          <input type="text" class="form-control" id="for_note" placeholder="" name="destination" required="">
      </fieldset>

			<fieldset class="form-group col">
          <label for="for_note">Fondos</label>
          <input type="text" class="form-control" id="for_note" placeholder="" name="from" required="">
      </fieldset>
    </div>

		<!--<div class="row">
      <fieldset class="form-group col-3">
      </fieldset>

			<fieldset class="form-group col">
          <label for="for_note">Fondos</label>
          <input type="text" class="form-control" id="for_note" placeholder="" name="from" required="">
      </fieldset>
    </div>-->

	<button type="submit" class="btn btn-primary">Crear</button>
</form>

@endsection

@section('custom_js')

<!--<link href="{{ asset('css/bootstrap-3.3.7.min.css') }}" rel="stylesheet" type="text/css"/>-->
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/show_hide_tab.js') }}"></script>

@endsection
