@extends('layouts.app')

@section('title', 'Crear nueva compra')

@section('content')

@include('pharmacies.nav')

<h3>Nueva compra</h3>

<div class="row">
  <fieldset class="form-group col-3">
      <label for="for_date">Fecha</label>
      <input type="text" class="form-control" id="for_date" name="date" value="{{ Carbon\Carbon::parse($purchase->date)->format('d/m/Y')}}" disabled>
  </fieldset>

  <fieldset class="form-group col">
      <label for="for_origin">Proveedor</label>
      <select name="supplier_id" class="form-control selectpicker" data-live-search="true" required="" disabled>
        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
      </select>
  </fieldset>
</div>

<div class="row">
  <fieldset class="form-group col-2">
      <label for="for_text">OC</label>
      <input type="text" class="form-control" id="for_text" placeholder="" name="purchase_order" value="{{$purchase->purchase_order}}" disabled>
  </fieldset>
  <fieldset class="form-group col-2">
      <label for="for_text">Año</label>
      <input type="text" class="form-control" id="for_text" placeholder="" name="purchase_order_dato" value="{{$purchase->purchase_order_dato}}" disabled>
  </fieldset>
  <fieldset class="form-group col-4">
      <label for="for_date">Fecha OC</label>
      <input type="text" class="form-control" id="for_date" name="date" value="{{ Carbon\Carbon::parse($purchase->purchase_order_date)->format('d/m/Y')}}" disabled>
  </fieldset>
  <fieldset class="form-group col-4">
      <label for="for_text">Monto total neto</label>
      <input type="text" class="form-control" id="for_text" placeholder="" name="purchase_order_amount" value="{{$purchase->purchase_order_amount}}" disabled>
  </fieldset>
</div>

<div class="row">
  <fieldset class="form-group col-4">
      <label for="for_text">Guía</label>
      <input type="text" class="form-control" id="for_text" name="despatch_guide" value="{{$purchase->despatch_guide}}" disabled>
  </fieldset>
  <fieldset class="form-group col-4">
      <label for="for_text">Factura</label>
      <input type="text" class="form-control" id="for_text" name="invoice" value="{{$purchase->invoice}}" disabled>
  </fieldset>
  <fieldset class="form-group col-4">
      <label for="for_text">Fecha Doc.</label>
      @if ($purchase->invoice_date <> NULL)
        <input type="date" class="form-control" id="for_date" name="invoice_date" value="{{$purchase->invoice_date->format('Y-m-d')}}" disabled>
      @else
        <input type="date" class="form-control" id="for_date" name="invoice_date" disabled>
      @endif
  </fieldset>
</div>

<div class="row">
  <fieldset class="form-group col">
      <label for="for_note">Nota</label>
      <input type="text" class="form-control" id="for_note" placeholder="" name="notes" value="{{$purchase->notes}}" disabled>
  </fieldset>

  <!--<fieldset class="form-group col">
      <label for="for_note">Contenido</label>
      <input type="text" class="form-control" id="for_note" placeholder="" name="content" value="{{$purchase->content}}" disabled>
  </fieldset>-->
</div>

<div class="row">
  <!--<fieldset class="form-group col-3">
      <label for="for_note">Acta recep.</label>
      <input type="text" class="form-control" id="for_note" placeholder="" name="acceptance_certificate" value="{{$purchase->acceptance_certificate}}" disabled>
  </fieldset>-->

  <fieldset class="form-group col">
      <label for="for_note">Destino</label>
      <input type="text" class="form-control" id="for_note" placeholder="" name="destination" value="{{$purchase->destination}}" disabled>
  </fieldset>
  <fieldset class="form-group col">
      <label for="for_note">Fondos</label>
      <input type="text" class="form-control" id="for_note" placeholder="" name="from" value="{{$purchase->from}}" disabled>
  </fieldset>
</div>

<!--<div class="row">
  <fieldset class="form-group col-3">

  </fieldset>

  <fieldset class="form-group col">
      <label for="for_note">Fondos</label>
      <input type="text" class="form-control" id="for_note" placeholder="" name="from" value="{{$purchase->from}}" disabled>
  </fieldset>
</div>-->

<hr />

@include('pharmacies.products.purchaseitem.create')

@endsection

@section('custom_js')

  <script>
    $( document ).ready(function() {
      document.getElementById("for_barcode").focus();
    });


    document.onkeydown=function(evt){
        var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
        var barcode = document.getElementById("for_barcode").value;
        if(keyCode == 13)
        {
          @foreach ($products as $key => $product)
            if ({{$product->barcode}} == barcode) {
              document.getElementById("for_product").value = {{$product->id}};
              document.getElementById("for_unity").value = "{{$product->unit}}";
            }
          @endforeach

        }
    }

    function jsCambiaSelect(selectObject)
    {
      var value = selectObject.value;
      @foreach ($products as $key => $product)
        if ({{$product->id}} == value) {
          document.getElementById("for_barcode").value = {{$product->barcode}};
          document.getElementById("for_unity").value = "{{$product->unit}}";
          document.getElementById("for_quantity").focus();
        }
      @endforeach
    }
  </script>

@endsection
