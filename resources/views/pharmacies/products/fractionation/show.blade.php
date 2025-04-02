@extends('layouts.bt4.app')

@section('title', 'Nuevo fraccionamiento')

@section('content')

@include('pharmacies.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h3>Nuevo fraccionamiento</h3>

<div class="form-row">
      <fieldset class="form-group col-3">
          <label for="for_date">Fecha</label>
          <input type="text" class="form-control" id="for_date" name="date" value="{{ Carbon\Carbon::parse($fractionation->date)->format('d/m/Y')}}" disabled>
      </fieldset>

      <fieldset class="form-group col">
            <label for="for_origin">Origen</label>
            <input class="form-control" type="text" disabled @if($establishment) value="{{$establishment->name}}" @endif>
      </fieldset>

      <fieldset class="form-group col">
            <label for="for_medic">Médico</label>
            <input type="text" class="form-control" value="{{$fractionation->medic ? $fractionation->medic->shortName : ''}}" disabled>
      </fieldset>
</div>

<div class="form-row">
    <fieldset class="form-group col">
        <label for="for_patient">Paciente</label>
        <input type="text" class="form-control" value="{{$fractionation->patient ? $fractionation->patient->full_name : ''}}" disabled>
    </fieldset>

    <fieldset class="form-group col">
        <label for="for_acquirer">Adquiriente</label>
        <input type="text" class="form-control" value="{{$fractionation->acquirer}}" disabled>
    </fieldset>
</div>

<div class="form-row">
    <fieldset class="form-group col">
        <label for="for_qf_supervisor">QF Supervisor</label>
        <input type="text" class="form-control" value="{{$fractionation->qfSupervisor ? $fractionation->qfSupervisor->shortName : ''}}" disabled>
    </fieldset>

    <fieldset class="form-group col">
        <label for="for_fractionator">Fraccionador</label>
        <input type="text" class="form-control" value="{{$fractionation->fractionator ? $fractionation->fractionator->shortName : ''}}" disabled>
    </fieldset>
</div>

<div class="form-row">
    <fieldset class="form-group col">
        <label for="for_note">Nota</label>
        <input type="text" class="form-control" id="for_note" placeholder="" name="notes" value="{{$fractionation->notes}}" disabled>
    </fieldset>
</div>

<hr />

@include('pharmacies.products.fractionationitem.create')

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
              $("#for_product").val({{$product->id}});
              $("#for_product").change();
            }
          @endforeach

        }
    }

  </script>

@endsection
