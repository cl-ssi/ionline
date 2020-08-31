@extends('layouts.app')

@section('title', 'Editar ingreso')

@section('content')

@include('pharmacies.nav')

<h3>Editar Ingreso</h3>

<form method="POST" action="{{ route('pharmacies.products.receiving.update',$receiving) }}">
  @method('PUT')
	@csrf

<div class="row">
      <fieldset class="form-group col-3">
          <label for="for_date">Fecha</label>
          <input type="date" class="form-control" id="for_date" name="date" required="required" value="{{$receiving->date->format('Y-m-d')}}">
      </fieldset>

      <fieldset class="form-group col">
          <label for="for_origin">Origen</label>
					<select name="establishment_id" class="form-control selectpicker" data-live-search="true" required="">
            @foreach ($establishments as $key => $establishment)
              <option value="{{$establishment->id}}" @if ($receiving->establishment_id == $establishment->id)
                selected
              @endif>{{$establishment->name}}</option>
            @endforeach
          </select>
      </fieldset>
</div>

<div class="row">
    <fieldset class="form-group col">
        <label for="for_note">Nota</label>
        <input type="text" class="form-control" id="for_note" placeholder="" name="notes" value="{{$receiving->notes}}">
    </fieldset>
</div>

<button type="submit" class="btn btn-primary">Guardar</button>
</form>

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
