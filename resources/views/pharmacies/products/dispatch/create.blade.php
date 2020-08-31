@extends('layouts.app')

@section('title', 'Crear nuevo egreso')

@section('content')

@include('pharmacies.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h3>Nuevo Egreso</h3>

<form method="POST" action="{{ route('pharmacies.products.dispatch.store') }}">
	@csrf

	<div class="row">
        <fieldset class="form-group col-3">
            <label for="for_date">Fecha</label>
            <input type="date" class="form-control" id="for_date" name="date" required="required">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_origin">Destino</label>
						<select name="establishment_id" class="form-control selectpicker" data-live-search="true" required="">
							@foreach ($establishments as $key => $establishment)
								<option value="{{$establishment->id}}">{{$establishment->name}}</option>
							@endforeach
						</select>
        </fieldset>
	</div>

    <div class="row">
        <fieldset class="form-group col">
            <label for="for_note">Nota</label>
            <input type="text" class="form-control" id="for_note" placeholder="" name="notes" required="">
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
