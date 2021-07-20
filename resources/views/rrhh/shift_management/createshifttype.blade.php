@extends('layouts.app')
@section('title', 'Creando Tipos de Turnos')
@section('content')
<style type="text/css">
	.shadow {
  		box-shadow: 0px 2px 2px black;
  		-moz-box-shadow: 0px 2px 2px black, ;
  		-webkit-box-shadow: 0px 2px 2px black;
	}
</style>
<h3>Creando un nuevo  <i>"Tipo de Turno"</i> </h3>
<div class="row ">
	<div class="col-md-12  shadow"> 

		<form method="POST" class="form-horizontal" action="{{ route('rrhh.shiftsTypes.store') }}">
    		@csrf
    		@method('POST')

    		<div class="row">

    			<fieldset class="form-group col-6 col-md-6">
            		<label for="for_name">Nombre*</label>
            		<input type="text" placeholder="Ej: Turno ALPHA" class="form-control" id="for_name" name="name" value="" required>
        		</fieldset>
    		</div>
    		<div class="row">

        		<fieldset class="form-group col-6 col-md-6">
        		    <label for="for_guard_name">Abreviacion</label>
        		    <input type="text" class="form-control"  placeholder="Ej: TAlph" id="for_shortname" name="shortname" 
        		        >
        		</fieldset>
    		</div>
    		<div class="row">
        		<fieldset class="form-group col-12 col-md-4">
        		    <label for="for_descripcion">Jornada*</label>

        		    @for($i=0;$i<7;$i++)
        		         <select class="form-control"  id="for_day_series" name="day_series[]">
        		          @if($i>1)
                            <option value=""> ---- </option>
                          @endif    
        		         	@foreach($tiposJornada as $index => $t  )
        		         		<option value="{{ $index}}"> {{$index}} - {{$t}}</option>

        		         	@endforeach
        		         </select>
        		    @endfor
        		</fieldset>
    		</div>
    		<div class="row">
        		<fieldset class="form-group col-6 col-md-2">
        		    <label for="for_mostrar">Visible en </label>
        		     <div class="form-check form-check-inline">
  					<input class="form-check-input" type="checkbox" name="months[]" checked value="1" />
  					<label class="form-check-label" for="inlineCheckbox1">Ene</label>
				</div>

				<div class="form-check form-check-inline">
  					<input class="form-check-input" type="checkbox" name="months[]" checked value="2" />
  					<label class="form-check-label" for="inlineCheckbox2">Feb</label>
				</div>
        			
        			<div class="form-check form-check-inline">
  					<input class="form-check-input" type="checkbox" name="months[]" checked value="3" />
  					<label class="form-check-label" for="inlineCheckbox2">Mar</label>
				</div>
				<div class="form-check form-check-inline">
  					<input class="form-check-input" type="checkbox" name="months[]" checked value="4" />
  					<label class="form-check-label" for="inlineCheckbox2">Abr</label>
				</div>
				<div class="form-check form-check-inline">
  					<input class="form-check-input" type="checkbox" name="months[]" checked value="5" />
  					<label class="form-check-label" for="inlineCheckbox2">May</label>
				</div>
				<div class="form-check form-check-inline">
  					<input class="form-check-input" type="checkbox" name="months[]" checked value="6" />
  					<label class="form-check-label" for="inlineCheckbox2">Jun</label>
				</div>
				<div class="form-check form-check-inline">
  					<input class="form-check-input" type="checkbox" name="months[]" checked value="7" />
  					<label class="form-check-label" for="inlineCheckbox2">Jul</label>
				</div>
				<div class="form-check form-check-inline">
  					<input class="form-check-input" type="checkbox" name="months[]" checked value="8" />
  					<label class="form-check-label" for="inlineCheckbox2">Ago</label>
				</div>
				<div class="form-check form-check-inline">
  					<input class="form-check-input" type="checkbox" name="months[]" checked value="9" />
  					<label class="form-check-label" for="inlineCheckbox2">Sep</label>
				</div>
				<div class="form-check form-check-inline">
  					<input class="form-check-input" type="checkbox" name="months[]" checked value="10" />
  					<label class="form-check-label" for="inlineCheckbox2">Oct</label>
				</div>
				<div class="form-check form-check-inline">
  					<input class="form-check-input" type="checkbox" name="months[]" checked value="11" />
  					<label class="form-check-label" for="inlineCheckbox2">Nov</label>
				</div>
				<div class="form-check form-check-inline">
  					<input class="form-check-input" type="checkbox" name="months[]" checked value="12" />
  					<label class="form-check-label" for="inlineCheckbox2">Dic</label>
				</div>

        		</fieldset>
    		</div>

    		<input hidden id="for_id" name="id" value="">	
    		<button type="submit" class="btn btn-primary">Crear</button>
    		<button type="button" onclick="cancelar();" class="btn btn-danger">Cancelar</button>
    
		</form>



	</div>
	
</div>
<script type="text/javascript">
	
function cancelar(){
     window.history.back();
}
</script>

@endsection
