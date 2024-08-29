<div class="form-row">  
        
        <fieldset class="form-group col-4">
            <label for="for_product_id">Productos</label>
            <div wire:ignore id="for-bootstrap-select">
                <select name="product_id" class="form-control selectpicker" data-container="#for-bootstrap-select" data-live-search="true" wire:model="product_id" wire:change="product_id_change" required>
                    <option value=""></option>
                    @foreach($products as $product)
                        <option value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
            </div>
        </fieldset>
    

        <fieldset class="form-group col-3">
            <label for="for_serie">F. Vencimiento - Lote</label>
            <select id="for_due_date" name="due_date_batch" class="form-control" required wire:model.live="due_date_batch" wire:change="due_date_batch_change">
                <option></option>
                @foreach($batchs as $key => $batch)
                <option value="{{$batch->id}}">{{$batch->due_date->format('Y-m-d')}} - {{$batch->batch}}</option>
                @endforeach
            </select>
        </fieldset>
        
        <fieldset class="form-group col-2">
            <label for="for_count">Stock disponible</label>
            <input type="text" class="form-control" id="for_count" disabled wire:model="count">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_amount">Nuevo valor</label>
            <input type="hidden" name="count" value="{{$count}}">
            <input type="text" class="form-control" id="for_amount" name="amount">
        </fieldset>

        <fieldset class="form-group col-1">
            <label for="for_amount"><br></label>
            <input type="hidden" name="count" value="{{$count}}">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </fieldset>
	</div>
