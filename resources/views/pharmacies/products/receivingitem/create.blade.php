<!-- si no es un ajuste de inventarios, se muestra información para agregar detalles -->
@if(!$receiving->inventory_adjustment_id)
    <form method="POST" class="form-horizontal" action="{{ route('pharmacies.products.receiving_item.store') }}">
        @csrf

        @livewire('pharmacies.product-search')

        <input type="hidden" name="receiving_id" value="{{$receiving->id}}" />

        <div class="form-row">

            <fieldset class="form-group col-1">
                <label for="for_lote"><br></label>
                <button type="button" id="disable_due_date_batch" class="btn btn-primary form-control" title="Utilizar cuando el producto no tenga fecha de vencimiento o lote.">
                    <i class="fa fa-unlock-alt"></i>
                </button>
            </fieldset>

            <fieldset class="form-group col-4">
                <label for="for_due_date">F. Vencimiento</label>
                <input type="date" class="form-control" id="for_due_date" name="due_date" required max="3000-01-01">
            </fieldset>

            <fieldset class="form-group col-4">
                <label for="for_lote">Serie/Lote</label>
                <input type="text" class="form-control" id="for_lote" placeholder="Número de Lote" name="batch" required>
            </fieldset>

            <fieldset class="form-group col-3">
                <label for="for_quantity">Cantidad</label>
                <input type="number" class="form-control" id="for_quantity" placeholder="" name="amount" required="">
            </fieldset>

        </div>

        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
@else
    <div class="alert alert-warning" role="alert">
        Para modificar un ajuste de inventarios, debe dirigirse a esa opción.
    </div>
@endif

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
