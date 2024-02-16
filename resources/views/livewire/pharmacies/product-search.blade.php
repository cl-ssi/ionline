<div>
    <div class="form-row">
        <fieldset class="form-group col-2">
            <label for="for_barcode">Código producto</label>

            @if($defer_active)
                <input type="text" class="form-control" id="for_barcode_defer" placeholder="" name="barcode" wire:model.defer="barcode_defer" required>
            @else
                <input type="text" class="form-control" id="for_barcode" placeholder="" name="barcode" wire:model.debounce.300ms="barcode" required>
            @endif
            
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_experto_id">Código experto</label>
            <input type="text" class="form-control" id="for_experto_id" placeholder="" name="experto_id" wire:model="experto_id" required>
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_product">Producto</label>
            <select id="for_product" class="form-control" name="product_id" wire:model="product_id" wire:change="change">
                <option></option>
                @foreach ($products as $key => $product)
                <option value="{{$product->id}}">{{$product->name}}</option>
                @endforeach
            </select>
            @if($experto_id)
                <button type="button" wire:click="toggleSecondDiv" class="btn btn-sm btn-primary">Editar nombre del producto</button>
            @endif
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_quantity">Cantidad</label>
            <input type="number" class="form-control" id="for_quantity" placeholder="" name="amount" required="">
        </fieldset>

        <input type="hidden" id="for_unity" name="unity" wire:model.defer="unity"/>
    </div>

    <div style="{{ $showSecondDiv ? '' : 'display: none' }};" class="form-row">
        <fieldset class="form-group col-2">
            
        </fieldset>

        <fieldset class="form-group col-2">
            
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_barcode">Modificar nombre producto</label>
            <input type="text" class="form-control" name="name" wire:model="product_name">
        </fieldset>
    </div>
</div>
