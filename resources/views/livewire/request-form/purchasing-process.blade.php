
<div><!-- LIVEWIRE -->
    {{-- Because she competes with no one, no one can compete with her. --}}


    <div class="container-fluid row mx-0 mb-3 mt-3 pt-0"> <!-- DIV para TABLA-->
      <table class="table table-condensed table-sm small">
          <tr>
              <th class="text-muted col-3" scope="row">Gasto Estimado</th>
              <td class="col-3">{{ $requestForm->estimatedExpense() }}</td>
              <th class="text-muted col-3" scope="row">Nombre del Solicitante</th>
              <td class="col-3">{{ $requestForm->creator->tinnyName()}}</td>
          </tr>
          <tr>
              <th class="text-muted col-3 align-middle">Unidad Organizacional</th>
              <td class="col-3 align-middle">{{ $requestForm->organizationalUnit->getInitialsAttribute() }}</td>
              <th class="text-muted col-3 align-middle">Mecanismo de Compra</th>
              <td class="col-3 align-middle">
                  <select wire:model="purchaseMechanism" name="purchaseMechanism" class="form-control form-control-sm" required>
                    <option>Seleccione...</option>
                    @foreach($lstPurchaseMechanism as $val)
                      <option value="{{$val->id}}">{{$val->name}}</option>
                    @endforeach
                  </select>
              </td>
          </tr>
          <tr>
              <th class="text-muted col-3">Programa Asociado</th>
              <td class="col-3">{{ $requestForm->program }}</td>
              <th class="text-muted col-3">Folio Requerimiento SIGFE</th>
              <td class="col-3">{{ $requestForm->sigfe }}</td>
          </tr>
          <tr>
              <th class="text-muted col-3">Justificación de Adquisición</th>
              <td class="col-3">{{ $requestForm->justification }}</td>
              <th class="text-muted col-3">Fecha de Creación</th>
              <td class="col-3">{{ $requestForm->createdDate() }}</td>
          </tr>
          <tr>
              <th class="text-muted col-3">Archivos</th>
              <td class="col-3">FILE01 - FILE02 - FILE03 - FILE04</td>
              <th class="text-muted col-3">Tiempo transcurrido</th>
              <td class="col-3">{{ $requestForm->getElapsedTime() }}</td>
          </tr>
          <tr>
              <th class="text-muted col-3">Aprobación Abastecimiento</th>
              <td class="col-3">{{ $requestForm->eventSignatureDate('supply_event', 'approved') }}</td>
              <th class="text-muted col-3">Visador Abastecimiento</th>
              <td class="col-3">{{ $requestForm->eventSignerName('supply_event', 'approved') }}</td>
          </tr>
          <tr>
              <th class="text-muted col-3 align-middle">Tipo de Compra</th>
              <td class="col-3 align-middle">
                <select wire:model.defer="purchaseType" wire:click="resetError" name="purchaseType" class="form-control form-control-sm" required>
                    <option value="">Seleccione...</option>
                  @foreach($lstPurchaseType as $type)
                    <option value="{{$type->id}}">{{$type->name}}</option>
                  @endforeach
                </select>
              </td>
              <th class="text-muted col-3 align-middle">Unidad de Compra</th>
              <td class="col-3 align-middle">
                <select wire:model.defer="purchaseUnit" wire:click="resetError" name="purchaseUnit" class="form-control form-control-sm" required>
                    <option value="">Seleccione...</option>
                  @foreach($lstPurchaseUnit as $unit)
                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                  @endforeach
                </select>
              </td>
          </tr>
          <tr>
              <th class="text-muted col-3"></th>
              <td class="col-3"></td>
              <th class="text-muted col-3"></th>
              <td class="col-3"></td>
          </tr>
      </table>
    </div><!-- div para TABLA -->

    <div class="row mx-0 mb-3 mt-3 pt-0"> <!-- DIV para TABLA ITEMS-->
      <h6 class="card-subtitle mt-0 mb-2 text-primary">Lista de Bienes y/o Servicios:</h6>
      <table class="table table-sm small">
        <thead>
          <tr class="bgTableTittle">
            <th class="brd-l">Item</th>
            <th>ID</th>
            <th>Cod.Presup.</th>
            <th>Artículo</th>
            <th>UM</th>
            <th>Especificaciones Técnicas</th>
            <th>Archivo</th>
            <th>Cantidad</th>
            <th>Valor U.</th>
            <th>Impuestos</th>
            <th>Total Item</th>
            <th class="text-center brd-l">E</th>
            <th class="text-center">O</th>
            <th class="text-center brd-r">D</th>
          </tr>
        </thead>
        <tbody>

          @foreach($requestForm->itemRequestForms as $key => $item)

                @if($key >> 0 && $arrayVista[$key])
                  <thead>
                    <tr class="bgTableTittle">
                      <th class="brd-l">Item</th>
                      <th>ID</th>
                      <th>Cod.Presup.</th>
                      <th>Artículo</th>
                      <th>UM</th>
                      <th>Especificaciones Técnicas</th>
                      <th>Archivo</th>
                      <th>Cantidad</th>
                      <th>Valor U.</th>
                      <th>Impuestos</th>
                      <th>Total Item</th>
                      <th class="text-center brd-l">E</th>
                      <th class="text-center">O</th>
                      <th class="text-center brd-r">D</th>
                    </tr>
                  </thead>
                @endif

                  <tr class="{{$arrayBgTable[$key]}}">
                      <td class="align-middle brd-l">{{ $key+1 }}</td>
                      <td class="align-middle">{{ $item->id }}</td>
                      <td class="align-middle">{{ $item->budgetItem()->first()->fullName() }}</td>
                      <td class="align-middle">{{ $item->article }}</td>
                      <td class="align-middle">{{ $item->unit_of_measurement }}</td>
                      <td class="align-middle">{{ $item->specification }}</td>
                      <td class="align-middle">FILE</td>
                      <td class="align-middle" align='right'>{{ $item->quantity }}</td>
                      <td class="align-middle" align='right'>{{ $item->unit_value }}</td>
                      <td class="align-middle">{{ $item->tax }}</td>
                      <td class="align-middle" align='right'>{{ $item->formatExpense() }}</td>
                      <td class="align-middle brd-l" align='center'>
                        <a href="#{{$key}}" title="Editar Item {{$key+1}}" class="text-primary" wire:click="btnShowMe({{$key}})">
                          <i class="fas fa-pencil-alt"></i>
                        </a>
                      </td>
                      <td align='center'><input type="radio" wire:model="radioSource" wire:click="selectRadioButton({{$key}})" name="radioSource" id="{{'sour_'.$item->id}}" value="{{ $key+1 }}"></td>
                      <td align='center'><input type="checkbox" wire:model="arrayCheckBox.{{ $key }}.value"  wire:click="selectCheckBox({{$key}})" id="{{'dest_'.$item->id}}" value="{{ $key+1 }}" {{$checkBoxStatus[$key]}}></td>
                  </tr>

                @if($arrayVista[$key])
                  <tr class="{{$arrayBgTable[$key]}}">
                    <td colspan="14" class="brd-bb  brd-l brd-r">
                      <div class="row mb-3">
                        <div class="col-4">
                            <label class="font-weight-bold text-muted ml-1 mb-0">Mecanismo de Compra:</label>
                            <select wire:model.defer="arrayPurchaseMechanism.{{ $key }}.value" wire:click="resetError" class="form-control form-control-sm" required>
                              <option selected>Seleccione...</option>
                              @foreach($lstPurchaseMechanism as $val)
                              <option value="{{$val->id}}">{{$val->name}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label class="font-weight-bold text-muted ml-1 mb-0">Tipo de Compra:</label>
                            <select wire:model.defer="arrayPurchaseType.{{ $key }}.value" wire:click="resetError" class="form-control form-control-sm" required>
                                <option selected>Seleccione...</option>
                              @foreach($lstPurchaseType as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                              @endforeach
                            </select>
                        </div>

                        <div class="col-4">
                            <label class="font-weight-bold text-muted ml-1 mb-0">Unidad de Compra:</label>
                            <select wire:model.defer="arrayPurchaseUnit.{{ $key }}.value" wire:click="resetError" class="form-control form-control-sm" required>
                                <option selected>Seleccione...</option>
                              @foreach($lstPurchaseUnit as $unit)
                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">ID OC:</label>
                          <input wire:model="idOC.{{ $key }}.value" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">ID OC Interna:</label>
                          <input wire:model="idInternalOC.{{ $key }}.value" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">Fecha OC:</label>
                          <input wire:model="dateOC.{{ $key }}.value" type="date" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">Fecha Envío OC:</label>
                          <input wire:model="shippingDateOC.{{ $key }}.value" type="date" class="form-control form-control-sm" required>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">ID Gran Compra:</label>
                          <input wire:model="idBigBuy.{{ $key }}.value" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">Monto Pesos:</label>
                          <input wire:model="pesoAmount.{{ $key }}.value" class="form-control form-control-sm" type="number">
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">Monto Dólar:</label>
                          <input wire:model="dollarAmount.{{ $key }}.value" class="form-control form-control-sm" type="number">
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">Monto UF:</label>
                          <input wire:model="ufAmount.{{ $key }}.value" class="form-control form-control-sm" type="number">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">Plazo Entrega:</label>
                          <input wire:model="deliveryTerm.{{ $key }}.value" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">Fecha Entrega:</label>
                          <input wire:model="deliveryDate.{{ $key }}.value" type="date" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">ID Licitación:</label>
                          <input wire:model="idOffer.{{ $key }}.value" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">ID Cotización:</label>
                          <input wire:model="idQuotation.{{ $key }}.value" class="form-control form-control-sm" type="text">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">Estado de Compra:</label>
                        </div>
                        <div class="col-3">
                          <select wire:model="status.{{ $key }}.value" class="form-control form-control-sm" required>
                            <option selected>Seleccione...</option>
                            <option value="en_progreso">En progreso</option>
                            <option value="parcial">Recepción Parcial</option>
                            <option value="total">Recepción Total</option>
                            <option value="desierto">Desierto</option>
                            <option value="caducado">Caducado</option>
                          </select>
                        </div>
                      </div>

                    </td>
                  </tr>
                @endif

            @endforeach

        </tbody>
        <tfoot>
          <tr>

            <td class="brd-l brd-r brd-b align-middle" colspan="4" rowspan="2">
              <div class="row mx-0 my-0 px-0 py-0">
                <div class="col-12 mx-0 my-0 px-0 py-0 text-center">
                  <button type="button" class="btn btn-primary btn-sm mr-4" wire:click="showAllItems">Mostrar</button>
                  <button type="button" class="btn btn-primary btn-sm mr-4" wire:click="hideAllItems">Ocultar</button>
                  <button type="button" class="btn btn-primary btn-sm" wire:click="pasteItems">Pegar</button>
                </div>
              </div>
            </td>

            <td class="brd-r brd-b" colspan="4">
              <span class="text-muted">Item de Origen:</span> <span class="text-dark"> {{$radioSource}}</span>
            </td>

            <td colspan="2" align='right'>Valor Total</td>
            <td colspan="1" align='right'>{{$requestForm->estimatedExpense()}}</td>
            <td class="brd-b"></td>
            <td class="brd-b"></td>
            <td class="brd-b brd-r"></td>
          </tr>

          <tr>
            <td class="brd-r brd-b" colspan="4">
              <span class="text-muted">Items de Destino:</span><span class="text-dark"> {{$selectedItems}}</span>
            </td>

            <td class="brd-b" colspan="2" align='right'>Cantidad de Items</td>
            <td class="brd-b" colspan="1" align='right'>{{count($requestForm->itemRequestForms)}}</td>
            <td class="brd-b"></td>
            <td class="brd-b"></td>
            <td class="brd-b brd-r"></td>
          </tr>
        </tfoot>
      </table>
    </div><!-- DIV para TABLA ITEMS-->

</div><!-- LIVEWIRE -->
