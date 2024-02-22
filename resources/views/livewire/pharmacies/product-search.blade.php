<div>
    <div class="form-row">
        <fieldset class="form-group col-3">
            <label for="for_barcode">Código producto</label>

            @if($defer_active)
                <input type="text" class="form-control" id="for_barcode_defer" placeholder="" name="barcode" wire:model.defer="barcode_defer" required>
            @else
                <input type="text" class="form-control" id="for_barcode" placeholder="" name="barcode" wire:model.debounce.300ms="barcode" required>
            @endif
            
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_experto_id">Código experto</label>
            <input type="text" class="form-control" id="for_experto_id" placeholder="" name="experto_id" wire:model="experto_id">
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_product">Producto</label>
            <div wire:ignore id="for-bootstrap-select">
                <select id="for_product" class="form-control selectpicker" data-live-search="true" data-container="#for-bootstrap-select" 
                        name="product_id" wire:model.defer="product_id" wire:change="change" required>
                    <option></option>
                    @foreach ($products as $key => $product)
                    <option value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
            </div>
            @if($experto_id)
                <button type="button" wire:click="toggleSecondDiv" class="btn btn-sm btn-primary">Editar nombre del producto</button>
            @endif
        </fieldset>

        <!-- <div wire:ignore id="for-bootstrap-select">
            <select name="product_id" class="form-control selectpicker" data-container="#for-bootstrap-select" data-live-search="true" wire:model.defer="product_id" wire:change="product_id_change" required>
                <option value=""></option>
                @foreach($products as $product)
                    <option value="{{$product->id}}">{{$product->name}}</option>
                @endforeach
            </select>
        </div> -->

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
