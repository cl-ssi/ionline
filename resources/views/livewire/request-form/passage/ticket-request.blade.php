<div> <!-- Live Wire -->
    <div class="card">
        <div class="card-header">
            </i> Formulario de Cotización de Pasajes Aéreos</h6>
        </div>
        <div class="card-body">
            <div class="form-row">
                <fieldset class="form-group col-sm-4">
                    <label for="forRut">Nombre:</label>
                    <input wire:model.defer="name" name="name" class="form-control form-control-sm" type="text" value="">
                    {{-- @error('name') <span class="error">{{ $message }}</span> @enderror --}}
                </fieldset>

                <fieldset class="form-group col-sm-4">
                    <label>Administrador de Contrato:</label><br>
                    <select wire:model="contractManagerId" name="contractManagerId" class="form-control form-control-sm" required>
                      <option>Seleccione...</option>
                      @foreach($users as $user)
                          <option value="{{ $user->id }}">{{ ucfirst(trans($user->FullName)) }}</option>
                      @endforeach
                    </select>
                </fieldset>

                <fieldset class="form-group col-sm-4">
                    <label for="for_calidad_juridica">Solicitar Autorización de Jefatura Superior</label>
                    <div class="mt-1 ml-4">
                        <input class="form-check-input" type="checkbox" value="1" wire:model="superiorChief" name="superiorChief">
                        <label class="form-check-label" for="flexCheckDefault">
                          Sí
                        </label>
                    </div>
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-sm-4">
                    <label>Mecanismo de Compra:</label><br>
                    <select wire:model="purchaseMechanism" name="purchaseMechanism" class="form-control form-control-sm" required>
                      <option>Seleccione...</option>
                      {{-- @foreach($lstPurchaseMechanism as $val)
                          <option value="{{$val->id}}">{{$val->name}}</option>
                      @endforeach  --}}
                    </select>
                </fieldset>

                <fieldset class="form-group col-sm-4">
                    <label for="forRut">Programa Asociado:</label>
                    <input wire:model.defer="program" name="program" class="form-control form-control-sm" type="text" value="">
                    {{-- @error('program') <span class="error">{{ $message }}</span> @enderror --}}
                </fieldset>

                <fieldset class="form-group col-sm-4">
                    <label for="for_fileRequests" class="form-label">Documento de Respaldo:</label>
                    <input class="form-control form-control-sm" wire:model.defer="fileRequests" type="file" style="padding:2px 0px 0px 2px;" name="fileRequests[]" multiple>
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-sm-8">
                    <label for="exampleFormControlTextarea1" class="form-label">Justificación de Adquisición:</label>
                    <textarea wire:model.defer="justify" name="justify" class="form-control" rows="3"></textarea>
                </fieldset>
            </div>
        </div>
    </div>

    <br>
    <div class="card">
        <div class="card-header">
        <h6> Ingreso de Pasajeros</h6>
        </div>
        <div class="card-body">
            <div class="form-row">
                <fieldset class="form-group col-2">
                    <label for="for_passengerType">Pasajero</label>
                    <select wire:model="passengerType" name="passengerType" class="form-control">
                        <option value="" selected>Seleccione...</option>
                        <option value="internal">SSI</option>
                        <option value="external">Externo</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-6">
                    <label for="for_user_id">Funcionario*</label>
                    @livewire('search-select-user')
                </fieldset>
          </div>

          <hr>
          <br>

          <h6>Datos de Pasajero</h6>

          <!-- <form wire:submit.prevent="submit"> -->

              <div class="form-row">
                    <fieldset class="form-group col-sm-3">
                        <label for="forName">Run</label>
                        <input wire:model="run" name="name" class="form-control form-control-sm" type="text"
                          value="{{ $run }}" readonly>
                    </fieldset>

                    <fieldset class="form-group col-sm-1">
                        <label for="forRut">DV</label>
                        <input wire:model="dv" name="dv" class="form-control form-control-sm" type="text"
                          value="{{ $dv }}" readonly>
                    </fieldset>

                    <fieldset class="form-group col-sm-4">
                        <label for="forRut">Nombres</label>
                        <input wire:model="name" name="name" class="form-control form-control-sm" type="text"
                          value="{{ $name }}" readonly>
                    </fieldset>

                    <fieldset class="form-group col-sm-2">
                        <label for="forRut">Apellido Paterno</label>
                        <input wire:model="fathers_family" name="fathers_family" class="form-control form-control-sm" type="text"
                          value="{{ $fathers_family }}" readonly>
                    </fieldset>

                    <fieldset class="form-group col-sm-2">
                        <label for="forRut">Apellido Materno</label>
                        <input wire:model="mothers_family" name="mothers_family" class="form-control form-control-sm" type="text"
                          value="{{ $mothers_family }}" readonly>
                    </fieldset>
                </div>

                <div class="form-row">
                    <fieldset class="form-group col-sm-4">
                        <label for="forRut">Fecha de Nacimiento</label>
                        <input wire:model="birthday" name="birthday" class="form-control form-control-sm" type="date" value="{{ $birthday ? $birthday : '' }}">
                    </fieldset>

                    <fieldset class="form-group col-sm-4">
                        <label for="for_telephone">Teléfono</label>
                        <input wire:model="phone_number" name="phone_number" class="form-control form-control-sm" type="text" value="{{ $phone_number ? $phone_number : '' }}">
                    </fieldset>

                    <fieldset class="form-group col-sm-4">
                        <label for="for_telephone">E-Mail</label>
                        <input wire:model="email" name="email" class="form-control form-control-sm" type="text" placeholder="correo@redsalud.gob.cl" value="{{ $email ? $email : '' }}">
                    </fieldset>
                </div>

                <div class="form-row">
                    <fieldset class="form-group col-sm-4">
                        <label for="round_trip">Tipo de Viaje</label>
                        <select wire:model="round_trip" name="round_trip" class="form-control form-control-sm">
                            <option value="" selected>Seleccione...</option>
                            <option value="round trip">Ida y Vuelta</option>
                            <option value="one-way only">Solo Ida</option>
                        </select>
                    </fieldset>

                    <fieldset class="form-group col-sm-4">
                        <label for="for_origin">Origen</label>
                        <input wire:model="origin" name="origin" class="form-control form-control-sm" type="text">
                    </fieldset>

                    <fieldset class="form-group col-sm-4">
                        <label for="for_destination">Destino</label>
                        <input wire:model="destination" name="destination" class="form-control form-control-sm" type="text">
                    </fieldset>
                </div>

                <div class="form-row">
                    <fieldset class="form-group col-sm-4">
                        <label for="for_departure_date">Fecha/Hora Ida</label>
                        <input wire:model="departure_date" name="departure_date" class="form-control form-control-sm" type="datetime-local">
                    </fieldset>

                    <fieldset class="form-group col-sm-4">
                        <label for="for_return_date">Fecha/Hora Vuelta</label>
                        <input wire:model="return_date" name="return_date" class="form-control form-control-sm" type="datetime-local">
                    </fieldset>

                    <fieldset class="form-group col-sm-4">
                        <label for="for_baggage">Tipo de Viaje</label>
                        <select wire:model="baggage" name="baggage" class="form-control form-control-sm">
                          <option value="" selected>Seleccione...</option>
                          <option value="handbag">Bolso de Mano</option>
                          <option value="hand luggage">Equipaje de Cabina</option>
                          <option value="baggage">Equipaje de Bodega</option>
                          <option value="oversized baggage">Equipaje Sobredimensionado</option>
                        </select>
                    </fieldset>
                </div>

                <div class="row justify-content-md-end mt-0">
                    <div class="col-2">
                        @if($edit)
                          <button type="button" wire:click="updateTicket" class="btn btn-primary btn-sm float-right">Editar Item</button>
                        @else
                          <button class="btn btn-primary btn-sm float-right" wire:click="addPassenger">Agregar Ticket</button>
                        @endif
                    </div>
                    <div class="col-1">
                        <button type="button" wire:click="cleanTicket" class="btn btn-secondary btn-sm float-right">Cancelar</button>
                    </div>
                </div>

            <!-- </form> -->
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
    </div>

    <br>

    <div class="table-responsive">
        <h6 class="card-subtitle mt-0 mb-2">Lista de Pasajeros:</h6>
        <table class="table table-sm table-striped table-bordered small">
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
                        <td>{{$item['name']." ".$item['fathers_family']." ".$item['mothers_family']}}</td>
                        <td>{{$item['birthday']}}</td>
                        <td>{{$item['phone_number']}}</td>
                        <td>{{$item['email']}}</td>
                        <td>{{$item['round_trip']}}</td>
                        <td>{{$item['origin']}}</td>
                        <td>{{$item['destination']}}</td>
                        <td>{{$item['departure_date']}}</td>
                        <td>{{$item['return_date']}}</td>
                        <td>{{$item['baggage']}}</td>
                        <td align="center">
                          <a class="btn btn-outline-secondary btn-sm" title="Editar" wire:click="editTicket({{ $key }})"><i class="fas fa-pencil-alt"></i></a>
                        </td>
                        <td align="center">
                          <a class="btn btn-outline-secondary btn-sm" title="Eliminar" wire:click="deletePassenger({{ $key }})"><i class="far fa-trash-alt"></i></a>
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
  </div><!-- DIV Table Responsive -->
  </div><!-- DIV para TABLA-->

  <div class="row mx-1 mb-4 mt-0 pt-0 px-0">
      <div class="col">
          <a wire:click="cleanTicket" class="btn btn-secondary float-right">Cancelar</a>
          <button wire:click="savePassengerRequest"  class="btn btn-primary float-right mr-3">
              <i class="fas fa-save"></i> Guardar
          </button>
          <!-- <button wire:click="saveRequestForm"  class="btn btn-primary btn-sm float-right " type="button">
              <i class="fas fa-save"></i> Guardar
          </button> -->
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

</div>
