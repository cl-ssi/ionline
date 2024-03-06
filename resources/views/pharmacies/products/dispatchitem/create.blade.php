<!-- si no es un ajuste de inventarios, se muestra información para agregar detalles -->
@if(!$dispatch->inventory_adjustment_id)
    <form method="POST" class="form-horizontal" action="{{ route('pharmacies.products.dispatch_item.store') }}">
        @csrf

        @livewire('pharmacies.product-duedate-batch-stock',['dispatch' => $dispatch])

        <button type="submit" class="btn btn-primary" @disabled($dispatch->inventory_adjustment_id)>Guardar</button>
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
