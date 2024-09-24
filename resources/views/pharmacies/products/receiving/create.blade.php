@extends('layouts.bt4.app')

@section('title', 'Crear nuevo ingreso')

@section('content')

@include('pharmacies.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h3>Nuevo Ingreso</h3>

<form method="POST" action="{{ route('pharmacies.products.receiving.store') }}">
	@csrf

	<div class="form-row">
        <fieldset class="form-group col-3">
            <label for="for_date">Fecha</label>
            <input type="date" class="form-control" id="for_date" name="date" required="required">
        </fieldset>

				<fieldset class="form-group col">
            <label for="for_origin">Origen</label>
						<select name="destiny_id" class="form-control selectpicker" data-live-search="true" required="">
							@foreach ($destines as $key => $destiny)
								<option value="{{$destiny->id}}">{{$destiny->name}}</option>
							@endforeach
						</select>
        </fieldset>
	</div>

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_note">Nota</label>
            <input type="text" class="form-control" id="for_note" placeholder="" name="notes">
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_order_number">Nro. Pedido</label>
            <input type="text" class="form-control" id="for_order_number" placeholder="" name="order_number">
        </fieldset>
    </div>

	<button type="submit" class="btn btn-primary">Crear</button>
</form>

@endsection

@section('custom_js')

<!--<link href="{{ asset('css/bootstrap-3.3.7.min.css') }}" rel="stylesheet" type="text/css"/>-->
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/show_hide_tab.js') }}"></script>

@endsection
