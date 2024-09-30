<div> <!-- Live Wire -->
    <div class="card">
        <div class="card-header">
        <h6> Ingreso de Pasajeros</h6>
        </div>
        <div class="card-body">
            <div class="form-row">
                <fieldset class="form-group col-2">
                    <label for="for_passengerType">Tipo Pasajero</label>
                    <select wire:model.live="passengerType" name="passengerType" class="form-control">
                        <option value="">Seleccione...</option>
                        <option value="internal">Servicio de Salud</option>
                        <option value="external">Externo</option>
                    </select>
                </fieldset>

                @if($passengerType == 'internal')
                    <fieldset class="form-group col-6">
                        <label for="for_user_id">Funcionario*</label>
                        @livewire('search-select-user', [
                            'emit_name' => 'searchedPassenger']
                        )
                    </fieldset>
                @elseif($passengerType == 'external')
                    <fieldset class="form-group">
                        <div class="alert alert-info alert-sm mt-4 ml-2" role="alert">
                            <b>Estimado Usuario</b>: Ud. ha seleccionado compra para un usuario o funcionario no registrado.
                        </div>
                    </fieldset>
                @else

                @endif
          </div>

          <hr>
          <br>

          <h6>Datos de Pasajero</h6>

          <!-- <form wire:submit="submit"> -->

              <div class="form-row">
                    @if($passengerType == 'internal')
                        <fieldset class="form-group col-sm-3">
                            <label for="forName">Run</label>
                            <input wire:model.live="run" name="name" class="form-control form-control-sm" type="text"
                            value="{{ $run }}" readonly>
                        </fieldset>

                        <fieldset class="form-group col-sm-1">
                            <label for="forRut">DV</label>
                            <input wire:model.live="dv" name="dv" class="form-control form-control-sm" type="text"
                            value="{{ $dv }}" readonly>
                        </fieldset>
                    @else
                        <fieldset class="form-group col-sm-2">
                            <label for="forDocumentType">Tipo Documento</label>
                            <select wire:model.live="document_type"
                                name="document_type" 
                                class="form-control form-control-sm" 
                                {{ $inputsInternalPassengers }}>
                                <option value="" selected>Seleccione...</option>
                                <option value="identity card">Cédula</option>
                                <option value="passport">Pasaporte</option>
                                <option value="dni other">DNI u Otro</option>
                            </select>
                        </fieldset>
                        
                        <fieldset class="form-group col-sm-2">
                            <label for="forName">Nro. Documento</label>
                            <input wire:model.live="document_number" 
                                placeholder="xx.xxx.xxx-x" 
                                name="name" 
                                class="form-control form-control-sm" 
                                type="text"
                            value="{{ $run }}" {{ $inputsInternalPassengers }}>
                        </fieldset>
                    @endif

                    <fieldset class="form-group col-sm-4">
                        <label for="forRut">Nombres</label>
                        <input wire:model.live="name" name="name" class="form-control form-control-sm" type="text"
                          value="{{ $name }}" {{ $inputsInternalPassengers }}>
                    </fieldset>

                    <fieldset class="form-group col-sm-2">
                        <label for="forRut">Apellido Paterno</label>
                        <input wire:model.live="fathers_family" name="fathers_family" class="form-control form-control-sm" type="text"
                          value="{{ $fathers_family }}" {{ $inputsInternalPassengers }}>
                    </fieldset>

                    <fieldset class="form-group col-sm-2">
                        <label for="forRut">Apellido Materno</label>
                        <input wire:model.live="mothers_family" name="mothers_family" class="form-control form-control-sm" type="text"
                          value="{{ $mothers_family }}" {{ $inputsInternalPassengers }}>
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
                        <select wire:model.live="round_trip" name="round_trip" class="form-control form-control-sm">
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
                    <fieldset class="form-group col-sm-3">
                        <label for="for_departure_date">Fecha/Hora Ida</label>
                        <input wire:model="departure_date" name="departure_date" class="form-control form-control-sm" type="datetime-local">
                    </fieldset>

                    <fieldset class="form-group col-sm-3">
                        <label for="for_return_date">Fecha/Hora Vuelta</label>
                        <input wire:model="return_date" name="return_date" class="form-control form-control-sm" type="datetime-local" {{$round_trip == 'one-way only' ? 'disabled' : ''}}>
                    </fieldset>

                    <fieldset class="form-group col-sm-3">
                        <label for="for_baggage">Tipo de Viaje</label>
                        <select wire:model.live="baggage" name="baggage" class="form-control form-control-sm">
                          <option value="" selected>Seleccione...</option>
                          <option value="handbag">Bolso de Mano</option>
                          <option value="hand luggage">Equipaje de Cabina</option>
                          <option value="baggage">Equipaje de Bodega</option>
                          <option value="oversized baggage">Equipaje Sobredimensionado</option>
                        </select>
                    </fieldset>

                    <fieldset class="form-group col-sm-3">
                        <label for="for_origin">Valor Estimado</label>
                        <input wire:model="unitValue" name="unit_value" class="form-control form-control-sm" type="number">
                    </fieldset>
                </div>

                <div class="row justify-content-md-end mt-0">
                    <div class="col-2">
                        @if($edit)
                          <button class="btn btn-primary btn-sm float-right" type="button"
                            wire:click="updatePassenger">Editar Pasajero</button>
                        @else
                          <button class="btn btn-primary btn-sm float-right" type="button"
                            wire:click="addPassenger">Agregar Pasajero</button>
                        @endif
                    </div>
                    <div class="col-1">
                        <button class="btn btn-secondary btn-sm float-right" type="button"
                          wire:click="cleanPassenger">Cancelar</button>
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
                    <!-- <th>Item</th> -->
                    <th>Run / Nro. Documento</th>
                    <th>Nombres y Apellidos</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Teléfono</th>
                    <th>E-mail</th>
                    <th>Tipo de Viaje</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Fecha Ida/Regreso</th>
                    <th>Tipo Equipaje</th>
                    <th>Valor</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
              @foreach($passengers as $key => $item)
                      <tr>
                          <!-- <td>{{$key+1}}</td> -->
                          <td>
                                {{ ($item['passenger_type'] == 'internal') ? $item['run']."-".$item['dv'] : $item['document_number'] }}
                          </td>
                          <td>{{$item['name']." ".$item['fathers_family']." ".$item['mothers_family']}}</td>
                          <td>{{ Carbon\Carbon::parse($item['birthday'])->format('d-m-Y') }}</td>
                          <td>{{$item['phone_number']}}</td>
                          <td>{{$item['email']}}</td>
                          <td>
                            @switch($item['round_trip'])
                                @case('round trip')
                                    Ida, vuelta
                                    @break

                                @case('one-way only')
                                    Ida
                                    @break

                                @default
                                  ''
                            @endswitch
                          </td>
                          <td>{{$item['origin']}}</td>
                          <td>{{$item['destination']}}</td>
                          <td>{{ Carbon\Carbon::parse($item['departure_date'])->format('d-m-Y H:i') }} /<br>
                              {{ $item['return_date'] ? Carbon\Carbon::parse($item['return_date'])->format('d-m-Y H:i') : 'sin retorno' }}
                          </td>
                          <td>
                            @switch($item['baggage'])
                                @case('handbag')
                                    Bolso de Mano
                                    @break

                                @case('hand luggage')
                                    Equipaje de Cabina
                                    @break

                                @case('baggage')
                                    Equipaje de Bodega
                                    @break

                                @case('oversized baggage')
                                    Equipaje Sobredimensionado
                                    @break

                                @default
                                  ''
                            @endswitch
                          </td>
                          <td>{{ number_format($item['unitValue'],$precision_currency,",",".") }}</td>
                          <td align="center">
                            <a class="btn btn-outline-secondary btn-sm" title="Editar"
                              wire:click="editPassenger({{ $key }})">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                          </td>
                          <td align="center">
                            <a class="btn btn-outline-secondary btn-sm" title="Eliminar"
                              wire:click="deletePassenger({{ $key }})">
                                <i class="far fa-trash-alt"></i>
                              </a>
                          </td>
                      </tr>
                @endforeach
              </tbody>
          <tfoot>
              <tr>
                  <td colspan="10" rowspan="2"></td>
                  <th colspan="2" class="text-right">Total</th>
                  <td colspan="2">{{ number_format($totalValue,$precision_currency,",",".") }}</td>
              </tr>
          </tfoot>
    </table>
    </div>
</div>
