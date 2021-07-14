<style type="text/css">
	
	.seeBtn {
		color:blue;
	}
	.seeBtn:hover  {
		color:lightblue;
	}
	.tblShiftControlForm td, .tblShiftControlForm th {
		font-size: 10px;
	}
	.table-wrapper {
        max-height: 150px;
        overflow: auto;
        display:inline-block;
    }
</style>
<div style=" display: inline;">
@if( isset($usr) && $usr != "" )
    <button class="only-icon seeBtn"  data-toggle="modal" data-target="#shiftcontrolformmodal{{$usr->id}}"    data-backdrop= "static" >
    	<i class="fa fa-eye seeBtn" wire:click.prevent="setValues({{$usr->id}})"></i>
	</button> 
@endif
</div>

<div   wire:ignore.self class="modal fade" id="shiftcontrolformmodal{{$usr->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document" >

       <div class="modal-content" >

            <div class="modal-header" style="background-color:#006cb7;color:white   ">

                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-clock"></i> Planilla de control de Turnos</h5>

                <button type="button" class="close" data-dismiss="modal" wire:click.prevent="cancel()" aria-label="Close">

                    <span aria-hidden="true">×</span>

                </button>

            </div>

            <div class="modal-body">
                
                    <table class="table tblShiftControlForm table-striped"> 
                        <thead> 

                        	<tr>
                                <th style="text-align: left;">RUT</th>
                                <td> 
                                    @if( isset( $usr ) )
                                    	{{strtoupper($usr->runFormat())}}
                                    @else
                                        <i class="fas fa-spinner fa-pulse"></i>
                                    @endif
                                </td>
                                <th style="text-align: left;">CARGO</th>
                                <td>
    								@if( isset( $usr ) )
                                    	N/A
                                    @else
                                        <i class="fas fa-spinner fa-pulse"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: left;">MES</th>
                                <td>
                                    @if ( isset( $usr ) )  
                                        {{ strtoupper($months[$actuallyMonth]) }}
                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif
                                </td>
                                <th style="text-align: left;">GRADO</th>
                                <td>
                                    @if ( isset( $usr ) ) 
                                    	N/A   
                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif
                                	
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: left;">SERVICIO</th>
                                <td>
                                    @if ( isset( $usr ) )
                                    	N/A   
                                     
                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif
                                </td>
                                <th style="text-align: left;">CALIDAD</th>
                                <td>
                                       @if ( isset( $usr ) ) 
                                    	N/A   
                                       
                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif
                                	
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: left;">TURNO  </th>
                                <td> @if (isset( $usr ) ) 
                                    	N/A   
                                     
                                     @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>
                                    @endif
                                </td>
                                <th style="text-align: left;">N°CREDENCIAL</th>
                                <td>
                                      @if ( isset( $usr ) ) 
                                    	N/A   
                                       
                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif 
                                       
                                	
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: left;">APELLIDOS  </th>
                                <td> 
                                	@if ( isset( $usr ) ) 
                                	{{strtoupper($usr->fathers_family)}} 
                                       {{strtoupper($usr->mothers_family) }}

                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif
                                </td>
                                <th style="text-align: left;">NOMBRES</th>
                                <td>
                                    @if ( isset( $usr ) ) 
                                       {{$usr->getFirstNameAttribute()}}
                                       
                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif
                                	
                                </td>
                            </tr>
                        	<tr>
                        	</tr>
                     
                        </thead>
                        <tbody>
                        </tbody>     	
                    </table>
                        <div class="table-responsive table-wrapper">
                        	
 							<table class="table tblShiftControlForm"> 
                				<thead> 
                					<tr>
                						<th>FECHA</th>
                						<th>DÍA</th>
                						<th  colspan="2">HORARIO</th>
                						<th>OBSERVACION DE DATOS OBLIGATORIOS</th>
                					</tr>
									<tr>
										<th></th>
										<th></th>
										<th>Entrada</th>
										<th>Salida</th>
										<th></th>
									</tr>
								</thead>
                                                @php
                                                    $total = 0;
                                                @endphp

                				<tbody>
                        			@if(isset( $days ) && $days > 0)	
                        				@for($i = 1; $i < ($days+1); $i++ )
                                            @php
                                                $date2 = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYears."-".$actuallyMonth."-".$i);  
                                                $date =explode(" ",$date2);
                                                $d = $shifsUsr->days->where('day',$date[0]);
                                                
                                            @endphp
                                            @foreach($d as $dd)
                        					   <tr>
                        						  <td>{{$i}}	</td>
                        						  <td>
                                                         {{ ($dd["working_day"]!="F")?$dd["working_day"]:"-"  }}                    
                                                    </td>
                                                    @if($date2->isPast())
                                                        <td>{{ (isset($timePerDay[$dd["working_day"]]))?$timePerDay[$dd["working_day"]]["from"]:""  }}</td>
                        						      <td>{{  (isset($timePerDay[$dd["working_day"]]))?$timePerDay[$dd["working_day"]]["to"]:"" }}</td>
                                                        <td>{{  (( isset($timePerDay[$dd["working_day"]]) )? ( ($shiftStatus[$dd["status"]] == "asignado" )?"Completado":ucfirst($shiftStatus[$dd["status"]] )  ):""  )   }} - <small style="color:{{ ( $dd->confirmationStatus() == 1 ) ? 'green;':'red;'    }}"> {{ ( $dd->confirmationStatus() == 1 ) ? 'Confirmado':'Sin Confirmar'    }}</small></td>
                                                        @if( $dd->confirmationStatus() == 1 )
                                                            @php
                                                                if(  substr($dd["working_day"],0, 1) != "+" )
                                                                    $total+=   (isset($timePerDay[$dd["working_day"]]))?$timePerDay[$dd["working_day"]]["time"]:0  ;
                                                                else
                                                                    $total+= intval( substr( $dd["working_day"],1,2) );
                                                            @endphp
                                                        @endif
                                                    @else
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    @endif
                        					   </tr>
                                            @endforeach
                        				@endfor
                        			@else
                                        <tr><td>
                                        	
                                        	<i class="fas fa-spinner fa-pulse"></i>
                                        </td>
                                        </tr>

                        			@endif
                        			<tr>
                        				<th>TOTAL</th>	
                        				<td>{{$total}}</td>	
                        				<td></td>	
                        				<td></td>	
                        				<td></td>	
                        			</tr>
                				</tbody> 
           					</table>
                        
                        </div>

            </div>
            <div class="modal-footer">

                <button type="button" wire:click.prevent="cancel()" class="btn" data-dismiss="modal">Cerrar</button>

                
                <form method="post" action="{{ route('rrhh.shiftManag.downloadform') }}" >
                    @csrf
                    {{ method_field('post') }} 
                    <input style=" display:none;" name="days" value="{{ $days }}">
                    <input style=" display:none;" name="actuallyMonth" value="{{ $actuallyMonth }}">
                    <input style=" display:none;" name="actuallyYears" value="{{ $actuallyYears }}">
                    <input style=" display:none;" name="shifsUsr" value="{{ $shifsUsr }}">
                   
                    <input style=" display:none;" name="actuallyUser" value="{{ $usr->id }}">
                  <button class="btn btn-success " target="_blank">Descargar <i class="fa fa-check"></i></button>
                </form>

            </div>

       </div>

    </div>

</div>