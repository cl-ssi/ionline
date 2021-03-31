@extends('layouts.app')
@section('title', 'Gestion de Turnos')
@section('content')
<style type="text/css">
		
	.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

</style>

	<h3 class="inline mt-3">Tipos de turno 
		<a href="{{ route('rrhh.shiftsTypes.create') }}" class="btn btn-primary">Crear</a>
	</h3>
	<br>

	<table class="table table-striped table-sm">
		<thead class="thead-dark">
			<tr>
				<th>#</th>
				<th>Nombre</th>
				<th>Abrev.</th>
				<th>Estado</th>
				<th>Creado en</th>
				<th>Accion</th>
			</tr>
		</thead>
		<tbody>
				@foreach($sTypes as $sType)
					<tr>
						<td>{{$loop->iteration}}</td>
						<td>{{$sType->name}}</td>
						<td>{{$sType->shortname}}</td>
						<td>
							<label class="switch">
  								<input type="checkbox" {{($sType->status==1)?"checked":""}}>
  								<span class="slider round"></span>
							</label>
						</td>
						<td>{{$sType->created_at}}</td>
						<td><a href="{{route('rrhh.shiftsTypes.edit', $sType->id)}}" class="btn btn-outline-primary" ><i class="fa fa-edit">	</i></a></td>
					</tr>
				@endforeach
				
		</tbody>
	</table>
@endsection
