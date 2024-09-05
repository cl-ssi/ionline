<div>
    <div class="form-row">
        <fieldset class="form-group col-3">
            <label for="for_barcode">Código producto</label>

            @if($defer_active)
                <input type="text" class="form-control" id="for_barcode_defer" placeholder="" name="barcode" wire:model="barcode_defer" required>
            @else
                <input type="text" class="form-control" id="for_barcode" placeholder="" name="barcode" wire:model.live.debounce.300ms="barcode" required>
            @endif
            
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_experto_id">Código experto</label>
            <input type="text" class="form-control" id="for_experto_id" placeholder="" name="experto_id" wire:model.live="experto_id">
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_product">Producto</label>
                <div>
                    <select id="for_product" class="form-control" name="product_id" wire:model="product_id" wire:change="change" required>
                        <option></option>
                        @foreach ($products as $key => $product_item)
                        <option value="{{$product_item->id}}">{{$product_item->name}}</option>
                        @endforeach
                    </select>
                </div>
            @if($experto_id)
                <button type="button" wire:click="toggleSecondDiv" class="btn btn-sm btn-primary">Editar nombre del producto</button>
            @endif
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_experto_id"><i>Filtro producto</i></label>
            <input type="text" class="form-control" placeholder="" wire:model.live="filtro_producto">
        </fieldset>

        <input style="display:none" id="for_unity" name="unity" wire:model="unity"/>
    </div>

    <div style="{{ $showSecondDiv ? '' : 'display: none' }};" class="form-row">
        <fieldset class="form-group col-2">
            
        </fieldset>

        <fieldset class="form-group col-2">
            
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_barcode">Modificar nombre producto</label>
            <input type="text" class="form-control" name="name" wire:model.live="product_name">
        </fieldset>
    </div>
</div>
