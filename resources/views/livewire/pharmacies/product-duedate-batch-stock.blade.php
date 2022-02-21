<div>
  <div class="row">
      <fieldset class="form-group col-2">
          <label for="for_barcode">Código de Barra</label>
          <input type="number" class="form-control" id="for_barcode" placeholder="" name="barcode" wire:keydown.enter="foo" wire:model="barcode" >
      </fieldset>

      <input type="hidden" name="dispatch_id" value="{{$dispatch->id}}" />

      <fieldset class="form-group col">
          <label for="for_product">Producto</label>
          <select id="for_product" class="form-control" name="product_id" wire:model.lazy="product_id" required="">
              <option></option>
            @foreach ($products as $key => $product)
              <option value="{{$product->id}}">{{$product->name}}</option>
            @endforeach
          </select>
      </fieldset>

      <fieldset class="form-group col-2">
          <label for="for_quantity">Cantidad</label>
          <input type="number" class="form-control" id="for_quantity" placeholder="" name="amount" required="">
      </fieldset>

      <input type="hidden" id="for_unity" name="unity" value="{{$unity}}" />

  </div>

  <div class="row">


     <fieldset class="form-group col-10">
          <label for="for_serie">F. Vencimiento - Lote</label>
          <select id="for_due_date" name="due_date_batch" class="form-control " required="" wire:model.lazy="due_date_batch">
            <option></option>
            @foreach($array as $key => $value)
              <option>{{$key}}</option>
            @endforeach
          </select>
      </fieldset>

      <!-- <fieldset class="form-group col-5">
          <label for="for_lote">Serie/Lote</label>
          <select id="for_batch" name="batch" class="form-control" required="">

          </select>
      </fieldset> -->

      <fieldset class="form-group col-2">
          <label for="for_count">Disponible</label>
          <input type="text" id="for_count" name="count" class="form-control" disabled value="{{$count}}">
      </fieldset>

  </div>
</div>
