<form method="POST" class="form-horizontal" action="{{ route('pharmacies.products.purchase_item.store') }}">
    @csrf

    <div class="row">
        <fieldset class="form-group col-2">
            <label for="for_barcode">Código de Barra</label>
            <input type="number" class="form-control" id="for_barcode" placeholder="Código de barra" name="barcode">
        </fieldset>

        <input type="hidden" name="purchase_id" value="{{$purchase->id}}" />

        <fieldset class="form-group col">
            <label for="for_product">Producto</label>
            <select id="for_product" class="form-control" name="product_id" onchange="jsCambiaSelect(this)">
                <option></option>
              @foreach ($products as $key => $product)
                <option value="{{$product->id}}">{{$product->name}}</option>
              @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_quantity">Cantidad</label>
            <input type="number" class="form-control" id="for_quantity" placeholder="Cantidad" name="amount" required="">
        </fieldset>

        <input type="hidden" id="for_unity" name="unity" />
    </div>

    <div class="row">
        <fieldset class="form-group col-4">
            <label for="for_unit_cost">Precio</label>
            <input type="number" class="form-control" id="for_unit_cost" placeholder="Precio" name="unit_cost" required="">
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_serie">F. Vencimiento</label>
            <input type="date" class="form-control" id="for_date" name="due_date" required="required">
        </fieldset>

        <!--<fieldset class="form-group col-3">
            <label for="for_serie">Serie</label>
            <input type="text" class="form-control" id="for_serie" placeholder="Número de Serie" name="serial_number" required="">
        </fieldset>-->

        <fieldset class="form-group col-4">
            <label for="for_lote">Serie/Lote</label>
            <input type="text" class="form-control" id="for_lote" placeholder="Número de Lote" name="batch" required="">
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Crear</button>
</form>

<br class="m-5">

<table class="table">
    <thead>
        <tr>
            <th class="text-center">Código de barra</th>
            <th>Producto</th>
            <th class="text-right">Cantidad</th>
            <th class="text-right">F.Venc.</th>
            <th class="text-right">Serie/Lote</th>
            <th></th>
        </tr>
        @if ($purchase->purchaseItems <> NULL)
          @foreach ($purchase->purchaseItems as $key => $purchaseItems)
            <form method="POST" class="form-horizontal" action="{{ route('pharmacies.products.purchase_item.destroy',$purchaseItems) }}">
            @csrf
            @method('DELETE')
              <tr>
                  <td class="text-center">{{$purchaseItems->barcode}}</td>
                  <td>{{$purchaseItems->product->name}}</td>
                  <td class="text-right">{{$purchaseItems->amount}}</td>
                  <td class="text-right">{{Carbon\Carbon::parse($purchaseItems->due_date)->format('d/m/Y')}}</td>
                  <td class="text-right">{{$purchaseItems->batch}}</td>
                  <td>
                      <button type="submit" class="btn btn-danger btn-sm">
                          <i class="fas fa-trash"></i>
                      </button>
                  </td>
              </tr>
            </form>
          @endforeach
        @endif
    </thead>
    <tbody>

    </tbody>
</table>
