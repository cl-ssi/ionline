@extends('layouts.bt4.app')

@section('title', 'Gestion de Turnos')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>

	@include("rrhh.shift_management.tabs", array('actuallyMenu' => 'shiftclose'))
	<style type="text/css">
		    .only-icon {
        background-color: Transparent;
        background-repeat:no-repeat;
        border: none;
        cursor:pointer;
        overflow: hidden;
        outline:none;
    }
	</style>
	<h3>Cierre de turnos</h3>
	<br>
	<form method="post" action="{{ route('rrhh.shiftManag.closeShift.saveDate') }} ">
		@csrf
        {{ method_field('post') }} 
		<div class="row"> 
			<div class="col-md-1">
				<label for="for_name">ID:</label>
				<div class="input-group mb-3">
					# <b>{{$cierreDelMes->id}}</b>
				</div>	
			</div>

			<div class="col-md-3">
				<label for="for_name">Fecha de inicio</label>
				<div class="input-group mb-3">
  					<input  type="date" class="form-control" name="initDate" value="{{ $cierreDelMes->init_date }}"  aria-describedby="basic-addon2">
				</div>	
			</div>
  					
			<div class="col-md-3">
				<label for="for_name">Fecha de cierre</label>
				<div class="input-group mb-3">
  					<input  type="date" class="form-control" value="{{ $cierreDelMes->close_date }}"  name="closeDate" aria-describedby="basic-addon2">
					<input type="hidden" name="id" value="{{$cierreDelMes->id}}">
  					
				</div>	
			</div>
			<div class="col-md-3">

				<label for="for_name" style="color:white">.</label>
				<div class="input-group-append">
    					<button class="btn btn-success" >{{ $cierreDelMes->id!=0? 'Modificar':'Crear' }}</button>
    					<button class="btn btn-info" name="new" value="true">Crear</button>
  					</div>
			</div>

		</div>
	</form>

		<form method="post" action="{{ route('rrhh.shiftManag.closeShift') }}" name="menuFilters">
        	@csrf
        	{{ method_field('post') }}  

        	<!-- Menu de Filtros  -->
			<div class="form-row">
				<div class="col-md-3">
					<label for="for_name">Cierre</label>
					<div class="input-group mb-3">
  				
  					<select class="form-control" name="idCierre">
  						<!-- <option value="1">De 2021-10-10 a 2021-10-10</option> -->
  						@foreach($cierres as $c)

  							<option value="{{$c->id}}"  {{ ( $cierreDelMes->id == $c->id ) ? 'selected':'' }} >#{{$c->id}} - De {{ $c->init_date }} a {{ $c->close_date }}</option>

  						@endforeach
  					</select>
				</div>	
			</div>

            	<div class="form-group col-md-4" >
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

   				<div class="form-group col-md-1">	
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
            	<input type="hidden" name="filtrados" id="filtrados"  value="0,0,0">
            	<div class="form-group col-md-2">
                	<label for="for_submit">&nbsp;</label>
                	<button type="submit" class="btn btn-primary form-control">Filtrar <i class="fa fa-filter"></i></button>
            	</div>
        	</div>
  		</form>


	<h4>Cerrados <a href="{{ route('rrhh.shiftManag.closeShift.download',['id'=>'closed']) }}" style="font-size:12px;">	<i class="fa fa-download" aria-hidden="true"></i></a></h4>
	<small class="form-check">
  			<input class="form-check-input" type="checkbox" value="1" id="onlyClosedByMe"  name="onlyClosedByMe" onchange="setValueToFiltrados()" {{ $onlyClosedByMe != 0 ? 'checked':'' }} >
  			<label class="form-check-label" for="flexCheckIndeterminate">
    			Solo cerrados por mi
  			</label>
		</small>
	<br>
		<table  class="table table-sm">
			<thead class="thead-dark">
				<tr>
					<th>#</th>
					<th>Rut</th>
					<th>Nombre</th>
					<th>Cant. horas</th>
					<th>Comentarios</th>

					<th>Cerrado por</th>
					<th>Fecha cierre</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($closed as $c)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{$c->user->runFormat() }}</td>
					<td>{{$c->user->fullName}}</td>
					<td>{{$c->total_hours}}</td>
					<td>{{$c->first_confirmation_commentary}}</td>
					<td>{{$c->close_user_id}}</td>
					<td>{{$c->close_date}}</td>
					<td>
						
						@livewire( 'rrhh.see-shift-control-form', ['usr'=>$c->user, 'actuallyYears'=>$actuallyYear,'actuallyMonth'=>$actuallyMonth,'close'=>$cierreDelMes->id], key($loop->index) )
						
					</td>
				</tr>
				@endforeach
				@if( count( $closed ) < 1 )
				<tr>
					<td  colspan="6" style="text-align:center">	
							
						Sin registro de cerrados en este rango de fechas

					</td>
				</tr>
				@endif
			</tbody>
		</table>
	<h4>Confirmados <a href="{{ route('rrhh.shiftManag.closeShift.download',['id'=>'confirmed']) }}" style="font-size:12px;">	<i class="fa fa-download" aria-hidden="true"></i></a> </h4>
	<small class="form-check">
  			<input class="form-check-input"  type="checkbox" value="1" id="onlyConfirmedByMe" name="onlyConfirmedByMe" onchange="setValueToFiltrados()" {{ $onlyConfirmedByMe != 0 ? 'checked':'' }} >
  			<label class="form-check-label" for="flexCheckIndeterminate">
    			Solo confirmados por mi
  			</label>
		</small>
	<br>
		<table  class="table table-sm">
			<thead class="thead-dark">
				<tr>
					<th>#</th>
					<th>Rut</th>
					<th>Nombre</th>
					<th>Cant. horas</th>
					<th>Comentarios</th>
					<th>Confirmado por</th>

					<th>Fecha confirmacion</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				
				@foreach($firstConfirmations as $f)
					<tr>
						<td>{{$loop->iteration}}</td>
						<td>{{$f->user->runFormat() }}</td>
						<td>{{$f->user->fullName}}</td>
						<td>{{$f->total_hours}}</td>
						<td>{{$f->first_confirmation_commentary}}</td>
						<td>{{$f->first_confirmation_user_id}}</td>
						<td>{{$f->first_confirmation_date}}</td>
						<td>
							@livewire( 'rrhh.see-shift-control-form', ['usr'=>$f->user, 'actuallyYears'=>$actuallyYear,'actuallyMonth'=>$actuallyMonth,'close'=>$cierreDelMes->id], key($loop->index) )

							<form method="post" action="{{ route('rrhh.shiftManag.closeShift.closeConfirmation') }}">
								@csrf
        						{{ method_field('post') }}

								<input type="hidden" name="ShiftCloseId" value="{{$f? $f->id : ''}}">
								<button class="btn btn-success">Cerrar</button>
								<!-- <button data-toggle="modal" data-target="#exampleModal" class="btn btn-success">Confirmar</button> -->

							</form>

						</td>
					</tr>
				@endforeach
				@if( count( $firstConfirmations ) < 1 )
				<tr>
					<td  colspan="6" style="text-align:center">	
							
						Sin registro de confirmados en este rango de fechas

					</td>
				</tr>
				@endif
			</tbody>
		</table>
	<h4>Pendientes <a href="{{ route('rrhh.shiftManag.closeShift.download',['id'=>'slopes']) }}" style="font-size:12px;">	<i class="fa fa-download" aria-hidden="true"></i></a></h4>
	<br>
	<div class="table-wrapper-scroll-y my-custom-scrollbar" style="position: relative;height: 400px;overflow: auto;display: block;">
	<table  class="table table-sm" id="tblPendientes">
		<thead class="thead-dark">
			<tr>
				<th>#</th>
				<th>Rut</th>
				<th>Nombre</th>
				<th>Comentarios</th>
				<!-- <th>Cant. horas</th> -->
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($staffInShift as $s)
				<tr>
					<td>{{$loop->iteration?? '' }}</td>
					<td>{{$s->user&&$s->user->id? $s->user->runFormat(): '' }}</td>
					<td>{{$s->user&&$s->user->id? $s->user->fullName: '' }}</td>
					<form method="post" action="{{ route('rrhh.shiftManag.closeShift.firstConfirmation') }}">
						<td><!-- <input type="text" class="form-control" name="commentX" value="Comentario de prueba desde el area anterior"> -->
							<textarea  class="form-control" name="comment" id="comment1_{{$s->id}}" placeholder ="Ingrese un comentario  " ></textarea>
						 </td>
						<!-- <td>100</td> -->
						<td>
							@csrf
        					{{ method_field('post') }}

							<input type="hidden" name="userId" value="{{ $s->user && $s->user->id ? $s->user->id : ''}}">
							<!-- inicio bug -->
							<input type="hidden" name="cierreId" value="{{$cierreDelMes&&$cierreDelMes->id? $cierreDelMes->id : ''}}">


							<!-- fin bug -->
							 {{--json_encode($cierreDelMes--}}
								
							<button class="btn btn-success">Confirmar</button>
							<!-- <button data-toggle="modal" data-target="#exampleModal" class="btn btn-success">Confirmar</button> -->

					</form>
					<form method="post" id="rejectForm_{{$s->id}}" action="{{ route('rrhh.shiftManag.closeShift.firstConfirmation') }}">
						@csrf
        				{{ method_field('post') }}

						<input type="hidden" name="userId" value="{{$s->user&&$s->user->id? $s->user->id : ''}}">
						
						<!-- inicio bug -->
						{{--json_encode($cierreDelMes--}}
						<input type="hidden" name="cierreId" value="{{$cierreDelMes&&$cierreDelMes->id? $cierreDelMes->id : '' }}">
						<input type="hidden" name="rechazar" value="1">
						<input type="hidden" name="comment" id="comment2_{{$s->id}}" value="">
						<!-- fin bug -->


						<button type="button" onclick="rejectForm({{$s->id}});" class="btn btn-danger">Rechazar</button>
					</form>

                    	@livewire( 'rrhh.see-shift-control-form', ['usr'=>$s->user, 'actuallyYears'=>$actuallyYear,'actuallyMonth'=>$actuallyMonth,'close'=>$cierreDelMes->id], key($loop->index) )

					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<br>
	<h4>Rechazados <a href="{{ route('rrhh.shiftManag.closeShift.download',['id'=>'rejected']) }}" style="font-size:12px;">	<i class="fa fa-download" aria-hidden="true"></i></a></h4>
	<small class="form-check">
  			<input class="form-check-input" type="checkbox" value="1" id="onlyRejectedForMe" name="onlyRejectedForMe" onchange="setValueToFiltrados()" {{ $onlyRejectedForMe != 0 ? 'checked':'' }}>
  			<label class="form-check-label" for="flexCheckIndeterminate">
    			Solo rechazados por mi
  			</label>
		</small>
	<br>
	<table  class="table table-sm">
		<thead class="thead-dark">
			<tr>
				<th>#</th>
				<th>Rut</th>
				<th>Nombre</th>
				<th>Comentarios</th>
				<th>Cant. horas</th>
				<th>Rechazado por</th>
				<th>Fecha rechazo</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
				@foreach($rejected as $r)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{$r->user->runFormat() }}</td>
					<td>{{$r->user->fullName}}</td>
					<td>{{$r->first_confirmation_commentary}}</td>
					<td>{{$r->total_hours}}</td>
					<td>{{$r->first_confirmation_user_id}}</td>
					<td>{{$r->first_confirmation_date}}</td>
					<td>
						
						@livewire( 'rrhh.see-shift-control-form', ['usr'=>$r->user, 'actuallyYears'=>$actuallyYear,'actuallyMonth'=>$actuallyMonth,'close'=>$cierreDelMes->id], key($loop->index) )
						
					</td>
				</tr>
				@endforeach
				@if( count( $rejected ) < 1 )
				<tr>
					<td  colspan="6" style="text-align:center">	
							
						Sin registro de rechazados en este rango de fechas

					</td>
				</tr>
				@endif
			</tbody>
	</table>

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


@section('custom_js')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#tblPendientes').DataTable({
        "paging": false,
        "language":{
             "decimal":        "",
             "emptyTable":     "Sin registro de pendientes en ese rango de fechas",
             "info":           "Mostrando _START_ de _END_ de un total de _TOTAL_",
             "infoEmpty":      "Mostrando 0 to 0 of 0 registros",
             "infoFiltered":   "(filtered from _MAX_ total entries)",
             "infoPostFix":    "",
             "thousands":      ",",
             "lengthMenu":     "Mostrar _MENU_ filas",
             "loadingRecords": "Cargando...",
             "processing":     "Procesando...",
             "search":         "Buscar:",
             "zeroRecords":    "No se encontró nada con ese criterio",
             "paginate": {
                 "first":      "Primera",
                 "last":       "Última",
                 "next":       "Siguiente",
                 "previous":   "Anterior"
             },
             "aria": {
                 "sortAscending":  ": activate to sort column ascending",
                 "sortDescending": ": activate to sort column descending"
             }
         }

    } );
} );

function setValueToFiltrados(){
	var onlyClosedByMe=0;
	var onlyConfirmedByMe=0;
	var onlyRejectedForMe=0;

	if ( $("#onlyConfirmedByMe").prop( "checked") )
		onlyConfirmedByMe = 1;
	if ( $("#onlyClosedByMe").prop( "checked") )
		onlyClosedByMe = 1;
	if ( $("#onlyRejectedForMe").prop( "checked") )
		onlyRejectedForMe = 1;
	$("#filtrados").val( onlyClosedByMe +","+ onlyConfirmedByMe +","+ onlyRejectedForMe  );
	// alert($("#filtrados").val()  );
	menuFilters.submit();
}

function rejectForm(idField){
	$("#comment2_"+idField).val( $("#comment1_"+idField).val() );
	// alert($("#comment2_"+idField).val());
	$("#rejectForm_"+idField).submit();
}
</script>

@endsection