@extends('layouts.app')

@section('title', 'Actualizar stock por establecimiento')

@section('content')

@include('pharmacies.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

<h3>Actualizar stock para <form action="{{route('pharmacies.products.transfer.edit', $filter)}}" class="d-inline">
			<select name="filter" onchange="this.form.submit()" class="selectpicker establishment" data-live-search="true" data-width="fit" data-style="btn btn-link">
				@foreach ($establishments as $establishment)
				<option value="{{$establishment->id}}" {{$establishment->id == $filter ? 'selected' : ''}}>{{$establishment->name}}</option>
				@endforeach
			</select>
		</form></h3><br>

<form method="POST" action="{{ route('pharmacies.products.transfer.update', $filter) }}">
	@csrf
	@method('PUT')
	<div class="form-row">
        <div class="form-group col-md-4">
            <label for="ayuda_tecnica"><b>Ayuda técnica</b></label>
        </div>
        <div class="form-group col-md-2">
            <label for="stock_actual"><b>Actual</b></label>
        </div>
        <div class="form-group col-md-2">
            <label for="stock_critico"><b>Crítico</b></label>
		</div>
	</div>
	@foreach($stocks as $product)
	<div class="row">
		<fieldset class="form-group col-md-4">
			<input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$product->name}}">
			<input type="hidden" name="product_id[]" value="{{$product->id}}">
		</fieldset>
		<fieldset class="form-group col-md-2">
			<input type="number" class="form-control" name="stock[]" min="0" required="" value="{{$product->stock}}">
		</fieldset>
		<fieldset class="form-group col-md-2">
			<input type="number" class="form-control" name="critic_stock[]" min="0" required="" value="{{$product->critic_stock}}">
		</fieldset>
	</div>
	@endforeach
	<a class="btn btn-outline-primary" href="{{route('pharmacies.products.transfer.index')}}" role="button">Volver</a>
	<button type="submit" class="btn btn-primary">Guardar</button>
</form>

@endsection

@section('custom_js')

<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/show_hide_tab.js') }}"></script>

@endsection