@extends('layouts.app')
@section('title', 'Gestion de Turnos')


@section('content')

<style type="text/css">
	:root {
    font-size: 16px;
}

.table {
    border: solid 2px black;
    white-space: nowrap;
}

.table thead th {
    text-align: center;
    vertical-align: middle;
    border-bottom: none;
    border: none;
}

.brless {
    /* border-right: solid 1px transparent !important; */
}

.bless {border: none !important;}
.br {border-right: solid 1px #454d55 !important;}
.dia {
    opacity: 0.8;
}

.day {
    background-color: white;
    text-align: center;
}

.night {
    background-color: rgba(0, 0, 0, 0.2);
    text-align: center;
    border-right-color: black !important;
}

.calendar-day {
    font-size: 2rem;
    text-align: center;
    padding: 0!important;
}

.table th, .table td {padding: 0.5rem !important;}

.borderBottom {
    border-bottom: solid 2px #454d55 !important;
}

.bbd {
    border-top: none;
    border-left: none;
    border-right: none;
    border-bottom: solid 1px #454d55;
}

.bbn {
    border-top: none !important;
    border-left: none;
    border-right: solid 1px #454d55;
    border-bottom: solid 1px #454d55;
}
.bg-red {background-color: #ff5133;}
.bg-green {background-color: #00e63d;}
.bg-purple {background-color: #d57aff;}
.bg-red, .bg-green, .bg-purple {color: white;}


.turn-selected {
    background: #ff0000;
    color: #fff;
    padding: 3px 15px;
    border-radius: 50%;
  
}
</style>
<div id="shiftapp">
	
<div class="form-group" >
	<!-- <div class="col-lg-12"> -->
		<h3> Gestión de Turnos </h3>
		<form method="POST" class="form-horizontal shadow" action="{{ route('rrhh.shiftsTypes.store') }}">
			@csrf
    		@method('POST')
			<div class="row"> 
	
    		<div class="col-lg-3">
				<div class="input-group">
            	
            		<label for="for_name">U. ORGANIZACIONAL </label>
            		<select class="form-control" id="for_turnFilter" name="turnFilter">
            			<!-- <option>0 - Todos</option> -->
            			@foreach($cargos as $c)
            				<option value="{{$c->id}}">{{$loop->iteration}} - {{$c->name}} </option>
            			@endforeach
            		</select>
        	  	</div>
        	</div>
    		<div class=" col-lg-2">
				<div class="input-group">

            		<label for="for_name" class="input-group-addon">TURNOS </label>
            
            		<select class="form-control" id="for_turnFilter" name="turnFilter">
            			<option>1 - Todos</option>
            			@foreach($sTypes as $st)
            				<option value="{{$st->id}}">{{$loop->iteration}} - Solo {{$st->name}}</option>
            			@endforeach
            			<option value="99">99 - Solo Turno Personalizado</option>
            		</select>

        	  	</div>
        	</div>
        	<div class="col-lg-2">
				<div class="input-group">
            	
            		<label for="for_name">AÑO </label>
            		<select class="form-control" id="for_turnFilter" name="yearFilter">
            			@for($i = $actuallyYear; $i< (intval($actuallyYear) + 4); $i++)
            				<option value="{{$i}}"> {{$i}}</option>
            				
            			@endfor	
            		</select>
        	  	</div>
        	</div>
        	<div class="col-lg-2">
				<div class="input-group">
            	
            		<label for="for_name">MES </label>
            		<select class="form-control" id="for_turnFilter" name="turnFilter">
            			
            			@foreach($months AS $index => $month)
            				<option value="{{ $index }}" {{ ($index == $actuallyMonth )?"selected":"" }}>{{$loop->iteration}} - {{$month}}</option>
            			@endforeach
            			
            		</select>
        	  	</div>
        	</div>
        	<div class=" col-lg-1">
				<div class="input-group">
    				<button type="submit" class="btn btn-primary btn-xs">Filtrar</button>
    			</div>
        	</div>
        	<div class=" col-lg-2">
				<div class="input-group">
    				<button type="button" class="btn btn-outline-success btn-xs"><i class="fa fa-file-excel"></i></button>
    				<button type="button" class="btn btn-outline-danger btn-xs"><i class="fa fa-file-pdf"></i></button>

    			</div>
    		</div>


			</div>
			<br>
			<div class="row"> 
				
				<div class="col-md-offset-4 col-md-12 ">
					<div class="input-group">
            			<input type="text" style="text-align: center;" placeholder="Agregar personal a turno.." name="search2" class="form-control">
            			<button  type="button" class="btn btn-success"><i class="fas fa-user-plus"></i></button>
            				
        	  		</div>
        		</div>

			</div>

		</form>


	<!-- </div> -->
</div>
<div class="row  shadow" style=" overflow: auto;white-space: nowrap;">
	<div class="col-md-2">
            <table class="table">
                <thead class="thead-dark">
                    <th rowspan="2">Personal</th>
                            <th class="calendar-day" colspan="{{$dias}}">ABRIL - TURNO A</th> 

                        <tr>
                            @for($i = 1; $i <= $dias; $i++) 
                                    
                                    <th class="brless dia">{{$i}}</th>
                                    <!-- <th class="brless dia">🌞</th> -->
                                    <!-- <th class="noche">🌒</th> -->
                            @endfor
                        </tr>
                </thead>
                <tbody>
                  
					@foreach($users as $user)
					<tr>
						
						   <td class="bless br" >{{ $user->runFormat()}} - {{$user->name}}</td>
                          
						    @for($j = 1; $j <= $dias; $j++) 


										<td  style="text-align:center;width:54px;height:54px">
                                		      <div  class="bbd day" >L</div>
										</td>
                            @endfor
								</tr>	
                                        
                                        
 
					@endforeach
                   
                </tbody>
            </table>
    </div>
</div>

</div>

@endsection
@section('custom_js')
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script src=https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.1/axios.js></script>

<script type="text/javascript">
	var obj = {
 		foo: 'bar',
      	cargandoPagina:1,

	}

	Object.freeze(obj)
  		Vue.prototype.$http = axios;

new Vue({
  el: '#shiftapp',
  data: obj,
      methods: {
     
     		 getUser : function () {
          		var url = './service.php'; 
          		axios.post(url,{opc:"3"}).then( ( res ) => {
                // console.log(res.config.data);
                // console.log("getUser "+res.data.u.name);

                if (res.data.u!=""){
                // console.log("getUser "+res.data.u);

                  alert("result from axios");
                  // this.usuario.uNombre = res.data.u.name;
                  // this.usuario.uApaterno = res.data.u.lastname1+" "+res.data.u.lastname2;
                  // this.usuario.uEmpresa = "empresa";
                  // this.usuario.uEstado = "Habilitado";
                  // this.usuario.uPhone = res.data.u.phone;
                  // this.usuario.uEmail = res.data.u.email;
                  // this.usuario.uFechaDeNac = res.data.u.birth_date;
                  // this.usuario.uFHabilitacionHasta = res.data.u.habilitado_hasta;
                  // this.usuario.uToken = res.data.u.usr_tkn;

                }
          		}).finally( ()=>{
            		this.getReservas();
          		}).catch(function (error) {
                  console.log(error);
          		});
          		this.cargandoPagina=0;
        }


      }

})



  
 
       
</script>
@endsection