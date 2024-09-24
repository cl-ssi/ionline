@extends('layouts.bt4.app')

@section('title', 'Crear nuevo ingreso')

@section('content')

@include('pharmacies.nav')

<h3>Nuevo Ingreso</h3>

<div class="form-row">
      <fieldset class="form-group col-3">
          <label for="for_date">Fecha</label>
          <input type="text" class="form-control" id="for_date" name="date" value="{{ Carbon\Carbon::parse($receiving->date)->format('d/m/Y')}}" disabled>
      </fieldset>

      <fieldset class="form-group col">
            <label for="for_origin">Origen</label>
            <input class="form-control" type="text" disabled @if($destiny) value="{{$destiny->name}}" @endif>
      </fieldset>
</div>

<div class="form-row">
    <fieldset class="form-group col">
        <label for="for_note">Nota</label>
        <input type="text" class="form-control" id="for_note" placeholder="" name="notes" value="{{$receiving->notes}}" disabled>
    </fieldset>

    <fieldset class="form-group col-4">
        <label for="for_order_number">Nro. Pedido</label>
        <input type="text" class="form-control" id="for_order_number" placeholder="" name="order_number" value="{{$receiving->order_number}}" disabled>
    </fieldset>
</div>

<hr />

@include('pharmacies.products.receivingitem.create')

@endsection

@section('custom_js')

    <script>
        $( document ).ready(function() {
        document.getElementById("for_barcode").focus();
        });
    </script>

@endsection
