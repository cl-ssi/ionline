<div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-cart-plus"></i> {{ $title }}</h5>
            <!-- EXCLUSIVO PARA PLAN DE COMPRA (FUNCIONA CON BOOTSTRAP V5) -->
            @if($bootstrap == 'v5')
            {{-- dd($savedItems) --}}

            <form class="row g-3">
                <fieldset class="form-group col-sm-4">
                    <label class="form-label" for="product-search">Buscar Producto o Servicio</label>
                    <input wire:model.live.debounce.500ms="search_product" id="product-search" class="form-control form-control-sm" type="text">
                </fieldset>

                <fieldset class="form-group col-sm-8">
                    <label class="form-label" for="product-id">Producto o Servicio</label>
                    @livewire('unspsc.product-search', ['smallInput' => true, 'showCode' => true])
                </fieldset>
            </form>
            
            <br>

            <form class="row g-3">
                <div class="col-md-6">
                    <fieldset class="form-group col-12">
                        <label class="form-label" for="technicalSpecifications" >Especificaciones Técnicas</label>
                        <textarea class="form-control form-control-sm" wire:model="technicalSpecifications" name="technicalSpecifications" rows="4"></textarea>
                    </fieldset>
                </div>

                <div class="col-md-6">
                    <div class="row g-3">
                        <fieldset class="form-group col-4 mb-2">
                            <label class="form-label">Unidad de Medida</label>
                            <select wire:model="unitOfMeasurement" name="unitOfMeasurement" class="form-select form-select-sm" required>
                                <option value="">Seleccione...</option>
                                @foreach($lstUnitOfMeasurement as $val)
                                    <option value="{{$val->name}}">{{$val->name}}</option>
                                @endforeach
                            </select>
                        </fieldset>

                        <fieldset class="form-group col-4">
                            <label class="form-label" for="forRut">Cantidad</label>
                            <input wire:model="quantity" name="quantity" class="form-control form-control-sm" type="text">
                        </fieldset>

                        <fieldset class="form-group col-4">
                            <label class="form-label" for="for_unit_value">Valor Unitario Neto</label>
                            <input wire:model="unitValue" name="unitValue" class="form-control form-control-sm" type="text">
                        </fieldset>
                    </div>

                    <div class="row g-3">
                        <fieldset class="form-group col-4">
                            <label class="form-label">Tipo de Impuestos</label>
                            <select wire:model="taxes" name="taxes" class="form-select form-select-sm" required>
                                <option value="">Seleccione...</option>
                                <option value="iva">I.V.A. 19%</option>
                                <option value="bh">Boleta de Honorarios {{isset($this->withholding_tax[date('Y')]) ? $this->withholding_tax[date('Y')] * 100 : end($this->withholding_tax) * 100 }}%</option>
                                <option value="srf">S.R.F Zona Franca 0%</option>
                                <option value="e">Exento 0%</option>
                                <option value="nd">No Definido</option>
                            </select>
                        </fieldset>
                        @if($form != 'purchase_plan')
                        <fieldset class="form-group col-8">
                            <label class="form-label">Documento Informativo (optativo)
                                @if($savedArticleFile)
                                <a class="text-info" href="#items" wire:click="deleteFile({{$key}})">Borrar <i class="fas fa-paperclip"></i></a>
                                @endif
                            </label>
                            <input class="form-control form-control-sm" type="file" style="padding:2px 0px 0px 2px;" wire:model="articleFile" name="articleFile" id="upload{{ $iteration }}" @if($savedArticleFile) disabled @endif>
                            <div wire:loading wire:target="articleFile">Cargando archivo...</div>
                        </fieldset>
                        @endif
                    </div>
                </div>
            </form>

            <br>

            <form class="row g-3">
                <div class="col-12">
                    @if($edit)
                        <button type="button" wire:click="updateItem" class="btn btn-primary btn-sm float-end" wire:target="articleFile" wire:loading.attr="disabled">Editar Item</button>
                    @else
                        <button type="button" wire:click="addItem" class="btn btn-primary btn-sm float-end" wire:target="articleFile" wire:loading.attr="disabled"><i class="fas fa-cart-plus"></i> Agregar</button>
                    @endif
                </div>
                <div class="col-12">
                    <button type="button" wire:click="cleanItem" class="btn btn-outline-secondary btn-sm float-end">Cancelar</button>
                </div>
            </form>

            @else
            <!-- EXCLUSIVO PARA ABASTECIMIENTO (FUNCIONA CON BOOTSTRAP V4.6) -->
            <div class="form-row">
                {{-- dd($savedItems) --}}
                <fieldset class="form-group col-sm-4">
                    <label for="product-search">Buscar Producto o Servicio</label>
                    <input wire:model.live.debounce.500ms="search_product" id="product-search" class="form-control form-control-sm" type="text">
                </fieldset>

                <fieldset class="form-group col-sm-8">
                    <label for="product-id">Debe Seleccionar un Producto o Servicio del listado (obligatorio)</label>
                    @livewire('unspsc.product-search', ['smallInput' => true, 'showCode' => true])
                </fieldset>
            </div>

            <div class="form-row">
                <div class="col-6">
                    <div class="form-row">
                        <fieldset class="form-group col-sm-12">
                            <label for="technicalSpecifications" class="form-label">Especificaciones Técnicas:</label>
                            <textarea wire:model="technicalSpecifications" name="technicalSpecifications" class="form-control form-control-sm" rows="5"></textarea>
                        </fieldset>
                    </div>
                </div>

                <div class="col-6">

                    <div class="form-row">
                        <fieldset class="form-group col-sm-4">
                            <label>Unidad de Medida:</label><br>
                            <select wire:model="unitOfMeasurement" name="unitOfMeasurement" class="form-control form-control-sm" required>
                                <option value="">Seleccione...</option>
                                @foreach($lstUnitOfMeasurement as $val)
                                    <option value="{{$val->name}}">{{$val->name}}</option>
                                @endforeach
                            </select>
                        </fieldset>

                        <fieldset class="form-group col-sm-3">
                            <label for="forRut">Cantidad:</label>
                            <input wire:model="quantity" name="quantity" class="form-control form-control-sm" type="text">
                        </fieldset>

                        <!-- <fieldset class="form-group col-sm-2">
                            <label for="for_type_of_currency">Tipo de Moneda:</label>
                            <select wire:model="typeOfCurrency" name="typeOfCurrency" class="form-control form-control-sm" required>
                                <option value="">Seleccione...</option>
                                <option value="peso">Peso</option>
                                <option value="dolar">Dolar</option>
                                <option value="uf">U.F.</option>
                            </select>
                        </fieldset> -->

                        <fieldset class="form-group col-sm-5">
                            <label for="for_unit_value">Valor Unitario Neto:</label>
                            <input wire:model="unitValue" name="unitValue" class="form-control form-control-sm" type="text">
                        </fieldset>
                    </div>
                    <div class="form-row">

                        <fieldset class="form-group col-sm-4">
                            <label>Tipo de Impuestos:</label><br>
                            <select wire:model="taxes" name="taxes" class="form-control form-control-sm" required>
                            <option value="">Seleccione...</option>
                            <option value="iva">I.V.A. 19%</option>
                            <option value="bh">Boleta de Honorarios {{isset($this->withholding_tax[date('Y')]) ? $this->withholding_tax[date('Y')] * 100 : end($this->withholding_tax) * 100 }}%</option>
                            <option value="srf">S.R.F Zona Franca 0%</option>
                            <option value="e">Exento 0%</option>
                            <option value="nd">No Definido</option>
                            </select>
                        </fieldset>

                        <fieldset class="form-group col-sm-8">
                            <label class="form-label">Documento Informativo (optativo):
                                @if($savedArticleFile)
                                <a class="text-info" href="#items" wire:click="deleteFile({{$key}})">Borrar <i class="fas fa-paperclip"></i></a>
                                @endif
                            </label>
                            <input class="form-control form-control-sm" type="file" style="padding:2px 0px 0px 2px;" wire:model="articleFile" name="articleFile" id="upload{{ $iteration }}" @if($savedArticleFile) disabled @endif>
                            <div wire:loading wire:target="articleFile">Cargando archivo...</div>
                        </fieldset>

                    </div>
                </div>
            </div>

            <div class="row justify-content-md-end mt-0"><!-- FILA 5 -->
                <div class="col-2">
                @if($edit)
                    <button type="button" wire:click="updateItem" class="btn btn-primary btn-sm float-right" wire:target="articleFile" wire:loading.attr="disabled">Editar Item</button>
                @else
                    <button type="button" wire:click="addItem" class="btn btn-primary btn-sm float-right" wire:target="articleFile" wire:loading.attr="disabled"><i class="fas fa-cart-plus"></i> Agregar</button>
                @endif
                </div>
                <div class="col-1">
                    <button type="button" wire:click="cleanItem" class="btn btn-outline-secondary btn-sm float-right">Cancelar</button>
                </div>
            </div><!-- FILA 5 --><!--Valida la variable error para que solo contenga validación de los Items-->
            @endif
        </div>
    </div>

    @if (count($errors) > 0 and !$errors->has('program') and !$errors->has('justify') and !$errors->has('purchaseMechanism') and !$errors->has('items') and !$errors->has('balance'))
        <div class="alert alert-danger mt-5">
          <p>Corrige los siguientes errores:</p>
             <ul>
                 @foreach ($errors->all() as $message)
                     <li>{{ $message }}</li>
                 @endforeach
             </ul>
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
                    <th style="text-align:center">Archivo</th>
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
                    <td>
                        @if($item['product_id'] == null)
                            {{ $item['article'] }}
                        @else
                            {{ $item['product_name'] }}
                        @endif
                    </td>
                    <td>{{$item['unitOfMeasurement']}}</td>
                    <td>{{$item['technicalSpecifications']}}</td>
                    <td style="text-align:center">
                    @if($item['articleFile'])
                    <a href="#items" wire:click="showFile({{$key}})" class="text-link"><i class="fas fa-file"></i></a>
                    @endif
                    </td>
                    <td style="text-align:right">{{ $item['quantity'] }}</td>
                    <td style="text-align:right">{{ str_replace(',00', '', number_format($item['unitValue'], 2,",",".")) }}</td>
                    <td>{{$item['taxes']}}</td>
                    <td align="right">{{ number_format($item['totalValue'],$precision_currency,",",".") }}</td>
                    <td align="center" class="brd-l brd-b">
                        <a href="#items" class="btn btn-info btn-sm" title="Editar" wire:click="editItem({{ $key }})"><i class="fas fa-pencil-alt"></i></a>
                    </td>
                    <td class="brd-r brd-b" align="center">
                        <button 
                            class="btn btn-danger btn-sm" 
                            title="Eliminar" 
                            wire:click.prevent="deleteItem({{ $key }})"
                            wire:loading.attr="disabled"
                            wire:target="deleteItem({{ $key }})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" rowspan="2"></td>
                    <td colspan="2">Valor Total</td>
                    <td colspan="1" style="text-align:right">{{ number_format($totalDocument,$precision_currency,",",".") }}</td>
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
