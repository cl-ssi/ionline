<form method="POST" class="form-horizontal" action="{{ route('pharmacies.products.receiving_item.store') }}">
    @csrf

    <div class="row">
        <fieldset class="form-group col-2">
            <label for="for_barcode">Código de Barra</label>
            <input type="number" class="form-control" id="for_barcode" placeholder="" name="barcode">
        </fieldset>

        <input type="hidden" name="receiving_id" value="{{$receiving->id}}" />

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
            <input type="number" class="form-control" id="for_quantity" placeholder="" name="amount" required="">
        </fieldset>

        <input type="hidden" id="for_unity" name="unity" />

    </div>

    <div class="row">
        <fieldset class="form-group col">
            <label for="for_serie">F. Vencimiento</label>
            <input type="date" class="form-control" id="for_date" name="due_date" required="required">
        </fieldset>

        <fieldset class="form-group col">
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
            <th class="text-center">Producto</th>
            <th class="text-center">F.Venc.</th>
            <th class="text-center">Cantidad</th>
            <th class="text-center">Serie</th>
            <th class="text-center"></th>
            <th></th>
        </tr>
        @if ($receiving->receivingItems <> NULL)
          @foreach ($receiving->receivingItems as $key => $receivingItems)
            <form method="POST" class="form-horizontal" action="{{ route('pharmacies.products.receiving_item.destroy',$receivingItems) }}">
            @csrf
            @method('DELETE')
              <tr>
                  <td class="text-center">{{$receivingItems->barcode}}</td>
                  <td>{{$receivingItems->product->name}}</td>
                  <td>{{Carbon\Carbon::parse($receivingItems->due_date)->format('d/m/Y')}}</td>
                  <td>{{$receivingItems->amount}}</td>
                  <!--<td class="text-right">{{$receivingItems->serial_number}}</td>-->
                  <td>{{$receivingItems->batch}}</td>
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
