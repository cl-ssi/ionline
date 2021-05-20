@extends('layouts.app')

@section('title', 'some')

@section('content')

<form>

	<div class="form-row">

    	<div class="form-group col-md-4">
    			<label for="inputEmail4">RUT</label>
    			<input type="email" class="form-control" id="inputEmail4" placeholder="ingrese el rut">
    	</div>
    	<div class="form-group col-md-1">
      			<label for="inputPassword4">Dv</label>
      			<input type="password" class="form-control" id="inputPassword4" placeholder="Dv">
    	</div>
		<div class="form-group col-md-5">
     	 		<label for="inputEmail4">Nombre</label>
      	 		<input type="email" class="form-control" id="inputEmail4" placeholder="Ingrese Nombre">
    	</div>
    	<div class="form-group col-md-2">
				<label for="inputEmail4">&nbsp;</label>
				<button type="button" class="btn btn-primary form-control">Buscar</button>
   		 </div>
	</div>

  
	<div class="card mb-3">
  		<div class="card-header">
   			 Nombre
 	   	</div>
  		<div class="card-body">

    		<p class="card-text">Identificación</p>
			<p class="card-text">Edad:</p>
			<p class="card-text">Sexo:</p>
			<p class="card-text">Dirección:</p>
			<p class="card-text">Teléfono:</p>
			<p class="card-text">Correo::</p>
    	
  		</div>
	</div>

	<div class="card mb-3">
		<div class="card-body">
		
			<div class="form-row">

    			<div class="form-group col-md-4">
    				<p class="card-text">Prevision</p>
    			</div>
				<div class="form-group col-md-6">
    				<p class="card-text">Fonasa</p>
    			</div>

    			<div class="form-group col-md-2">
					<button type="button" class="btn btn-primary form-control">Fonasa</button>
   			    </div>
			</div>
		</div>
	</div>


	<div class="form-row">

    	<div class="form-group col-md-4">
    			<label for="inputEmail4">Especialidad</label>
    			<select id="inputState" class="form-control">
        			<option selected>Salud Mental</option>
        			<option>Traumatologia</option>
     			 </select>
    	</div>
    	<div class="form-group col-md-4">
      			<label for="inputPassword4">Profesional</label>
      			<select id="inputState" class="form-control">
        			<option selected>Dr Oscar Zavala</option>
        			<option>Dr Toby Cerdo</option>
     			 </select>
    	</div>
		<div class="form-group col-md-4">
     	 		<label for="inputEmail4">Estado</label>
				  <select id="inputState" class="form-control">
        			<option selected>Disponible</option>
        			<option>Bloqueado</option>
     			 </select>
    	</div>
    	
	</div>




</form>


@endsection

@section('custom_js')

@endsection
