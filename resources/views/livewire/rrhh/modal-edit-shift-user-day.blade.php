
<div   wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document" >

       <div class="modal-content" >

            <div class="modal-header" style="background-color:#006cb7;color:white   ">

                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-calendar"></i> Modificar día de personal </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">×</span>

                </button>

            </div>

            <div class="modal-body">

                <form>

                    <div class="form-group">

                        <input type="hidden" wire:model="user_id">

                        <label for="exampleFormControlInput1"><i class="fa fa-info"></i> INFORMACIÓN </label>
                        <table class="table"> 
                        <thead> 
                            <tr>
                                <th style="text-align: left;">Pertence a</th>
                                <td> 
                                    @if ( isset($shiftUserDay) && $shiftUserDay->ShiftUser ) 
                                        {{$shiftUserDay->ShiftUser->user->name}} {{$shiftUserDay->ShiftUser->user->fathers_family}} {{$shiftUserDay->ShiftUser->user->mothers_family}}
                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif

                                 </td>
                            </tr>
                            <tr>
                                <th style="text-align: left;">Tipo de jornada</th>
                                <td>
                                    @if ( isset($shiftUserDay) && $shiftUserDay->ShiftUser ) 
                                        {{$shiftUserDay->working_day}} - {{strtoupper($tiposJornada[$shiftUserDay->working_day])}}
                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: left;">Fecha</th>
                                <td>
                                    @if ( isset($shiftUserDay) && $shiftUserDay->ShiftUser ) 
                                        {{$shiftUserDay->day}} 
                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: left;">Estado  </th>
                                <td> @if ( isset($shiftUserDay) && $shiftUserDay->ShiftUser ) 
                                        {{$shiftUserDay->status}} - {{strtoupper($estados[$shiftUserDay->status])}}
                                        <i class="fa fa-circle " style="color:{{$statusColors[$shiftUserDay->status]}}"></i>
                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif</td>
                            </tr>
                            <tr>
                                <th style="text-align: left;">Comentario  </th>
                                <td> @if ( isset($shiftUserDay) && $shiftUserDay->ShiftUser ) 
                                        {{$shiftUserDay->commentary}} 
                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif</td>
                            </tr>
                        </thead>
                         
                        </table>
                    </div>

                    <div class="form-group">

                        <input type="hidden" wire:model="user_id">

                        <label for="exampleFormControlInput1"><i class="fa fa-cog"></i> ACCION </label>

                      
                        <select class="form-control" name="slcAction" wire:model="action" wire:change="changeAction">
                            <option value="0"> <b> </b> - - - </option>
                            <option value="1"> <b> </b>1 - Cambiar Turno con </option>
                            <option value="2"> <b> </b>2 - Marcar como Cumplido </option>
                            <option value="3"> <b> </b>3 - Marcar como Licencia Medica </option>
                            <option value="4"> 4 - <b style="color:">Marcar como Fuero Gremial</b> </option>
                            <option value="5"> 6 - <b style="color:">Marcar como Feriado Legal</b> </option>
                            <option value="6"> 7 - <b style="color:">Marcar como Permiso Excepcional</b> </option>
                            <option value="7"> 8 - <b style="color:">Cambiar Tipo de Jornada Por</b> </option>
                        </select>
                      
                       
                        <span class="text-danger"></span>

                    </div>
                    <div class="form-group " style="display: {{$usersSelect}}">

                        <label for="exampleFormControlInput1"><i class="fa fa-user"></i> PERSONAL </label>
                         <select class="form-control" wire:model="userIdtoChange" name="slcAction">
                            <option value="0" >0 - Dejar disponible </option>
                            <option value="1" >1 - Persona uno </option>
                        </select>

                    </div>
                     <div class="form-group" style="display: {{$changeDayType}}">

                        <label for="exampleFormControlInput1"><i class="fa fa-sun-o"></i> Tipo de Jornada </label>
                         <select class="form-control" wire:model="newWorkingDay" name="slcAction">

                            @foreach( $tiposJornada as $index=>$tj )
                                <option value="{{$index}}">
                                {{$index}} - {{strtoupper($tj)}} 
                                </option>
                            @endforeach
                      

                        </select>

                    </div>
                    <div class="form-group">

                        <input type="hidden" wire:model="user_id">

                        <label for="exampleFormControlInput1"><i class="fa fa-history "></i> HISTORIAL DE MODIFICACIONES </label>
                            @if( isset($shiftUserDay) && $shiftUserDay->ShiftUser )
                            <p>
                             <i>
                              >> {{  $shiftUserDay->created_at }} - La jornada ha sido creada </i> 

                             </p>
                                @foreach($shiftUserDay->shiftUserDayLog as $log)
                                      <p><i>  >> {{$log->created_at}} - {!!$log->commentary!!} </i></p>
                                @endforeach
                            @else
                                 <p>         <i class="fas fa-spinner fa-pulse"></i>
                             </p>
                            @endif

                        
                    </div>
                </form>

            </div>

            <div class="modal-footer">

                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                <button type="button" wire:click.prevent="update()" class="btn btn-primary" data-dismiss="modal">Guardar </button>

            </div>

       </div>

    </div>

</div>