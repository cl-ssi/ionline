
    <div   wire:ignore.self class="modal fade" id="shiftcontrolformmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document" >

       <div class="modal-content" >

            <div class="modal-header" style="background-color:#006cb7;color:white   ">

                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-clock"></i> Control de Turnos de personal X{{ $log }}</h5>

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
                                        actuallyMonth <i class="fas fa-spinner fa-pulse"></i>
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
                        	</tr>
                        	<tr>
                     
                        </thead>
                        <tbody>
                        	
                        </tbody> 
                        </table>
                        <div class="table-responsive">
                        	
 							<table class="table tblShiftControlForm"> 
                				<thead> 
                					<tr>
                						<th>FECHAx</th>
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
                				<tbody>
                      
                        			@if($days > 0)	
                        				@for($i = 1; $i < ($days+1); $i++ )
                                          
                        					<tr>
                        						<td>{{$i}}	</td>
                        						<td>
                                                    @php
                                                        $date = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-".$j);  
                                                        $date =explode(" ",$date);
                                                        $d = $shifsUsr->days->where('day',$date[0]);
                                                        $d = $d->first();
                                                    @endphp
                                                  $date {{$date}}; actuallyYear {{$actuallyYear}} ; d {{ $d}} ; {{$d->working_day}} ; 
                                                </td>
                        						<td></td>
                        						<td></td>
                        						<td></td>
                        					</tr>
                        				@endfor
                        			@else
                                        <tr><td>
                                        	
                                        	<i class="fas fa-spinner fa-pulse"></i>
                                        </td>
                                        </tr>

                        			@endif
                        			<tr>
                        				<th>TOTAL</th>	
                        				<td></td>	
                        				<td></td>	
                        				<td></td>	
                        				<td></td>	
                        			</tr>
                				</tbody> 
           					</table>
                        
                        </div>

            </div>
            <div class="modal-footer">

                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                

                <form action="{{ route('rrhh.shiftManag.shiftManag.downloadform') }}" >
                    @csrf
                    <input class="hidden" name="" value="{{ $days }}">
                  <button class="btn btn-success ">Descargar <i class="fa fa-check"></i></button>
                </form>



            </div>

       </div>

    </div>

</div>
