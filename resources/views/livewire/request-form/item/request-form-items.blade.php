<div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-cart-plus"></i> {{ $title }}</h5>
            <div class="form-row">
                <fieldset class="form-group col-sm-5">
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

                <!-- <fieldset class="form-group col-sm-2">
                    <label for="for_type_of_currency">Tipo de Moneda:</label>
                    <select wire:model.defer="typeOfCurrency" name="typeOfCurrency" class="form-control form-control-sm" required>
                        <option value="">Seleccione...</option>
                        <option value="peso">Peso</option>
                        <option value="dolar">Dolar</option>
                        <option value="uf">U.F.</option>
                    </select>
                </fieldset> -->

                <fieldset class="form-group col-sm-2">
                    <label for="for_unit_value">Valor Unitario Neto:</label>
                    <input wire:model.defer="unitValue" name="unitValue" class="form-control form-control-sm" type="text">
                </fieldset>
            </div>
            <div class="form-row">
                  <fieldset class="form-group col-sm-5">
                      <label for="exampleFormControlTextarea1" class="form-label">Especificaciones Técnicas:</label>
                      <textarea wire:model.defer="technicalSpecifications" name="technicalSpecifications" class="form-control form-control-sm" rows="2"></textarea>
                  </fieldset>
                  <fieldset class="form-group col-sm-3">
                      <label>Tipo de Impuestos:</label><br>
                      <select wire:model.defer="taxes" name="taxes" class="form-control form-control-sm" required>
                        <option value="">Seleccione...</option>
                        <option value="iva">I.V.A. 19%</option>
                        <option value="bh">Boleta de Honorarios {{isset($this->withholding_tax[date('Y')]) ? $this->withholding_tax[date('Y')] * 100 : end($this->withholding_tax) * 100 }}%</option>
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
            <button type="button" wire:click="updateItem" class="btn btn-primary btn-sm float-right">Editar Item</button>
          @else
            <button type="button" wire:click="addItem" class="btn btn-primary btn-sm float-right"><i class="fas fa-cart-plus"></i> Agregar</button>
          @endif
        </div>
        <div class="col-1">
            <button type="button" wire:click="cleanItem" class="btn btn-secondary btn-sm float-right">Cancelar</button>
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
                        <a href="#items" class="text-info" title="Editar" wire:click="editItem({{ $key }})"><i class="fas fa-pencil-alt"></i></a>
                    </td>
                    <td class="brd-r brd-b" align="center">
                        <a href="#items" class="text-danger" title="Eliminar" wire:click="deleteItem({{ $key }})"><i class="far fa-trash-alt"></i></a>
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
</div>
