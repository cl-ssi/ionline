<div>
    <div class="table-responsive">
      @if($requestForm->type_form == 'Bienes y/o Servicios')
      <h6><i class="fas fa-info-circle"></i> Lista de Bienes y/o Servicios</h6>
      <table class="table table-condensed table-hover table-bordered table-sm small">
          <thead>
              <tr>
                  <th>Item</th>
                  <th>ID</th>
                  <th>Item Pres.</th>
                  <th>Artículo</th>
                  <th>UM</th>
                  <th>Especificaciones Técnicas</th>
                  <th>Archivo</th>
                  <th>Cantidad</th>
                  <th>Valor U.</th>
                  <th>Impuestos</th>
                  <th>Total Item</th>
              </tr>
          </thead>
          <tbody>
            @foreach($requestForm->itemRequestForms as $key => $item)
              <tr>
                  <td class="text-center">{{$key+1}}</td>
                  <td class="text-center">{{$item->id}}</td>
                  <td>
                      <select  wire:model.defer="arrayItemRequest.{{ $item->id }}.budgetId"  wire:click="resetError" class="form-control form-control-sm" required>
                          <option value="">Seleccione...</option>
                          @foreach($lstBudgetItem as $val)
                            <option value="{{$val->id}}">{{$val->code.' - '.$val->name}}</option>
                          @endforeach
                      </select>
                  </td>
                  <td>{{$item->article}}</td>
                  <td>{{$item->unit_of_measurement}}</td>
                  <td>{{$item->specification}}</td>
                  <td align="center">
                    @if($item->article_file)
                      <a href="{{ route('request_forms.show_item_file', $item) }}" target="_blank">
                        <i class="fas fa-file"></i>
                    @endif
                  </td>
                  <td align="right">{{$item->quantity}}</td>
                  <td align="right">${{ number_format($item->unit_value,0,",",".") }}</td>
                  <td>{{$item->tax}}</td>
                  <td align="right">${{ number_format($item->expense,0,",",".") }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
              <tr>
                  <td colspan="5" rowspan="2"></td>
                  <td colspan="3">Valor Total</td>
                  <td colspan="3" align="right">${{ number_format($requestForm->estimated_expense,0,",",".") }}</td>
              </tr>
          </tfoot>
      </table>
      @error('arrayItemRequest') <span class="error text-danger">{{ $message }}</span> @enderror
      @else
      <!-- Pasajeros -->
        <h6><i class="fas fa-info-circle"></i> Lista de Pasajeros</h6>
        <table class="table table-condensed table-hover table-bordered table-sm">
        <thead class="text-center small">
            <tr>
            <th>#</th>
            <th>RUT</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Item Pres.</th>
            <th>Tipo viaje</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Fecha ida</th>
            <th>Fecha vuelta</th>
            <th>Equipaje</th>
            <th>Total pasaje</th>
            </tr>
        </thead>
        <tbody class="small">
            @foreach($requestForm->passengers as $key => $passenger)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ number_format($passenger->run, 0, ",", ".") }}-{{ $passenger->dv }}</td>
                        <td>{{ $passenger->name }}</td>
                        <td>{{ $passenger->fathers_family }} {{ $passenger->mothers_family }}</td>
                        <td>-</td>
                        <td>{{ isset($round_trips[$passenger->round_trip]) ? $round_trips[$passenger->round_trip] : '' }}</td>
                        <td>{{ $passenger->origin }}</td>
                        <td>{{ $passenger->destination }}</td>
                        <td>{{ $passenger->departure_date }}</td>
                        <td>{{ $passenger->return_date }}</td>
                        <td>{{ isset($baggages[$passenger->baggage]) ? $baggages[$passenger->baggage] : '' }}</td>
                        <td align="right">${{ number_format($passenger->unit_value, $requestForm->type_of_currency == 'peso' ? 0 : 2, ",", ".") }}</td>
                    </tr>
            @endforeach
        </tbody>
        <tfoot class="text-right small">
            <tr>
            <td colspan="11">Valor Total</td>
            <td>${{ number_format($requestForm->estimated_expense, $requestForm->type_of_currency == 'peso' ? 0 : 2,",",".") }}</td>
            </tr>
        </tfoot>
        </table>
    @endif

        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-signature"></i></a> Autorización Refrendación Presupuestaria
            </div>
            <div class="card-body">
                <div class="form-row">
                    <fieldset class="form-group col-sm-5">
                        <label for="forRut">Responsable:</label>
                        <input wire:model="userAuthority" name="userAuthority" class="form-control form-control-sm" type="text" readonly>
                    </fieldset>

                    <fieldset class="form-group col-sm-2">
                        <label>Cargo:</label><br>
                        <input wire:model="position" name="position" class="form-control form-control-sm" type="text" readonly>
                    </fieldset>

                    <fieldset class="form-group col-sm-5">
                        <label for="forRut">Unidad Organizacional:</label>
                        <input wire:model="organizationalUnit" name="organizationalUnit" class="form-control form-control-sm" type="text" readonly>
                    </fieldset>
                </div>
                <div class="form-row">
                    <fieldset class="form-group col-sm-6">
                        <label for="forRut">Folio Requerimiento SIGFE:</label>
                        <input wire:model="sigfe" name="sigfe" wire:click="resetError" class="form-control form-control-sm" type="text">
                        @error('sigfe') <span class="error text-danger">{{ $message }}</span> @enderror
                    </fieldset>

                    <fieldset class="form-group col-sm-6">
                      <label>Programa Asociado:</label><br>
                      <input wire:model="program" name="program" wire:click="resetError" class="form-control form-control-sm" type="text">
                      @error('program') <span class="error text-danger">{{ $message }}</span> @enderror
                    </fieldset>
                </div>



                <div class="form-row">
                    <fieldset class="form-group col-sm-12">
                        <label for="forRejectedComment">Comentario de Rechazo:</label>
                        <textarea wire:model="rejectedComment" wire:click="resetError" name="rejectedComment" class="form-control form-control-sm" rows="3"></textarea>
                        @error('rejectedComment') <span class="error text-danger">{{ $message }}</span> @enderror
                        </fieldset>
                </div>

                <div class="row justify-content-md-end mt-0">
                    <div class="col-2">
                        <button type="button" wire:click="acceptRequestForm" class="btn btn-primary btn-sm float-right">Autorizar</button>
                    </div>
                    <div class="col-1">
                        <button type="button" wire:click="rejectRequestForm" class="btn btn-secondary btn-sm float-right">Rechazar</button>
                    </div>
                </div>
            </div>
        </div>

</div>
