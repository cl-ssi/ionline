@extends('layouts.app')

@section('title', 'Editar Banda Ancha Movil')

@section('content')

<h3 class="mb-3">Editar Banda Ancha Móvil</h3>

<form method="POST" class="form-horizontal" action="{{ route('resources.wingle.update', $wingle) }}">
    @method('PUT')
	@csrf

    <fieldset class="form-group">
        <label for="forbrand">Marca</label>
        <input type="text" class="form-control" id="forbrand" placeholder="Marca" name="brand" required="" value="{{ $wingle->brand }}">
    </fieldset>

    <fieldset class="form-group">
        <label for="formodel">Modelo</label>
        <input type="text" class="form-control" id="formodel" placeholder="Ingrese el modelo" name="model" required="" value="{{ $wingle->model }}">
    </fieldset>

    <fieldset class="form-group">
        <label for="forcompany">Compañia</label>
        <input type="text" class="form-control" id="forcompany" placeholder="Ingrese la compañia" name="company" required="" value="{{ $wingle->company }}">
    </fieldset>

    <fieldset class="form-group">
        <label for="formei">IMEI</label>
        <input type="text" class="form-control" id="forimei" placeholder="" name="imei" required="" value="{{ $wingle->imei }}">
    </fieldset>

    <fieldset class="form-group">
        <label for="formpassword">Password Activación</label>
        <input type="text" class="form-control" id="forpassword" placeholder="contraseña" name="password" required="" value="{{ $wingle->password }}">
    </fieldset>

    <fieldset class="form-group">
		<button type="submit" class="btn btn-primary">
			<span class="fas fa-save" aria-hidden="true"></span> Actualizar</button>

		</form>

	    <a href="{{ route('resources.wingle.index') }}" class="btn btn-outline-secondary">Cancelar</a>

		<form method="POST" action="{{ route('resources.wingle.destroy', $wingle) }}" class="d-inline">
            @csrf
            @method('DELETE')
			<button class="btn btn-danger float-right"><span class="fas fa-trash" aria-hidden="true"></span> Eliminar</button>
		</form>

	</fieldset>

</form>

@endsection
