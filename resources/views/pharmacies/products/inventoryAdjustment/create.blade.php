@extends('layouts.bt4.app')

@section('title', 'Crear nuevo ajuste de inventario')

@section('content')

@include('pharmacies.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h3>Nuevo Ajuste de Inventario</h3>

<form method="POST" action="{{ route('pharmacies.products.inventory_adjustments.store') }}">
	@csrf

	<div class="form-row">
        <fieldset class="form-group col-3">
            <label for="for_date">Fecha</label>
            <input type="date" class="form-control" id="for_date" name="date" required="required">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_origin">Tipo de ajuste</label>
            <select name="inventory_adjustment_type_id" class="form-control selectpicker" data-live-search="true" required>
                <option value=""></option>
                @foreach($inventoryAdjustmentTypes as $inventoryAdjustmentType)
                    <option value="{{$inventoryAdjustmentType->id}}">{{$inventoryAdjustmentType->name}}</option>
                @endforeach
            </select>
        </fieldset>
        
        <fieldset class="form-group col">
            <label for="for_note">Observación</label>
            <input type="text" class="form-control" id="for_note" placeholder="" name="notes">
        </fieldset>
	</div>

	<button type="submit" class="btn btn-primary">Guardar</button>
</form>

@endsection

@section('custom_js')

<!--<link href="{{ asset('css/bootstrap-3.3.7.min.css') }}" rel="stylesheet" type="text/css"/>-->
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/show_hide_tab.js') }}"></script>

@endsection
