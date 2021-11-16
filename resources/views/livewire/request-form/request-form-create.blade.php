<div>
    <div class="card">
        <div class="card-header">
            </i> Formulario de Requerimiento</h6>
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
                    <div>
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-sm-4">
                    <label>Mecanismo de Compra:</label><br>
                    <select wire:model="purchaseMechanism" name="purchaseMechanism" class="form-control form-control-sm" required>
                      <option>Seleccione...</option>
                      @foreach($lstPurchaseMechanism as $val)
                          <option value="{{$val->id}}">{{$val->name}}</option>
                      @endforeach
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

                <fieldset class="form-group col-sm-4">
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
                </fieldset>
            </div>
        </div>
    </div>

    <br>

    <!-- <div class="card">
        <div class="card-header">
          </i><i class="fas fa-paperclip"></i> Adjuntos</h6>
        </div>
        <div class="card-body">
          @foreach($messagePM as $nameFile)

          <div class="form-row">
                  <div class="col-sm-6">
                    <label for="for_fileName">{{ $nameFile }}</label>
                  </div>
                  <div class="col-sm-6">
                    <input class="form-control form-control-sm" wire:model.defer="fileRequests" type="file" style="padding:2px 0px 0px 2px;" name="fileRequests" required>
                  </div>
          </div>
          @endforeach
        </div>
    </div> -->

    <br>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-cart-plus"></i> {{ $title }}</h5>
            <div class="form-row">
                <fieldset class="form-group col-sm-3">
                    <label for="forRut">Artículo:</label>
                    <input wire:model.defer="article" name="article" class="form-control form-control-sm" type="text" value="{{$article}}">
                </fieldset>

                <fieldset class="form-group col-sm-3">
                  <label>Unidad de Medida:</label><br>
                  <select wire:model.defer="unitOfMeasurement" name="unitOfMeasurement" class="form-control form-control-sm" required>
                      <option value="">Seleccione...</option>
                      @foreach($lstUnitOfMeasurement as $val)
                        <option value="{{$val->name}}">{{$val->name}}</option>
                      @endforeach
                  </select>
                </fieldset>

                <fieldset class="form-group col-sm-2">
                    <label for="forRut">Cantidad:</label>
                    <input wire:model.defer="quantity" name="quantity" class="form-control form-control-sm" type="text">
                </fieldset>

                <fieldset class="form-group col-sm-2">
                    <label for="for_type_of_currency">Tipo de Moneda:</label>
                    <select wire:model.defer="typeOfCurrency" name="typeOfCurrency" class="form-control form-control-sm" required>
                        <option value="">Seleccione...</option>
                        <option value="peso">Peso</option>
                        <option value="dolar">Dolar</option>
                        <option value="uf">U.F.</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-sm-2">
                    <label for="for_unit_value">Valor Unitario:</label>
                    <input wire:model.defer="unitValue" name="unitValue" class="form-control form-control-sm" type="text">
                </fieldset>
            </div>
            <div class="form-row">
                  <fieldset class="form-group col-sm-5">
                      <label for="exampleFormControlTextarea1" class="form-label">Especificaciones Técnicas:</label>
                      <textarea wire:model.defer="technicalSpecifications" name="technicalSpecifications" class="form-control" rows="2"></textarea>
                  </fieldset>
                  <fieldset class="form-group col-sm-3">
                      <label>Tipo de Impuestos:</label><br>
                      <select wire:model.defer="taxes" name="taxes" class="form-control form-control-sm" required>
                        <option value="">Seleccione...</option>
                        <option value="iva">I.V.A. 19%</option>
                        <option value="bh">Boleta de Honorarios 11.75%</option>
                        <option value="srf">S.R.F Zona Franca 0%</option>
                        <option value="e">Excento 0%</option>
                        <option value="nd">No Definido</option>
                      </select>
                  </fieldset>
                  <fieldset class="form-group col-sm-4">
                      <label class="form-label">Documento Informativo (optativo):</label>
                      <input class="form-control form-control-sm" type="file" style="padding:2px 0px 0px 2px;" wire:model.defer="articleFile" name="articleFile">
                  </fieldset>
            </div>
        </div>
    </div>

    <br>

    <div class="row justify-content-md-end mt-0"><!-- FILA 5 -->
        <div class="col-2">
          @if($edit)
            <button type="button" wire:click="updateRequestService" class="btn btn-primary btn-sm float-right">Editar Item</button>
          @else
            <button type="button" wire:click="addRequestService" class="btn btn-primary btn-sm float-right"><i class="fas fa-cart-plus"></i> Agregar</button>
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

    <br>

    <div class="table-responsive">
        <table class="table table-striped table-sm small" name="items">
            <thead>
                <tr class="bg-light">
                    <th class="brd-l">Item</th>
                    <th>Artículo</th>
                    <th>UM</th>
                    <th>Especificaciones Técnicas</th>
                    <!-- <th>Archivo</th> -->
                    <th style="text-align:right">Cantidad</th>
                    <th style="text-align:right">Valor U.</th>
                    <th>Impuestos</th>
                    <th style="text-align:right">Total Item</th>
                    <th style="text-align:center" colspan="2" class="brd-r">Acciones</th>
                </tr>
            </thead>
            <tbody>
              @foreach($items as $key => $item)
                <tr>
                    <td class="brd-l">{{$key+1}}</td>
                    <td>{{$item['article']}}</td>
                    <td>{{$item['unitOfMeasurement']}}</td>
                    <td>{{$item['technicalSpecifications']}}</td>
                    <!-- <td>{{-- $item['articleFile'] --}}</td> -->
                    <td style="text-align:right">{{ $item['quantity'] }}</td>
                    <td style="text-align:right">{{ number_format($item['unitValue'],0,",",".") }}</td>
                    <td>{{$item['taxes']}}</td>
                    <td align="right">{{ number_format($item['totalValue'],0,",",".") }}</td>
                    <td align="center" class="brd-l brd-b">
                        <a href="#items" class="text-info" title="Editar" wire:click="editRequestService({{ $key }})"><i class="fas fa-pencil-alt"></i></a>
                    </td>
                    <td class="brd-r brd-b" align="center">
                        <a href="#items" class="text-danger" title="Eliminar" wire:click="deleteRequestService({{ $key }})"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" rowspan="2"></td>
                    <td colspan="2">Valor Total</td>
                    <td colspan="1" style="text-align:right">{{ number_format($totalDocument,0,",",".") }}</td>
                    <td colspan="2"></td>
                </tr>
                <!-- <tr>
                    <td class="brd-b" colspan="2">Cantidad de Items</td>
                    <td class="brd-b" colspan="1" style="text-align:right">{{count($items)}}</td>
                    <td colspan="2" class="brd-b"></td>
                </tr> -->
            </tfoot>
        </table>
    </div>

    <div class="row justify-content-md-end mt-0">
        <!-- <div class="col-2">
            <button wire:click="btnCancelRequestForm"  class="btn btn-secondary btn-sm float-right">Cancelar</button>
        </div> -->
        <div class="col-2">
            <button wire:click="saveRequestForm"  class="btn btn-primary btn-sm float-right " type="button">
                <i class="fas fa-save"></i> Guardar
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
</div>
