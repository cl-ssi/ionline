@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')

<h3>Nuevo usuario</h3>

@can('Users: create')
<form method="POST" action="{{ route('rrhh.users.store') }}" enctype="multipart/form-data">
	{{ csrf_field() }}

	<div class="row">
		<div class="col-8 col-md-4">

			<fieldset class="form-group">
				<label for="formGroupIDInput">ID</label>
				<input type="number" class="form-control" id="formGroupIDInput" name="id" required="required" min="6" max="99999999" step="">
			</fieldset>

		</div>
		<div class="col-4 col-md-2">

			<fieldset class="form-group">
				<label for="formGroupDVInput">DV</label>
				<input type="text" class="form-control" id="formGroupDVInput" name="dv" required="required" title="Digito verificador">
			</fieldset>

		</div>
	</div>

	<fieldset class="form-group">
		<label for="formGroupNameInput">Nombre</label>
		<input type="text" class="form-control" id="formGroupNameInput" placeholder="Nombre" name="name" required="required">
	</fieldset>

	<div class="form-group">
		<label for="name">Apellido Paterno</label>
		<input type="text" class="form-control" name="fathers_family" required="required">
	</div>

	<div class="form-group">
		<label for="name">Apellido Materno</label>
		<input type="text" class="form-control" name="mothers_family" required="required">
	</div>

	<fieldset class="form-group">
		<label for="formGroupEmailInput">Email</label>
		<input type="email" class="form-control" id="formGroupEmailInput" placeholder="Email" name="email" required="required">
	</fieldset>
<!--
	<fieldset class="form-group">
		<label for="forPhoto">Foto</label>
		<div class="custom-file">
			<input type="file" class="custom-file-input" id="customFile" name="photo" lang="es">
			<label class="custom-file-label" for="customFile">Seleccionar Foto</label>
		</div>
	</fieldset>
-->

	<fieldset class="form-group">
		<label for="forOrganizationalUnit">Unidad Organizacional</label>
		<select class="custom-select" id="forOrganizationalUnit" name="organizationalunit">
			<option></option>
			<option value="{{ $ouRoot->id }}">
            {{ $ouRoot->name }}
            </option>
            @foreach($ouRoot->childs as $child_level_1)
                <option value="{{ $child_level_1->id }}">
                &nbsp;&nbsp;&nbsp;
                {{ $child_level_1->name }}
                </option>
                @foreach($child_level_1->childs as $child_level_2)
                    <option value="{{ $child_level_2->id }}">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    {{ $child_level_2->name }}
                    </option>
                    @foreach($child_level_2->childs as $child_level_3)
                        <option value="{{ $child_level_3->id }}">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{ $child_level_3->name }}
                        </option>
                    @endforeach
                @endforeach
            @endforeach
		</select>
	</fieldset>

	<fieldset class="form-group">
		<label for="forPosition">Cargo/Funcion</label>
		<input type="text" class="form-control" id="forPosition" placeholder="Cargo/Funcion" name="position">
	</fieldset>

	<div class="row">
		<div class="col-8 col-md-4">
			<fieldset class="form-group">
				<label for="forbirthday">Fecha Nacimiento</label>
				<input type="date" class="form-control" id="forbirthday" name="birthday">
			</fieldset>
		</div>
	</div>

	<button type="submit" class="btn btn-primary">Crear</button>

</form>
@endcan

@endsection
