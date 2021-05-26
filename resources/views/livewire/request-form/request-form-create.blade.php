<div><!-- LIVEWIRE -->

      <div class="card mx-0">
        @if($editRF)
        <div class="card-header text-primary h6"><i class="far fa-edit"></i> Edición - Formulario de Requerimientos N° {{$requestForm->id}} </div>
        @else
        <h6 class="card-header text-primary">Formulario de Requerimientos</h6>
        @endif
        <div class="card-body mx-0 px-0">
          <div class="row justify-content-md-center mx-0 my-2"><!-- FILA 1 -->
            <div class="form-group col-4">
              <label>Mecanismo de Compra:</label><br>
              <select wire:model="purchaseMechanism" name="purchaseMechanism" class="form-control form-control-sm" required>
                <option value="">Seleccione...</option>
                <option value="cm<1000">Convenio Marco < 1000 UTM</option>
                <option value="cm>1000">Convenio Marco > 1000 UTM</option>
                <option value="lp">Licitación Pública</option>
                <option value="td">Trato Directo</option>
                <option value="ca">Compra Ágil</option>
              </select>
            </div>
           <div class="form-group col-3">
             <label for="forRut">Programa Asociado:</label>
             <input wire:model.defer="program" name="program" class="form-control form-control-sm" type="text" value="">
             @error('program') <span class="error">{{ $message }}</span> @enderror
           </div>
          <div class="form-group col-5">
            <label for="formFileSmxx" class="form-label">Documento de Respaldo:</label>
            <input class="form-control form-control-sm" id="formFileSmxx" type="file" style="padding:2px 0px 0px 2px;" name="fileDoc[]" multiple>
          </div>
          </div><!-- FILA 1 -->
          <div class="row justify-content-start mx-0 my-2">
              <div class="form-group col-6">
                  <label for="exampleFormControlTextarea1" class="form-label">Justificación de Adquisición:</label>
                  <textarea wire:model.defer="justify" name="justify" class="form-control" rows="3"></textarea>
              </div>
              <div class="form-group col-6">
                @if (count($messagePM) > 0)
                    <label>Documentos que debe adjuntar:</label>
                    <div class="alert alert-warning mx-0 my-0 pt-2 pb-0 px-0" role="alert">
                      <ul>
                        @foreach ($messagePM as $val)
                          <li>{{ $val }}</li>
                        @endforeach
                      </ul>
                    </div>
                @endif
              </div>
          </div>
        </div>

           <div class="card mx-3 mb-3 mt-0 pt-0">
             <div class="card-body mb-1">
                 <h6 class="card-subtitle mt-0 mb-2 text-primary">{{$title}}:</h6>
                 <div class="row justify-content-md-center"><!-- FILA 2 -->
                  <div class="form-group col-5">
                    <label for="forRut">Artículo:</label>
                    <input wire:model.defer="article" name="article" class="form-control form-control-sm" type="text" value="{{$article}}">
                  </div>
                  <div class="form-group col-3">
                    <label>Unidad de Medida:</label><br>
                    <select wire:model.defer="unitOfMeasurement" name="unitOfMeasurement" class="form-control form-control-sm" required>
                      <option value="">Seleccione...</option>
                      @foreach($lstUnitOfMeasurement as $val)
                        <option value="{{$val->name}}">{{$val->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-2">
                    <label for="forRut">Cantidad:</label>
                    <input wire:model.defer="quantity" name="quantity" class="form-control form-control-sm" type="text">
                  </div>
                 <div class="form-group col-2">
                   <label for="forRut">Valor Unitario:</label>
                   <input wire:model.defer="unitValue" name="unitValue" class="form-control form-control-sm" type="text">
                 </div>
               </div><!-- FILA 2 -->
               <div class="row justify-content-md-center mb-0"><!-- FILA 3 -->
                  <div class="form-group col-5">
                      <label for="exampleFormControlTextarea1" class="form-label">Especificaciones Técnicas:</label>
                      <textarea wire:model.defer="technicalSpecifications" name="technicalSpecifications" class="form-control" rows="2"></textarea>
                  </div>
                  <div class="form-group col-3">
                    <label>Tipo de Impuestos:</label><br>
                    <select wire:model.defer="taxes" name="taxes" class="form-control form-control-sm" required>
                      <option value="">Seleccione...</option>
                      <option value="iva">I.V.A. 19%</option>
                      <option value="bh">Boleta de Honorarios 11.75%</option>
                      <option value="srf">S.R.F Zona Franca 0%</option>
                      <option value="e">Excento 0%</option>
                      <option value="nd">No Definido</option>
                    </select>
                  </div>
                  <div class="form-group col-4">
                    <label class="form-label">Documento Informativo (optativo):</label>
                    <input class="form-control form-control-sm" type="file" style="padding:2px 0px 0px 2px;" wire:model.defer="fileItem" name="fileItem">
                  </div>
               </div><!-- FILA 3 -->

               <div class="row justify-content-md-start mb-0"><!-- FILA 4 -->
                 <div class="form-group col-5">
                   <label>Item Presupuestario:</label><br>
                   <select wire:model.defer="budget_item_id" name="budget_item_id" class="form-control form-control-sm" required>
                     <option value="">Seleccione...</option>
                     @foreach($lstBudgetItem as $val)
                       <option value="{{$val->id}}">{{$val->code.' - '.$val->name}}</option>
                     @endforeach
                   </select>
                 </div>
               </div>

               <div class="row justify-content-md-end mt-0"><!-- FILA 5 -->
                 <div class="col-2">
                   @if($edit)
                   <button type="button" wire:click="updateRequestService" class="btn btn-primary btn-sm float-right">Editar Item</button>
                   @else
                   <button type="button" wire:click="addRequestService" class="btn btn-primary btn-sm float-right">Agregar Item</button>
                   @endif
                 </div>
                 <div class="col-1">
                   <button type="button" wire:click="cancelRequestService" class="btn btn-secondary btn-sm float-right">Cancelar</button>
                 </div>
               </div><!-- FILA 5 --><!--Valida la variable error para que solo contenga validación de los Items-->
               @if (count($errors) > 0 and !$errors->has('program') and !$errors->has('justify') and !$errors->has('purchaseMechanism') and !$errors->has('items'))
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
            </div><!-- CARD BODY-->
          </div><!-- CARD -->

        <div class="mx-3 mb-3 mt-3 pt-0"> <!-- DIV para TABLA-->
          <h6 class="card-subtitle mt-0 mb-2 text-primary">Items - Bienes y/o Servicios:</h6>
          <table class="table table-condensed table-hover table-bordered table-sm small">
            <thead>
              <tr>
                <th>Item</th>
                <th>Item Pres.</th>
                <th>Artículo</th>
                <th>UM</th>
                <th>Especificaciones Técnicas</th>
                <th>Archivo</th>
                <th>Cantidad</th>
                <th>Valor U.</th>
                <th>Impuestos</th>
                <th>Total Item</th>
                <th colspan="2">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $key => $item)
                      <tr>
                          <td>{{$key+1}}</td>
                          <td>{{$lstBudgetItem->find($item['budget_item_id'])->code.' - '.$lstBudgetItem->find($item['budget_item_id'])->name}}</td>
                          <td>{{$item['article']}}</td>
                          <td>{{$item['unitOfMeasurement']}}</td>
                          <td>{{$item['technicalSpecifications']}}</td>
                          <td>fileItem</td>
                          <td>{{$item['quantity']}}</td>
                          <td>{{$item['unitValue']}}</td>
                          <td>{{$item['taxes']}}</td>
                          <td>{{$item['totalValue']}}</td>
                          <td align="center">
                            <a class="btn btn-outline-primary btn-sm" title="Editar" wire:click="editRequestService({{ $key }})"><i class="fas fa-pencil-alt"></i></a>
                          </td>
                          <td align="center">
                            <a class="btn btn-outline-danger btn-sm" title="Eliminar" wire:click="deleteRequestService({{ $key }})"><i class="far fa-trash-alt"></i></a>
                          </td>
                      </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <td colspan="6" rowspan="2"></td>
                <td colspan="3">Cantidad de Items</td>
                <td colspan="3">{{count($items)}}</td>
              </tr>
              <tr>
                <td colspan="3">Valor Total</td>
                <td colspan="3">{{$totalDocument}}</td>
              </tr>
            </tfoot>
          </table>
        </div><!-- DIV para TABLA-->

        <div class="row mx-1 mb-4 mt-0 pt-0 px-0">
            <div class="col">
                <a href="#"
                    class="btn btn-secondary float-right">Cancelar
                </a>
                <button  wire:click="saveRequestForm"  class="btn btn-primary float-right mr-3" type="button">
                    <i class="fas fa-save"></i> Enviar
                </button>
            </div>
        </div>

        @if (count($errors) > 0 and ($errors->has('purchaseMechanism') or $errors->has('program') or $errors->has('justify') or $errors->has('items')))
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
       </div><!-- CARD PRINCIPAL-->

 </div><!-- LIVEWIRE -->
