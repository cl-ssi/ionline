<div> <!-- Live Wire -->

  <div class="card mx-0">
    <h5 class="card-header text-muted">Formulario de Cotización de Pasajes Aéreos</h5>
    <div class="card-body mx-0 px-0">

      <div class="row justify-content-md-center mx-0 my-2"><!-- FILA  -->
            <div class="form-group col-6">
                <label for="program">Programa Asociado:</label>
                <input type="text" class="form-control form-control-sm" id="program" name="program" required>
            </div>
            <div class="form-group col-6">
                <label for="fortelephone_number">Justificación en Breve:</label>
                <input type="text" class="form-control form-control-sm" id="justification" name="justification" required>
            </div>
      </div><!-- End FILA -->

<!--*************************************************************************************************************************-->
        <div class="card mx-3 mb-3 mt-0 pt-0"><!-- Card para agregar Items  -->
          <div class="card-body mb-1">
              <h5 class="card-subtitle mt-0 mb-3 text-muted">{{$tittle}}:</h5>

              <div class="row justify-content-md-start"><!-- FILA  -->
                    <div class="input-group input-group-sm mb-3 col-4">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Run</span>
                      </div>
                      <input wire:model.defer="run" type="text" class="form-control" name="run">
                    </div>
                    <div class="input-group input-group-sm mb-3 col-2">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">DV</span>
                      </div>
                      <input wire:model.defer="dv" type="text" class="form-control" name="dv">
                    </div>
              </div><!-- End FILA -->

              <div class="row justify-content-md-center mb-0"><!-- FILA  -->
                    <div class="input-group input-group-sm mb-3 col-4">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Nombres</span>
                      </div>
                      <input wire:model.defer="names" type="text" class="form-control" name="names">
                    </div>
                    <div class="input-group input-group-sm mb-3 col-4">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Apellido Paterno</span>
                      </div>
                      <input wire:model.defer="fathersName" type="text" class="form-control" name="fathersName">
                    </div>
                    <div class="input-group input-group-sm mb-3 col-4">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Apellido Materno</span>
                      </div>
                      <input wire:model.defer="mothersName" type="text" class="form-control" name="mothersName">
                    </div>
              </div><!-- End FILA -->

              <div class="row justify-content-md-center mb-0"><!-- FILA  -->
                    <div class="input-group input-group-sm mb-3 col-4">
                      <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroup-sizing-sm">Fecha de Nacimiento</span>
                      </div>
                      <input wire:model.defer="birthDay" type="date" class="form-control form-control-sm" id="forbirthday" name="birthDay" required>
                    </div>
                    <div class="input-group input-group-sm mb-3 col-4">
                      <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroup-sizing-sm">Teléfono</span>
                      </div>
                        <input wire:model.defer="telephoneNumber" type="number" class="form-control form-control-sm" id="fortelephone_number" placeholder="569xxxxxxxx" name="telephoneNumber" required>
                    </div>
                    <div class="input-group input-group-sm mb-3 col-4">
                      <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroup-sizing-sm">E-mail</span>
                      </div>
                        <input wire:model.defer="email" type="email" class="form-control form-control-sm" id="foremail" placeholder="correo@redsalud.gob.cl" name="email" required>
                    </div>
              </div><!-- End FILA -->

              <div class="row justify-content-md-center mb-0"><!-- FILA  -->
                <div class="input-group input-group-sm mb-3 col-4">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Tipo de Viaje</label>
                  </div>
                  <select wire:model.defer="trip" class="custom-select custom-select-sm" id="inputGroupSelect01">
                    <option value="" selected>Seleccione...</option>
                    <option value="Ida y Vuelta">Ida y Vuelta</option>
                    <option value="Solo Ida">Solo Ida</option>
                  </select>
                </div>
                <div class="input-group input-group-sm mb-3 col-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Origen</span>
                  </div>
                  <input wire:model.defer="origin" name="origin" type="text" class="form-control">
                </div>
                <div class="input-group input-group-sm mb-3 col-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Destino</span>
                  </div>
                  <input wire:model.defer="destiny" name="destiny" type="text" class="form-control">
                </div>
              </div><!-- End FILA -->

              <div class="row justify-content-md-center mb-0"><!-- FILA  -->
                    <div class="input-group input-group-sm mb-3 col-4">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Fecha Ida</span>
                      </div>
                        <input wire:model.defer="departureDate" type="datetime-local" class="form-control form-control-sm" id="fordeparture_date" name="departureDate" required>
                    </div>
                    <div class="input-group input-group-sm mb-3 col-4">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Fecha Regreso</span>
                      </div>
                        <input wire:model.defer="fromDate" type="datetime-local" class="form-control form-control-sm" id="forfrom_date" name="fromDate" required>
                    </div>
                    <div class="input-group input-group-sm mb-3 col-4">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Tipo de Equipaje</label>
                      </div>
                        <select wire:model.defer="baggage" class="custom-select custom-select-sm" id="forbaggage" name="baggage" title="Seleccione..." data-live-search="true" data-size="5" required>
                            <option value="" selected>Seleccione...</option>
                            <option value="Bolso de Mano">Bolso de Mano</option>
                            <option value="Equipaje de Cabina">Equipaje de Cabina</option>
                            <option value="Equipaje de Bodega">Equipaje de Bodega</option>
                            <option value="Equipaje Sobredimensionado">Equipaje Sobredimensionado</option>
                        </select>
                    </div>
                </div><!-- End FILA -->

                <div class="row justify-content-md-end mt-0"><!-- FILA Botones-->
                  <div class="col-2">
                    @if($edit)
                    <button type="button" wire:click="updateTicket" class="btn btn-primary btn-sm float-right">Editar Item</button>
                    @else
                    <button type="button" wire:click="addTicket" class="btn btn-primary btn-sm float-right">Agregar Ticket</button>
                    @endif
                  </div>
                  <div class="col-1">
                    <button type="button" wire:click="cleanTicket" class="btn btn-secondary btn-sm float-right">Cancelar</button>
                  </div>
                </div><!-- FILA Botones-->
                @if (count($errors) > 0 and !$errors->has('program') and !$errors->has('justification') and !$errors->has('items'))
                 <div class="row justify-content-around mt-0">
                    <div class="alert alert-danger col-6 mt-1">
                     <p>Corrige los siguientes errores:</p>
                        <ul>
                            @foreach ($errors->all() as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                 </div>
                @endif

          </div>
        </div><!-- Card para agregar Items  -->
<!--*************************************************************************************************************************-->

        <div class="mx-3 mb-3 mt-3 pt-0"> <!-- DIV para TABLA-->
          <h5 class="card-subtitle mt-0 mb-2 text-muted">Pasajes Aéreos:</h5>
          <table class="table table-condensed table-hover table-bordered table-sm small">
            <thead>
              <tr>
                <th>Item</th>
                <th>Run</th>
                <th>Nombres y Apellidos</th>
                <th>Fecha de Nacimiento</th>
                <th>Teléfono</th>
                <th>E-mail</th>
                <th>Tipo de Viaje</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Fecha Ida</th>
                <th>Fecha Regreso</th>
                <th>Tipo Equipaje</th>
                <th colspan="2">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $key => $item)
                      <tr>
                          <td>{{$key+1}}</td>
                          <td>{{$item['run']."-".$item['dv']}}</td>
                          <td>{{$item['names']." ".$item['fathersName']." ".$item['mothersName']}}</td>
                          <td>{{$item['birthDay']}}</td>
                          <td>{{$item['telephoneNumber']}}</td>
                          <td>{{$item['email']}}</td>
                          <td>{{$item['trip']}}</td>
                          <td>{{$item['origin']}}</td>
                          <td>{{$item['destiny']}}</td>
                          <td>{{$item['departureDate']}}</td>
                          <td>{{$item['fromDate']}}</td>
                          <td>{{$item['baggage']}}</td>
                          <td align="center">
                            <a class="btn btn-outline-secondary btn-sm" title="Editar" wire:click="editTicket({{ $key }})"><i class="fas fa-pencil-alt"></i></a>
                          </td>
                          <td align="center">
                            <a class="btn btn-outline-secondary btn-sm" title="Eliminar" wire:click="deleteTicket({{ $key }})"><i class="far fa-trash-alt"></i></a>
                          </td>
                      </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <td colspan="8" rowspan="2"></td>
                <td colspan="3">Cantidad de Items</td>
                <td colspan="3">{{count($items)}}</td>
              </tr>
            </tfoot>
          </table>
        </div><!-- DIV para TABLA-->

        <div class="row mx-1 mb-4 mt-0 pt-0 px-0">
            <div class="col">
                <a wire:click="cleanTicket" class="btn btn-secondary float-right">Cancelar</a>
                <button  wire:click="saveTicketRequest"  class="btn btn-primary float-right mr-3" type="button"><i class="fas fa-save"></i> Enviar</button>
            </div>
        </div>

        @if (count($errors) > 0 and ($errors->has('program') or $errors->has('justification') or $errors->has('items')))
         <div class="row justify-content-around mt-0">
            <div class="alert alert-danger col-6 mt-1">
             <p>Corrige los siguientes errores:</p>
                <ul>
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
         </div>
        @endif

    </div><!-- Card Body -->
  </div><!-- Card Principal -->
</div><!-- Live Wire -->
