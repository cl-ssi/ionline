@extends('layouts.app')

@section('title', 'Crear nuevo ingreso')

@section('content')

@include('pharmacies.nav')

<h3>Nuevo Ingreso</h3>

<div class="row">
      <fieldset class="form-group col-3">
          <label for="for_date">Fecha</label>
          <input type="text" class="form-control" id="for_date" name="date" value="{{ Carbon\Carbon::parse($receiving->date)->format('d/m/Y')}}" disabled>
      </fieldset>

      <fieldset class="form-group col">
          <label for="for_origin">Origen</label>
					<select name="establishment_id" class="form-control selectpicker" data-live-search="true" disabled>
							<option value="{{$establishment->id}}">{{$establishment->name}}</option>
					</select>
      </fieldset>
</div>

<div class="row">
    <fieldset class="form-group col">
        <label for="for_note">Nota</label>
        <input type="text" class="form-control" id="for_note" placeholder="" name="notes" value="{{$receiving->notes}}" disabled>
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
