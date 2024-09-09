<div>
    <div class="form-row">
        <fieldset class="form-group col-2">
            <label for="for_barcode">Código de Barra</label>
            <input type="text" class="form-control" id="for_barcode" placeholder="" name="barcode" wire:keydown.enter="foo" wire:model.live="barcode" >
        </fieldset>

        <input type="hidden" name="dispatch_id" value="{{$dispatch->id}}" />

        <fieldset  class="form-group col-8">
        <label for="for_product">Producto</label>
        <div class="input-group">
            <input
                type="text"
                class="form-control"
                placeholder="Nombre Funcionario"
                aria-label="Nombre"
                wire:keydown.escape="resetx"
            @if(!$product)
                wire:model.live.debounce.1000ms="query"
                required
            @else
                wire:model.live.debounce.1000ms="selectedName"
                disabled readonly
            @endif
            />

            <div class="input-group-append">
                <a class="btn btn-outline-secondary" wire:click="resetx">
                    <i class="fas fa-eraser"></i> Limpiar</a>
            </div>
        </div>
        
        @if($product)
            <input type="text" value="{{ $product->id }}"  style="display:none;" wire:model.blur="product_id">
            <input type="hidden" name="product_id" value="{{$product->id}}"> 
        @endif
        
        @if(!empty($query))
            <ul class="list-group col-12" style="z-index: 3; position: absolute;">
                @if( count($products) >= 1 )
                    @foreach($products as $product)
                        <a wire:click="setProduct({{$product->id}})" wire:click.prevent="addSearchedProduct({{ $product }})"
                            class="list-group-item list-group-item-action"
                        >{{ $product->name }} </a>
                    @endforeach
                @elseif($msg_too_many)
                    <div class="list-group-item list-group-item-info">Hemos encontrado muchas coincidencias</div>
                @else
                    <div class="list-group-item list-group-item-warning">No hay resultados</div>
                @endif
            </ul>
        @endif
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_quantity">Cantidad</label>
            <input type="number" class="form-control" id="for_quantity" placeholder="" name="amount" required="">
        </fieldset>

        <input type="hidden" id="for_unity" name="unity" value="{{$unity}}" />

    </div>

    <div class="form-row">

        <fieldset class="form-group col-10">
            <label for="for_serie">F. Vencimiento - Lote</label>
            <select id="for_due_date" name="due_date_batch" class="form-control " required="" wire:model.change="due_date_batch">
                <option></option>
                @foreach($array as $key => $value)
                    <option>{{$key}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_count">Disponible</label>
            <input type="text" id="for_count" name="count" class="form-control" disabled value="{{$count}}">
        </fieldset>

    </div>
</div>
