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
                    <option value="">Seleccione...</option>
                    <option value="cm<1000">Convenio Marco < 1000 UTM</option>
                    <option value="cm>1000">Convenio Marco > 1000 UTM</option>
                    <option value="lp">Licitación Pública</option>
                    <option value="td">Trato Directo</option>
                    <option value="ca">Compra Ágil</option>
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

    <div class="row mx-0 mb-3 mt-3 pt-0"> <!-- DIV para TABLA-->
      <h6 class="card-subtitle mt-0 mb-2 text-primary">Lista de Bienes y/o Servicios: {{$radioSource}}</h6>
      <table class="table table-sm small">
        <thead>
          <tr class="bgTableTittle">
            <th>Item</th>
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
                @if($key >> 0 && $arrayVista[$key]['value'])
                  <thead>
                    <tr class="bgTableTittle">
                      <th>Item</th>
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
                  <tr class="{{$arrayBgTable[$key]['value']}}">
                      <td class="align-middle">{{ $key+1 }}</td>
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
                        <a href="#{{$key}}" title="Editar Item {{$key+1}}" class="text-primary" wire:click="showMe({{$key}})">
                          <i class="fas fa-pencil-alt"></i>
                        </a>
                      </td>
                      <td align='center'><input type="radio" wire:model="radioSource" name="radioSource" id="{{'sour_'.$item->id}}" value="{{$item->id}}"></td>
                      <td align='center'><input type="checkbox" id="{{'dest_'.$item->id}}" name="{{$item->id}}" value="{{$item->id}}" {{$checkStatus[$key]}}></td>
                  </tr>
                  @if($arrayVista[$key]['value'])
                  <tr class="{{$arrayBgTable[$key]['value']}}">
                    <td colspan="14" class="brd-bb">
                      <div class="row mb-3">
                        <div class="col-4">
                            <label class="font-weight-bold text-muted ml-1 mb-0">Mecanismo de Compra:</label><br>
                            <select wire:model.defer="arrayPurchaseMechanism.{{ $item->id }}.value" wire:click="resetError" class="form-control form-control-sm" required>
                              <option selected>Seleccione...</option>
                              <option value="cm<1000">Convenio Marco < 1000 UTM</option>
                              <option value="cm>1000">Convenio Marco > 1000 UTM</option>
                              <option value="lp">Licitación Pública</option>
                              <option value="td">Trato Directo</option>
                              <option value="ca">Compra Ágil</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label class="font-weight-bold text-muted ml-1 mb-0">Tipo de Compra:</label><br>
                            <select wire:model.defer="arrayPurchaseType.{{ $item->id }}.value" wire:click="resetError" class="form-control form-control-sm" required>
                                <option selected>Seleccione...</option>
                              @foreach($lstPurchaseType as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                              @endforeach
                            </select>
                        </div>

                        <div class="col-4">
                            <label class="font-weight-bold text-muted ml-1 mb-0">Unidad de Compra:</label><br>
                            <select wire:model.defer="arrayPurchaseUnit.{{ $item->id }}.value" wire:click="resetError" class="form-control form-control-sm" required>
                                <option selected>Seleccione...</option>
                              @foreach($lstPurchaseUnit as $unit)
                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">ID OC:</label><br>
                          <input value="" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">ID OC Excel:</label><br>
                          <input value="" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">Fecha OC:</label><br>
                          <input type="date" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">Fecha Envío OC:</label><br>
                          <input type="date" class="form-control form-control-sm" required>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">ID Gran Compra:</label><br>
                          <input value="" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">Monto Pesos:</label><br>
                          <input value="" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">Monto Dólar:</label><br>
                          <input value="" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">Monto UF:</label><br>
                          <input value="" class="form-control form-control-sm" type="text">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">Plazo Entrega: OC:</label><br>
                          <input value="" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">Fecha Entrega:</label><br>
                          <input type="date" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">ID Licitación:</label><br>
                          <input value="" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="col-3">
                          <label class="font-weight-bold text-muted ml-1 mb-0">ID Cotización:</label><br>
                          <input value="" class="form-control form-control-sm" type="text">
                        </div>
                      </div>

                    </td>
                  </tr>
                  @endif
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="8" rowspan="2"></td>
            <td colspan="2" align='right'>Cantidad de Items</td>
            <td colspan="2" align='right'>{{count($requestForm->itemRequestForms)}}</td>
          </tr>
          <tr>
            <td colspan="2" align='right'>Valor Total</td>
            <td colspan="2" align='right'>{{$requestForm->estimatedExpense()}}</td>
          </tr>
        </tfoot>
      </table>
    </div><!-- DIV para TABLA-->

</div><!-- LIVEWIRE -->
