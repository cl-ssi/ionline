<!-- si no es un ajuste de inventarios, se muestra información para agregar detalles -->
@if(!$fractionation->inventory_adjustment_id)
    <form method="POST" class="form-horizontal" action="{{ route('pharmacies.products.fractionation_item.store') }}">
        @csrf

        @livewire('pharmacies.fractionation-product-duedate-batch-stock',['fractionation' => $fractionation])

        <button type="submit" class="btn btn-primary" @disabled($fractionation->inventory_adjustment_id)>Guardar</button>
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
            <th class="text-right">Unity</th>
            <th></th>
        </tr>
        @if ($fractionation->items <> NULL)
          @foreach ($fractionation->items as $key => $items)
            <form method="POST" class="form-horizontal" action="{{ route('pharmacies.products.fractionation_item.destroy',$items) }}">
            @csrf
            @method('DELETE')
              <tr>
                  <td class="text-center">{{$items->barcode ? $items->barcode : 'Sin asignar'}}</td>
                  <td>{{$items->product->name}}</td>
                  <td>{{Carbon\Carbon::parse($items->due_date)->format('d/m/Y')}}</td>
                  <td>{{$items->amount}}</td>
                  <td>{{$items->batch}}</td>
                  <td>{{$items->unity}}</td>
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
