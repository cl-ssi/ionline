<form method="POST" class="form-horizontal" action="{{ route('pharmacies.products.dispatch_item.store') }}">
    @csrf

    <div class="row">
        <fieldset class="form-group col-2">
            <label for="for_barcode">Código de Barra</label>
            <input type="number" class="form-control" id="for_barcode" placeholder="" name="barcode">
        </fieldset>

        <input type="hidden" name="dispatch_id" value="{{$dispatch->id}}" />

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


       <fieldset class="form-group col-5">
            <label for="for_serie">F. Vencimiento</label>
            <select id="for_due_date" name="due_date" class="form-control " required="">

            </select>
        </fieldset>

        <fieldset class="form-group col-5">
            <label for="for_lote">Serie/Lote</label>
            <select id="for_batch" name="batch" class="form-control" required="">

            </select>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_count">Disponible</label>
            <input type="text" id="for_count" name="count" class="form-control" disabled>
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
            <th class="text-right">Unity</th>
            <th></th>
        </tr>
        @if ($dispatch->dispatchItems <> NULL)
          @foreach ($dispatch->dispatchItems as $key => $dispatchItems)
            <form method="POST" class="form-horizontal" action="{{ route('pharmacies.products.dispatch_item.destroy',$dispatchItems) }}">
            @csrf
            @method('DELETE')
              <tr>
                  <td class="text-center">{{$dispatchItems->barcode}}</td>
                  <td>{{$dispatchItems->product->name}}</td>
                  <td>{{Carbon\Carbon::parse($dispatchItems->due_date)->format('d/m/Y')}}</td>
                  <td>{{$dispatchItems->amount}}</td>
                  <td>{{$dispatchItems->batch}}</td>
                  <td>{{$dispatchItems->unity}}</td>
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
