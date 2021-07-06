@extends('layouts.app')

@section('title', 'Gestion de Turnos')

	@section('content')
	<style>
#chartpeoplecant {
  width: 100%;
  height: 500px;
}

</style>
	@include("rrhh.shift_management.tabs", array('actuallyMenu' => 'reports'))

	<h3>Reportes</h3>
	<br>
    <form method="post" action="{{ route('rrhh.shiftManag.shiftReports') }}" >
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
                <label for="for_name" class="input-group-addon">Turnos</label>
              

                               
                <select class="form-control" id="for_turnFilter" name="turnFilter" >

                    <option value="0">0 - Todos</option>
                   
                    @foreach($sTypes as $st)
                       
                      
                                
                                    <option value="{{$st->id}}" {{($st->id==1)?'selected':''}}>{{$loop->iteration}} - Solo {{$st->name}}</option>
                                    
                                
                        @endforeach
                       
                  
                    <!-- <option value="99">99 - Solo Turno Personalizado</option> -->
                </select>
            </div>

            <div class="form-group col-md-2">
                <label for="for_name" class="input-group-addon">Jornada</label>              
                <select class="form-control" id="for_turnFilter" name="turnFilter" >

                    <option value="0">0 - Todas</option>
                    @php
                        $index = 0;
                    @endphp
                    @foreach($tiposJornada as $index => $jt)
                       <option value="{{$index}}">{{$loop->iteration}} - {{ $jt }} </option>
                    @endforeach
                    <!-- <option value="99">99 - Solo Turno Personalizado</option> -->
                </select>
            </div>

            <div class="form-group col-md-2">
                <label for="for_name" class="input-group-addon">Estado</label>              
                <select class="form-control" id="for_turnFilter" name="turnFilter" >

                    <option value="0">0 - Todos</option>
                    @foreach($shiftStatus as $index => $ss)
                       <option value="{{$index}}">{{$index}} - {{ ucfirst($ss) }} </option>
                    @endforeach
                    <!-- <option value="99">99 - Solo Turno Personalizado</option> -->
                </select>
            </div>

            <div class="form-group col-md-2">	
                <label for="for_name">Desde</label>
           
                <input type="date" class="form-control" name="datefrom">
            </div>

            <div class="form-group col-md-2">    	
                <label for="for_name">Hasta</label>
                
                <input type="date" class="form-control" name="dateto">

            </div>

            <div class="form-group col-md-1">
                <label for="for_submit">&nbsp;</label>
                <button type="submit" class="btn btn-primary form-control">Filtrar</button>
            </div>

        </div>
    </form>

<br>
<h5>#1 Registros coincidentes con la busqueda </h5>
<br>
	<table class="table table-sm table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Rut</th>
				<th>Nombre</th>
				<th>Dia</th>
				<th>Estado</th>
				<th>Remplazado con</th>
				<th>Confirmacion</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>18004474-4</td>
				<td>Armando Barra Perez</td>
				<td>01/07/21</td>
				<td>Licencia Medica</td>
				<td>Prueba p1</td>
				<td>
				 	<small>Confirmado por supervisor area  <i class="fa fa-check"></i></small><br>
				 	<small>Confirmado por supervicion medica <i class="fa fa-check"></i></small><br>
				 	<small>Confirmado por supervisora rrhh <i class="fa fa-check"></i> </small>
				 </td>
			</tr>	
		</tbody>
	</table>
	
	@endsection
