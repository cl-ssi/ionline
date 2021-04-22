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

                        <label for="exampleFormControlInput1">Información <i class="fa fa-info"></i></label>
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
                                        {{$shiftUserDay->working_day}} 
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
                                        {{$shiftUserDay->status}} 
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

                        <label for="exampleFormControlInput1">Accion <i class="fa fa-cog"></i></label>

                      
                        <select class="form-control" name="slcAction">
                            <option value="0"> <b> </b>1 - Cambiar Turno con </option>
                            <option value="0"> <b> </b>2 - Marcar como Licencia Medica </option>
                            <option value="0"> 3 - <b style="color:">Marcar como Fuero Gremial</b> </option>
                            <option value="0"> 4 - <b style="color:">Marcar como Feriado Legal</b> </option>
                            <option value="0"> 5 - <b style="color:">Marcar como Permiso Excepcional</b> </option>
                        </select>
                       
                       
                        <span class="text-danger"></span>

                    </div>
                    <div class="form-group {{$usersSelect}}">

                        <label for="exampleFormControlInput1">Personal <i class="fa fa-user"></i></label>
                         <select class="form-control" name="slcAction">
                            <option value="0" >1 - Persona uno </option>
                        </select>

                    </div>

                    <div class="form-group">

                        <input type="hidden" wire:model="user_id">

                        <label for="exampleFormControlInput1">Historial de modificaciones <i class="fa fa-cog"></i></label>
                            <p> <i>
                                
                              >> 2021/04/21 - Se a creado el dia </i>  </p>
                        <input type="text" class="form-control" wire:model="name" id="exampleFormControlInput1" placeholder="Enter Name">
                        
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