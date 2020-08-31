@extends('layouts.app')

@section('title', 'Crear nueva solicitud ayuda técnica')

@section('content')

@include('pharmacies.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

<h3>Nueva entrega ayuda técnica</h3><br>

<form method="POST" action="{{ route('pharmacies.products.deliver.store') }}">
	@csrf

	<div class="row">
		<fieldset class="form-group col">
			<label for="from">Origen solicitud</label>
			<input type="text" class="form-control" id="for_from" name="establishment_id" value="{{$products_by_establishment->first()->establishments->first()->name}}" disabled>
			<input type="hidden" class="form-control" id="for_from" name="establishment_id" value="{{$products_by_establishment->first()->establishments->first()->id}}" required="">
		</fieldset>
		<fieldset class="form-group col">
            <label for="for_invoice">Folio SIGGES</label>
            <input type="text" class="form-control" id="for_invoice" name="invoice" required="">
        </fieldset>
		<fieldset class="form-group col-3">
            <label for="for_request_date">Fecha solicitud</label>
            <input type="date" class="form-control" id="for_request_date" name="request_date" required="required">
        </fieldset>
		<fieldset class="form-group col-3">
            <label for="for_due_date">Fecha vencimiento</label>
            <input type="date" class="form-control" id="for_due_date" name="due_date">
        </fieldset>
	</div>

	<div class="row">
        <fieldset class="form-group col-2">
            <label for="for_patient_rut">RUT paciente</label>
            <input type="text" class="form-control" id="for_patient_rut" name="patient_rut" placeholder="Ej: 11111111-1" required="">
        </fieldset>
        <fieldset class="form-group col">
            <label for="for_patient_name">Nombre y Apellido paciente</label>
            <input type="text" class="form-control" id="for_patient_name" name="patient_name" required="">
        </fieldset>
        <fieldset class="form-group col-1">
            <label for="for_age">Edad</label>
            <input type="text" class="form-control" id="for_age" name="age" required="">
		</fieldset>
		<fieldset class="form-group col-3">
			<label for="for_request_type">Tipo solicitud</label>
			<select name="request_type" id="request_type" class="form-control selectpicker" data-live-search="true" required="">
				<option value="GES mayor de 65 años">GES mayor de 65 años</option>
				<option value="Piloto GES">Piloto GES</option>
				<option value="Decreto 22">Decreto 22</option>
			</select>
		</fieldset>
    </div>

	<div class="row">
		<fieldset class="form-group col-4">
			<label for="product">Ayuda técnica</label>
			<select name="product_id" class="form-control selectpicker" data-live-search="true" required="">
				@foreach($products_by_establishment as $product)
				<option value="{{$product->id}}" data-subtext="Stock: {{$product->quantity}}">{{$product->name}}</option>
				@endforeach
			</select>
		</fieldset>
		<fieldset class="form-group col-1">
            <label for="for_quantity">Cantidad</label>
            <input type="number" class="form-control" id="for_quantity" min="1" max="1" name="quantity" required="" value="1">
		</fieldset>
		<fieldset class="form-group col">
            <label for="for_diagnosis">Diagnostico</label>
            <input type="text" class="form-control" id="for_diagnosis" name="diagnosis" required="">
        </fieldset>
        <fieldset class="form-group col">
            <label for="for_doctor_name">Nombre médico</label>
            <input type="text" class="form-control" id="for_doctor_name" name="doctor_name" required="">
        </fieldset>
    </div>

	<button type="submit" class="btn btn-primary">Guardar</button>
</form>

@endsection

@section('custom_js')

<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/show_hide_tab.js') }}"></script>
<script>
	$(document).ready(function() {

		$('.popover-item').popover({
			html: true,
			trigger: 'hover',
			content: function() {
				return $(this).next('.popover-list-content').html();
			}
		});

		$("input[name=age]").change(function() {
			var age = $(this).val();
			$("#request_type option").prop("disabled", false);
			if(age >= 65){
				$("#request_type option[value='Piloto GES']").attr("disabled", true);
				$("#request_type option[value='Decreto 22']").attr("disabled", true);
				$("#request_type option[value='GES mayor de 65 años']").attr("selected", true);
			}else{
				$("#request_type option[value='GES mayor de 65 años']").attr("disabled", true);
				$("#request_type option[value='Piloto GES']").attr("selected", true);
			}
			$("#request_type").selectpicker('refresh');
		});

		$('select[name=product_id]').on('change', function () {
			var product_id = $(this).val(); // 1184: Bastón con codera
			product_id == 1184 ? $('input[name=quantity]').prop('max', 2) : $('input[name=quantity]').prop('max', 1);
		});
	});
</script>

@endsection