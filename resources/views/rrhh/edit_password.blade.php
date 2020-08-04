@extends('layouts.app')

@section('title', 'Cambiar Password')

@section('content')

<div class="row justify-content-md-center">

    <div class="col-md-auto">

		<h3>Cambiar clave</h3>

        <div class="alert alert-warning">
            Importante: No comparta su clave y utilice una clave segura.
        </div>


		<form method="POST" action="{{ route('password.update') }}">
			{{ method_field('PUT') }} {{ csrf_field() }}

			<div class="form-group">
				<label for="forClave">Clave Actual</label>
				<input type="password" name="password" id="forClave"
                    placeholder="Clave Actual" required="required" autofocus
					class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
				@if ($errors->has('password'))
	    			<div class="invalid-feedback">{{ $errors->first('password') }}</div>
	    		@endif
	  		</div>

	 		<div class="form-group">
				<label for="forClave">Nueva Clave</label>
				<input type="password" name="newpassword" id="forNuevaClave"
                    placeholder="Nueva Clave" required="required"
					class="form-control {{ $errors->has('newpassword') ? 'is-invalid' : '' }}">
				@if ($errors->has('newpassword'))
	    			<div class="invalid-feedback">{{ $errors->first('newpassword') }}</div>
	    		@endif
	  		</div>

	 		<div class="form-group">
				<label for="forNuevaClaveConfirm">Confirmar Nueva Clave</label>
				<input type="password" name="newpassword_confirm" id="forNuevaClaveConfirm"
                    placeholder="Confirmar Nueva Clave" required="required"
					class="form-control {{ $errors->has('newpassword_confirm') ? 'is-invalid' : '' }}">
				@if ($errors->has('newpassword_confirm'))
	    			<div class="invalid-feedback">{{ $errors->first('newpassword_confirm') }}</div>
	    		@endif
	  		</div>

			<input type="submit" name="" class="btn btn-primary" value="Cambiar Clave">

		</form>

	</div>

</div>
@endsection
