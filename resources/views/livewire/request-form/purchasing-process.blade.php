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

    <div class="row mx-3 mb-3 mt-3 pt-0"> <!-- DIV para TABLA-->
      <h6 class="card-subtitle mt-0 mb-2 text-primary">Lista de Bienes y/o Servicios:</h6>
      <table class="table table-condensed table-sm small">
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
            <th>Opción</th>
          </tr>
        </thead>
        <tbody>
          @foreach($requestForm->itemRequestForms as $key => $item)
                  <tr class="{{$arrayBgTable[$key]['value']}}">
                      <td>{{ $key+1 }}</td>
                      <td>{{ $item->id }}</td>
                      <td>{{ $item->budgetItem()->first()->fullName() }}</td>
                      <td>{{ $item->article }}</td>
                      <td>{{ $item->unit_of_measurement }}</td>
                      <td>{{ $item->specification }}</td>
                      <td>FILE</td>
                      <td align='right'>{{ $item->quantity }}</td>
                      <td align='right'>{{ $item->unit_value }}</td>
                      <td>{{ $item->tax }}</td>
                      <td align='right'>{{ $item->formatExpense() }}</td>
                      <td><button type="button" class="btn btn-primary btn-sm" wire:click="showMe( {{ $key }} )">mostrear</button></td>
                  </tr>
                  @if($arrayVista[$key]['value'])
                  <tr class="{{$arrayBgTable[$key]['value']}}">
                    <td colspan="12">
                      <div class="row">
                        <div class="col-4">
                            <select wire:model="arrayPurchaseMechanism.{{ $item->id }}.value" wire:click="resetError" class="form-control form-control-sm" required>
                              <option value="">Seleccione...</option>
                              <option value="cm<1000">Convenio Marco < 1000 UTM</option>
                              <option value="cm>1000">Convenio Marco > 1000 UTM</option>
                              <option value="lp">Licitación Pública</option>
                              <option value="td">Trato Directo</option>
                              <option value="ca">Compra Ágil</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <select wire:model.defer="arrayPurchaseType.{{ $item->id }}.value" wire:click="resetError" class="form-control form-control-sm" required>
                                <option value="">Seleccione...</option>
                              @foreach($lstPurchaseType as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <select wire:model.defer="arrayPurchaseUnit.{{ $item->id }}.value" wire:click="resetError" class="form-control form-control-sm" required>
                                <option value="">Seleccione...</option>
                              @foreach($lstPurchaseUnit as $unit)
                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr class="{{$arrayBgTable[$key]['value']}}">
                    <td colspan="12">
                      <div>

                        <div><p><h4>Hola mundo {{$key+1}}</h4></p></div>

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
