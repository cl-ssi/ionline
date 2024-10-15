@extends('layouts.bt4.app')

@section('title', 'Editar compra importada de recepción')

@section('content')

@include('pharmacies.nav')

<h3>Editar compra importada de recepción <b>#{{ $purchase->reception->id }}</b></h3>

<div class="row">
    <div class="col-md">
        <h4 class="mb-4">Información de la Recepción</h4>
        <div class="card bg-warning shadow-sm rounded">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Fecha de Recepción:</strong> {{ $purchase->reception->date->format('d/m/Y') }}</p>
                        <p><strong>Proveedor:</strong> {{ $purchase->reception->purchaseOrder->json->Listado[0]->Proveedor->Nombre ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Guía de Despacho:</strong> {{ $purchase->reception->guia?->folio ?? 'N/A' }}</p>
                        <p><strong>Factura:</strong> {{ $purchase->reception->dte?->folio ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Fecha de Emisión Factura:</strong> {{ $purchase->reception->dte?->emision->format('d/m/Y') ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Monto Neto:</strong> <span class="text-success">${{ number_format($purchase->reception->neto, 0, ',', '.') }}</span></p>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mt-4">Items de la Recepción</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped bg-white">
                        <thead class="thead-dark">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Neto</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchase->reception->items as $item)
                            <tr>
                                <td>{{ $item->Producto }}</td>
                                <td>{{ $item->Cantidad }}</td>
                                <td>${{ number_format($item->PrecioNeto, 0, ',', '.') }}</td>
                                <td>${{ number_format($item->Total, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


<hr>

<form method="POST" action="{{ route('pharmacies.products.purchase.update',$purchase) }}">
  @method('PUT')
	@csrf

  <div class="form-row">
    <fieldset class="form-group col-3">
        <label for="for_date">Fecha de recepción (*)</label>
        <input type="date" class="form-control" id="for_date" name="date" required="required" value="{{$purchase->date->format('Y-m-d')}}">
    </fieldset>

    <fieldset class="form-group col">
        <label for="for_origin">Proveedor (*)</label>
        <select name="supplier_id" class="form-control selectpicker" data-live-search="true" required="">
          @foreach ($suppliers as $key => $supplier)
            <option value="{{$supplier->id}}" @if ($purchase->supplier_id == $supplier->id)
              selected
            @endif>{{$supplier->name}}</option>
          @endforeach
        </select>
    </fieldset>
  </div>

  <div class="form-row">
    <fieldset class="form-group col-">
        <label for="for_text">OC (*)</label>
        <input type="text" class="form-control" id="for_text" placeholder="" required="required"  name="purchase_order" value="{{$purchase->purchase_order}}">
    </fieldset>
    <fieldset class="form-group col-3">
        <label for="for_order_number">N° pedido (*) </label>
        <input type="text" class="form-control" id="for_order_number" placeholder="" name="order_number" value="{{$purchase->order_number}}">
    </fieldset>
    <!-- <fieldset class="form-group col-2">
        <label for="for_text">Año</label>
        <input type="text" class="form-control" id="for_text" placeholder="" name="purchase_order_dato" value="{{$purchase->purchase_order_dato}}">
    </fieldset> -->
    <fieldset class="form-group col-3">
        <label for="for_date">Fecha de emisión factura (*)</label>
        <input type="date" class="form-control" id="for_date" name="purchase_order_date" required="required" value="{{$purchase->purchase_order_date->format('Y-m-d')}}">
    </fieldset>
    <fieldset class="form-group col-3">
        <label for="for_text">Monto total neto (*)</label>
        <input type="text" class="form-control" id="for_text" placeholder="" name="purchase_order_amount" value="{{$purchase->purchase_order_amount}}">
    </fieldset>
  </div>

  <div class="form-row">
    <fieldset class="form-group col-3">
        <label for="for_text">Guía</label>
        <input type="text" class="form-control" id="for_text" name="despatch_guide" value="{{$purchase->despatch_guide}}">
    </fieldset>
    <fieldset class="form-group col-3">
        <label for="for_text">Factura</label>
        <input type="text" class="form-control" id="for_text" name="invoice" value="{{$purchase->invoice}}">
    </fieldset>
    <fieldset class="form-group col-3">
        <label for="for_text">Fecha vencimiento factura</label>
        @if ($purchase->invoice_date <> NULL)
          <input type="date" class="form-control" id="for_date" name="invoice_date" value="{{$purchase->invoice_date->format('Y-m-d')}}">
        @else
          <input type="date" class="form-control" id="for_date" name="invoice_date" >
        @endif
    </fieldset>
    <fieldset class="form-group col-3">
            <label for="for_commission">Comisión</label>
            <input type="text" class="form-control" id="for_commission" placeholder="" name="commission" value="{{$purchase->commission}}">
    </fieldset>
  </div>

  <div class="form-row">
    <fieldset class="form-group col">
        <label for="for_note">Nota</label>
        <input type="text" class="form-control" id="for_note" placeholder="" name="notes" value="{{$purchase->notes}}">
    </fieldset>

    <!--<fieldset class="form-group col">
        <label for="for_note">Contenido</label>
        <input type="text" class="form-control" id="for_note" placeholder="" name="content" value="{{$purchase->content}}">
    </fieldset>-->
  </div>

  <div class="form-row">
    <!--<fieldset class="form-group col-3">
        <label for="for_note">Acta recep.</label>
        <input type="text" class="form-control" id="for_note" placeholder="" name="acceptance_certificate" value="{{$purchase->acceptance_certificate}}">
    </fieldset>-->

    <fieldset class="form-group col">
        <label for="for_note">Destino</label>
        <input type="text" class="form-control" id="for_note" placeholder="" name="destination" value="{{$purchase->destination}}">
    </fieldset>
    <fieldset class="form-group col">
        <label for="for_note">Fondos</label>
        <input type="text" class="form-control" id="for_note" placeholder="" name="from" value="{{$purchase->from}}">
    </fieldset>
  </div>

  <!--<div class="form-row">
    <fieldset class="form-group col-3">
    </fieldset>

    <fieldset class="form-group col">
        <label for="for_note">Fondos</label>
        <input type="text" class="form-control" id="for_note" placeholder="" name="from" value="{{$purchase->from}}">
    </fieldset>
  </div>-->

<button type="submit" class="btn btn-primary">Guardar</button>
</form>

<hr />

@include('pharmacies.products.purchaseitem.create')

@endsection

@section('custom_js')
<script>
    // Aquí puedes agregar scripts personalizados si necesitas manejar alguna interacción en esta página.
</script>
@endsection
