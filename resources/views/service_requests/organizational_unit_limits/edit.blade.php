@extends('layouts.bt4.app')

@section('title', 'Editar tope por unidad organizacional')

@section('content')

@include('service_requests.partials.nav')

<h3>Editar tope por unidad</h3>

<form method="POST" action="{{ route('rrhh.service-request.organizational_unit_limits.update',$organizationalUnitLimit) }}">
	@csrf
	@method('PUT')

	<div class="form-row">

        <fieldset class="form-group col">
		    <label for="organizational_unit_id">Unidad organizacional</label>
		    <select name="organizational_unit_id" id="organizational_unit_id" class="form-control" required>
                @foreach($organizationalUnits as $organizationalUnit)
                    <option value="{{$organizationalUnit->id}}" @selected($organizationalUnitLimit->organizational_unit_id == $organizationalUnit->id)>{{$organizationalUnit->name}}</option>
                @endforeach
            </select>
		</fieldset>

		<fieldset class="form-group col">
		    <label for="max_value">Tope</label>
		    <input type="number" class="form-control" id="max_value" value="{{ $organizationalUnitLimit->max_value }}" name="max_value" required="required">
		</fieldset>

	</div>

	<button type="submit" class="btn btn-primary">Crear</button>
</form>
@endsection

@section('custom_js')

@endsection
