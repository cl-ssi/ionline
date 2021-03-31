@extends('layouts.app')
@section('title', 'Gestion de Turnos')
@section('content')


<div class="row" >
	<div class="col-md-12">
			
		<form method="POST" class="form-horizontal" action="{{ route('rrhh.shiftsTypes.store') }}">
			@csrf
    		@method('POST')

    		<fieldset class="form-group col-6 col-md-3">
            		<label for="for_name">CARGOS</label>
            
            		<select class="form-control" id="for_turnFilter" name="turnFilter">
            			<option>1 - Todos</option>
            			<option>2 - Enfermeros</option>
            			<option>3 - Paramedicos</option>
            			<option>4 - Adminsitrativos</option>
            			<option>5 - Auxiliares de serivicio</option>
            		</select>
        	</fieldset>

    		<fieldset class="form-group col-6 col-md-3">
            		<label for="for_name">TURNOS</label>
            
            		<select class="form-control" id="for_turnFilter" name="turnFilter">
            			<option>1 - Todos</option>
            			<option>2 - </option>
            			<option>3 - </option>
            			<option>4 - Solo Personalizado</option>
            		</select>
        	</fieldset>

    		<button type="submit" class="btn btn-primary">Filtrar</button>

		</form>


	</div>
</div>
<div class="row" style=" overflow: auto;white-space: nowrap;">
	<div class="col-md-2">
            <table class="table">
                <thead class="thead-dark">
                    <th rowspan="2">Personal</th>
                    <th class="br" rowspan="2">Turnos</th>
                    <?php
                        //Aquí van los dias del mes
                        $dias = 31;
                        for($i = 1; $i <= $dias; $i++) {
                            ?> <th colspan="2" class="calendar-day"><?= $i ?></th> <?php
                        } ?>

                        <tr>
                            <?php
                                for($i = 1; $i <= $dias; $i++) {
                                    ?>
                                    <th class="brless dia">🌞</th>
                                    <th class="noche">🌒</th>
                                    <?php
                                }
                            ?>
                        </tr>
                </thead>
                <tbody>
                    <?php
                        $personas = 12;
                        $nombre = "Nombre";
                        $turno = "Turno ABC";
                     
                    ?>
					@foreach($users as $user)
					<tr>
						
						   <td class="bless br">{{ $user->runFormat()}} - {{$user->name}}</td>
                           <td class="bless br">{{ $turno }}</td>

						   <?php
                                    for($j = 1; $j <= $dias; $j++) {
                                        ?>
                                        <td class="bbd day">L</td>
                                        <td class="bbn night">N</td>
                                        <?php
                                    }
                                ?>
 
					</tr>	
					@endforeach
                   
                </tbody>
            </table>
    </div>
</div>
@endsection

