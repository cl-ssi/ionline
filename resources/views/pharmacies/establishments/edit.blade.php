@extends('layouts.app')

@section('title', 'Editar Establecimiento')

@section('content')

@include('pharmacies.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

<form method="POST" action="{{ route('pharmacies.establishments.update',$establishment) }}">
	@csrf
	@method('PUT')

	<div class="row">

		<fieldset class="form-group col">
		    <label for="for_name">Nombre</label>
		    <input type="text" class="form-control" id="for_name"
				value="{{ $establishment->name }}" name="name" required="required">
		</fieldset>
	</div>
	<div class="row">
	<fieldset class="form-group col">
			<label for="users">Usuarios</label>
			<select name="users_id[]" class="form-control selectpicker" multiple data-live-search="true">
				@foreach($users as $user)
				<option value="{{$user->id}}" @if(in_array($user->id, $users_selected)) selected @endif>{{$user->fullName}}</option>
				@endforeach
			</select>
		</fieldset>
	</div>

	<button type="submit" class="btn btn-primary">Guardar</button>
</form>
@endsection

@section('custom_js')
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/show_hide_tab.js') }}"></script>
@endsection
