@extends('layouts.app')

@section('title', 'Crear nuevo egreso')

@section('content')

@include('pharmacies.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h3>Nuevo Egreso</h3>

<div class="row">
      <fieldset class="form-group col-3">
          <label for="for_date">Fecha</label>
          <input type="text" class="form-control" id="for_date" name="date" value="{{ Carbon\Carbon::parse($dispatch->date)->format('d/m/Y')}}" disabled>
      </fieldset>

      <fieldset class="form-group col">
          <label for="for_origin">Destino</label>
					<select name="establishment_id" class="form-control selectpicker" data-live-search="true" disabled>
							<option value="{{$establishment->id}}">{{$establishment->name}}</option>
					</select>
      </fieldset>
</div>

<div class="row">
    <fieldset class="form-group col">
        <label for="for_note">Nota</label>
        <input type="text" class="form-control" id="for_note" placeholder="" name="notes" value="{{$dispatch->notes}}" disabled>
    </fieldset>
</div>

<hr />

@include('pharmacies.products.dispatchitem.create')

@endsection

@section('custom_js')

<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/show_hide_tab.js') }}"></script>

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
              // document.getElementById("for_product").value = {{$product->id}};
              // document.getElementById("for_unity").value = "{{$product->unit}}";
              // $( "#for_product" ).trigger( "change" );
              $("#for_product").val({{$product->id}});
              $("#for_product").change();
              // alert("");
            }
          @endforeach

        }
    }

    // function jsCambiaSelect(selectObject)
    // {
    //   var value = selectObject.value;
    //   @foreach ($products as $key => $product)
    //     if ({{$product->id}} == value) {
    //       document.getElementById("for_barcode").value = {{$product->barcode}};
    //       document.getElementById("for_unity").value = "{{$product->unit}}";
    //       document.getElementById("for_quantity").focus();
    //     }
    //   @endforeach
    // }
    //
    // function funcionDeferred(){
    //     var deferred = $.Deferred();
    //     var product_id = document.getElementById("for_product").value;
    //     $.get('{{ route('pharmacies.products.dispatch.product.due_date')}}/'+product_id, function(data) {
    //         console.log(data);
    //         $('#for_due_date').empty();
    //         $.each(data, function(index,date){
    //             let today = new Date(date);
    //             var dd = today.getDate();
    //             var mm = today.getMonth() + 1; //January is 0!
    //             var yyyy = today.getFullYear();
    //
    //             if (dd < 10) {dd = '0' + dd;}
    //             if (mm < 10) {mm = '0' + mm;}
    //             var today_ = dd + '/' + mm + '/' + yyyy;
    //
    //             $('#for_due_date').append('<option value="'+date+'">'+today_+'</option>');
    //         });
    //         deferred.resolve();
    //     });
    //     return deferred;
    // }
    //
    // $('#for_product').on('change', function(e){
    //   console.log(e);
    //   funcionDeferred().done(function() {
    //     $("#for_due_date").selectindex = 0;
    //     $("#for_due_date").trigger("change");
    //   });
    // });
    //
    // //función que permite funcionalidad asincrona (permite que termine la ejecución procedural del código antes de partir con el resto)
    //  function funcionDeferred2(){
    //      var deferred = $.Deferred();
    //      var product_id = document.getElementById("for_product").value;
    //      var due_date = document.getElementById("for_due_date").value;
    //      $.get('{{ route('pharmacies.products.dispatch.product.batch')}}/'+product_id+'/'+due_date, function(data) {
    //          console.log(data);
    //          $('#for_batch').empty();
    //          $.each(data, function(index,batch){
    //              $('#for_batch').append('<option value="'+batch+'">'+batch+'</option>');
    //          });
    //          deferred.resolve();
    //      });
    //      return deferred;
    //  }
    //
    // $('#for_due_date').on('change', function(e){
    //   console.log(e);
    //   funcionDeferred2().done(function() {
    //     $("#for_batch").selectedIndex = 0;
    //     $("#for_batch").trigger("change");
    //
    //     //se obtiene contador del producto (consideando f.venc y lote)
    //     var product_id = document.getElementById("for_product").value;
    //     var due_date = document.getElementById("for_due_date").value;
    //     var batch = document.getElementById("for_batch").value;
    //     document.getElementById("for_count").value = 0;
    //     $.get('{{ route('pharmacies.products.dispatch.product.count')}}/'+product_id+'/'+due_date+'/'+batch.replace("/","*"), function(data) {
    //         console.log(data);
    //         document.getElementById("for_count").value = data;
    //     });
    //   });
    // });
    //
    // $('#for_batch').on('change', function(e){
    //   //se obtiene contador del producto (consideando f.venc y lote)
    //   var product_id = document.getElementById("for_product").value;
    //   var due_date = document.getElementById("for_due_date").value;
    //   var batch = document.getElementById("for_batch").value;
    //   document.getElementById("for_count").value = 0;
    //   $.get('{{ route('pharmacies.products.dispatch.product.count')}}/'+product_id+'/'+due_date+'/'+batch.replace("/","*"), function(data) {
    //       console.log(data);
    //       document.getElementById("for_count").value = data;
    //   });
    // });

  </script>

@endsection
