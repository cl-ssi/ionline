<div> <!-- Live Wire -->
    <div class="card">
        <div class="card-header">
        <h6> Ingreso de Pasajeros</h6>
        </div>
        <div class="card-body">
            <div class="form-row">
                <fieldset class="form-group col-2">
                    <label for="for_passengerType">Pasajero</label>
                    <select wire:model="passengerType" name="passengerType" class="form-control" disabled>
                        <option value="">Seleccione...</option>
                        <option value="internal">SSI</option>
                        <option value="external">Externo</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-6">
                    <label for="for_user_id">Funcionario*</label>
                    @livewire('search-select-user', [
                        'emit_name' => 'searchedPassenger'])
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
                        <input wire:model.defer="origin" name="origin" class="form-control form-control-sm" type="text">
                    </fieldset>

                    <fieldset class="form-group col-sm-4">
                        <label for="for_destination">Destino</label>
                        <input wire:model.defer="destination" name="destination" class="form-control form-control-sm" type="text">
                    </fieldset>
                </div>

                <div class="form-row">
                    <fieldset class="form-group col-sm-3">
                        <label for="for_departure_date">Fecha/Hora Ida</label>
                        <input wire:model="departure_date" name="departure_date" class="form-control form-control-sm" type="datetime-local">
                    </fieldset>

                    <fieldset class="form-group col-sm-3">
                        <label for="for_return_date">Fecha/Hora Vuelta</label>
                        <input wire:model="return_date" name="return_date" class="form-control form-control-sm" type="datetime-local">
                    </fieldset>

                    <fieldset class="form-group col-sm-3">
                        <label for="for_baggage">Tipo de Viaje</label>
                        <select wire:model="baggage" name="baggage" class="form-control form-control-sm">
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
                    <th>Run</th>
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
                          <td>{{$item['run']."-".$item['dv']}}</td>
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
                          <td>{{ Carbon\Carbon::parse($item['departure_date'])->format('d-m-Y H:i') }} <br>
                              {{ Carbon\Carbon::parse($item['return_date'])->format('d-m-Y H:i') }}
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
