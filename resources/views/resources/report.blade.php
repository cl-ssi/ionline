@extends('layouts.app')
@section('title', 'Reporte')
@section('content')

<h3>Reporte de IP's</h3>

<form method="GET" class="form-horizontal" action="{{ route('resources.report') }}">

  <div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text">Lugares</span>
    </div>

      <select id="location_id" name="location_id" class="form-control selectpicker" for="for_location" >
        <option value="0">Todos</option>
        @foreach($locations as $location)
          <option value ='{{$location->id}}' {{($location->id == $request->get('location_id'))?'selected':''}}>{{$location->name}}</option>
        @endforeach
      </select>

      <div class="input-group-prepend">
          <span class="input-group-text">Oficinas</span>
      </div>

        <select id="place_id" name="place_id" class="form-control selectpicker" for="for_place" >
          <option value="0">Todos</option>
          @foreach ($places as $place)
            <option value='{{$place->id}}' {{($place->id == $request->get('place_id'))?'selected':''}}> {{$place->location->name . ' - ' . $place->name}}</option>
          @endforeach
        </select>
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
          <span class="input-group-text">Tipo de activo</span>
      </div>
        <select id="active_type" name="active_type" class="form-control selectpicker" for="for_active_type" >
          <option value="" {{($request->get('active_type')=='')?'selected':''}}>Todos</option>
          <option value="leased" {{("leased" == $request->get('active_type'))?'selected':''}}>Arrendados</option>
          <option value="own" {{("own" == $request->get('active_type'))?'selected':''}}>Propios</option>
          <option value="user" {{("user" == $request->get('active_type'))?'selected':''}}>Usuario</option>
        </select>
        <div class="input-group-append">
      		<button type="submit" class="btn btn-primary">
                  <i class="fas fa-search"></i> Buscar
              </button>
      	</div>
      </div>



</form>

<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text">Filtro</span>
  </div>

  <input type="text" class="form-control" id="forsearch" onkeyup="filter(0)"
      placeholder="Filtro por Tipo."
      name="search">
</div>

<div class="table-responsive">
		<table class="table table-striped table-sm" id="TableFilter">
		<thead>
			<tr>
        <th scope="col">Tipo</th>
				<th scope="col">Ip</th>
        <th scope="col">Establecimiento</th>
				<th scope="col">Lugar</th>
				<th scope="col">Encargado</th>
        <th scope="col">Activo</th>
        <th><button type="button" class="btn btn-sm btn-outline-primary"><i class="fas fa-download"></i></button></th>
			</tr>
		</thead>
		<tbody>
      @foreach($computers as $computer)
        <tr>
          <td nowrap>{{$computer->tipo()}}</td>
          <td>{{$computer->ip}}</td>
          <td>{{(isset($computer->place))?$computer->place->name:''}}</td>
          <td>{{(isset($computer->place->location))?$computer->place->location->name:''}}</td>
          <td>{{(!is_null($computer->users->first()))?$computer->users->first()->getFullNameAttribute():''}}</td>
          <td>{{$computer->tipoActivo()}}</td>
        </tr>
      @endforeach
      @foreach($printers as $printer)
        <tr>
          <td nowrap>{{$printer->tipo()}}</td>
          <td>{{$printer->ip}}</td>
          <td>{{(isset($printer->place))?$printer->place->name:''}}</td>
          <td>{{(isset($printer->place->location))?$printer->place->location->name:''}}</td>
          <td>{{(!is_null($printer->users->first()))?$printer->users->first()->getFullNameAttribute():''}}</td>
          <td>{{$printer->tipoActivo()}}</td>
        </tr>
      @endforeach
		</tbody>
	</table>
</div>
@endsection
