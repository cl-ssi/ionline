@extends('layouts.app')

@section('title', 'Gestion de Turnos')

@section('content')

	@include("rrhh.shift_management.tabs", array('actuallyMenu' => 'shiftclose'))

	<h3>Cierre de turnos</h3>
	<br>
	<div class="row"> 
		<div class="col-md-3">
				<label for="for_name">Fecha de cierre</label>
			<div class="input-group mb-3">
  				<input readonly type="date" class="form-control"  aria-describedby="basic-addon2">
  					<div class="input-group-append">
    					<button class="btn btn-success" type="button">Editar</button>
  					</div>
			</div>	
		</div>
	</div>

		<form method="post" action="{{ route('rrhh.shiftManag.indexF') }}" >
        	@csrf
        	{{ method_field('post') }}  <!-- equivalente a: @method('POST') -->

        	<!-- Menu de Filtros  -->
			<div class="form-row">
            	<div class="form-group col-md-5" >
                	<label for="for_name">Unidad organizacional</label>
                	<select class="form-control selectpicker"  id="for_orgunitFilter" name="orgunitFilter" data-live-search="true" required
                            data-size="5">
                        @foreach($ouRoots as $ouRoot)
                            @if($ouRoot->name != 'Externos')
                                <option value="{{ $ouRoot->id }}"  {{($ouRoot->id==$actuallyOrgUnit->id)?'selected':''}}> 
                                {{($ouRoot->id ?? '')}}-{{ $ouRoot->name }}
                                </option>
                                @foreach($ouRoot->childs as $child_level_1)
                                    <option value="{{ $child_level_1->id }}" {{($child_level_1->id==$actuallyOrgUnit->id)?'selected':''}}>
                                        &nbsp;&nbsp;&nbsp;
                                        {{($child_level_1->id ?? '')}}-{{ $child_level_1->name }}
                                    </option>
                                    @foreach($child_level_1->childs as $child_level_2)
                                        <option value="{{ $child_level_2->id }}" {{($child_level_2->id==$actuallyOrgUnit->id)?'selected':''}}>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{($child_level_2->id ?? '')}}-{{ $child_level_2->name }}
                                        </option>
                                        @foreach($child_level_2->childs as $child_level_3)
                                            <option value="{{ $child_level_3->id }}" {{($child_level_3->id==$actuallyOrgUnit->id)?'selected':''}}>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                {{($child_level_3->id ?? '')}}-{{ $child_level_3->name }}
                                            </option>
                                            @foreach($child_level_3->childs as $child_level_4)
                                                <option value="{{ $child_level_4->id }}" {{($child_level_4->id==$actuallyOrgUnit->id)?'selected':''}}>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{($child_level_4->id ?? '')}}-{{ $child_level_4->name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endif
                        @endforeach
                    </select>
            	</div>

   				<div class="form-group col-md-2">	
                	<label for="for_name">Año</label>
                	<select class="form-control" id="for_yearFilter" name="yearFilter">
                    	@for($i = (intval($actuallyYear)-2); $i< (intval($actuallyYear) + 4); $i++)
                        	<option value="{{$i}}" {{ ($i == $actuallyYear )?"selected":"" }}> {{$i}}</option>
                    	@endfor	
                	</select>
            	</div>

            	<div class="form-group col-md-2">    	
                	<label for="for_name">Mes</label>
                	<select class="form-control" id="for_monthFilter" name="monthFilter">
                    	@foreach($months AS $index => $month)
                        	<option value="{{ $index }}" {{ ($index == $actuallyMonth )?"selected":"" }}>{{$loop->iteration}} - {{$month}} </option>
                    	@endforeach
                	</select> 		
            	</div>

            	<div class="form-group col-md-1">
                	<label for="for_submit">&nbsp;</label>
                	<button type="submit" class="btn btn-primary form-control">Filtrar</button>
            	</div>
        	</div>
  		</form>


	<h4>Cerrados</h4>
	<br>
		<table  class="table table-sm">
			<thead class="thead-dark">
				<tr>
					<th>#</th>
					<th>Rut</th>
					<th>Nombre</th>
					<th>Cant. horas</th>
					<th>Cerrado en</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td>11.111.111-1</td>
					<td>Armando Barra Perez</td>
					<td>100</td>
					<td>11:20:00 22/06/21</td>
					<td><button class="btn btn-info"><i class="fa fa-eye"></i></button></td>
				</tr>
			</tbody>
		</table>
	<h4>Pendientes</h4>
	<br>
			<table  class="table table-sm">
			<thead class="thead-dark">
				<tr>
					<th>#</th>
					<th>Rut</th>
					<th>Nombre</th>
					<th>Comentarios</th>
					<th>Cant. horas</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($staffInShift as $s)
				<tr>
					<td>{{$loop->iteration }}</td>
					<td>{{$s->user->runFormat() }}</td>
					<td>{{$s->user->getFullNameAttribute() }}</td>
					<td><input type="text" class="form-control" name="" value="Comentario de prueba desde el area anterior"> </td>
					<td>100</td>
					<td>
						<button data-toggle="modal" data-target="#exampleModal" class="btn btn-success">Confirmar</button>
                    	@livewire( 'rrhh.see-shift-control-form', ['usr'=>$s->user, 'actuallyYears'=>$actuallyYear,'actuallyMonth'=>$actuallyMonth], key($loop->index) )

					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	<br>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmar horas trabajadas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p style="color:green">CONFIRMACION 1 <i class="fa fa-check	"></i>	</p>
        <p>	confirmado por usuario Armando Barra Perez</p>
      	<p>	Comentarios: Pueba comentario</p>
      	<p style="color:yellow;">CONFIRMACION 2	</p>
        <p>Pendiente	</p>
      	<p>Pendiente	</p>
      	<br>
      	<br>
      	<b>	Horas totales: 100</b>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Confirmar</button>
      </div>
    </div>
  </div>
</div>
@endsection