@extends('layouts.bt4.app')

@section('title', 'Editar ingreso')

@section('content')

@include('pharmacies.nav')

<h3>Editar Ajuste de Inventario</h3>

<div class="form-row">
      <fieldset class="form-group col-3">
          <label for="for_date">Fecha</label>
          <input type="text" class="form-control" id="for_date" value="{{ Carbon\Carbon::parse($inventoryAdjustment->date)->format('d/m/Y')}}" disabled>
      </fieldset>

      <fieldset class="form-group col">
        <label for="for_note">Tipo de ajuste</label>
        <input type="text" class="form-control" id="for_note" value="{{$inventoryAdjustment->type->name}}" disabled>
    </fieldset>

      <fieldset class="form-group col">
        <label for="for_note">Observación</label>
        <input type="text" class="form-control" id="for_note" value="{{$inventoryAdjustment->notes}}" disabled>
    </fieldset>

    <fieldset class="form-group col">
        <label for="for_user">Creador</label>
        <input type="text" class="form-control" id="for_user" value="{{$inventoryAdjustment->user->shortName}}" disabled>
    </fieldset>
</div>

<hr>

<form method="POST" action="{{ route('pharmacies.products.inventory_adjustments.store_detail') }}">
	@csrf

    <input type="hidden" name="inventoryAdjustment_id" value="{{$inventoryAdjustment->id}}">
    @livewire('pharmacies.product-stock-adjustment')

</form>

<hr>

<h2>Detalle</h2>


<table class="table table-striped table-sm" id="tabla_receiving">
    <thead>
        <tr>
            <!-- <th scope="col">id</th> -->
            <th scope="col">Producto</th>
            <th scope="col">F.Vencimiento</th>
            <th scope="col">Lote</th>
            <th scope="col">Valor antiguo</th>
            <th scope="col">Valor nuevo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($inventoryAdjustment->receiving)
            @foreach($inventoryAdjustment->receiving->receivingItems as $key => $item)

                <form method="POST" class="form-horizontal" action="{{ route('pharmacies.products.inventory_adjustments.destroy_receivingItem',$item) }}">
                @csrf
                @method('DELETE')

                    <tr>
                        <!-- <td>{{ $item->id }}</td> -->
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->due_date }}</td>
                        <td>{{ $item->batch }}</td>
                        <td>{{ $item->batch_r->count - $item->amount }}</td>
                        <td>{{ $item->batch_r->count }}</td>
                        <td>
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                </form>
            @endforeach
        @endif
        @if($inventoryAdjustment->dispatch)
            @foreach($inventoryAdjustment->dispatch->dispatchItems as $key => $item)

                <form method="POST" class="form-horizontal" action="{{ route('pharmacies.products.inventory_adjustments.destroy_dispatchItem',$item) }}">
                @csrf
                @method('DELETE')

                    <tr>
                        <!-- <td>{{ $item->id }}</td> -->
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->due_date }}</td>
                        <td>{{ $item->batch }}</td>
                        <td>{{ $item->batch_r->count + $item->amount }}</td>
                        <td>{{ $item->batch_r->count }}</td>
                        <td>
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                </form>
            @endforeach
        @endif
    </tbody>
</table>

@endsection

@section('custom_js')

    <script>
        $( document ).ready(function() {
        document.getElementById("for_barcode").focus();
        });
    </script>

@endsection
