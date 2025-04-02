@extends('layouts.bt4.app')

@section('title', 'Editar fraccionamiento')

@section('content')

@include('pharmacies.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h3>Editar fraccionamiento</h3>

<form method="POST" action="{{ route('pharmacies.products.fractionation.update',$fractionation) }}">
  @method('PUT')
	@csrf

<div class="form-row">
      <fieldset class="form-group col-3">
          <label for="for_date">Fecha</label>
          <input type="date" class="form-control" id="for_date" name="date" required="required" value="{{$fractionation->date->format('Y-m-d')}}">
      </fieldset>

      <fieldset class="form-group col">
          <label for="for_origin">Origen</label>
          <select name="establishment_id" class="form-control selectpicker" data-live-search="true">
            <option value=""></option>
            @foreach ($establishments as $key => $establishment)
              <option value="{{$establishment->id}}" @if ($fractionation->establishment_id == $establishment->id)
                selected
              @endif>{{$establishment->name}}</option>
            @endforeach
          </select>
      </fieldset>

        <fieldset class="form-group col">
            <label for="for_origin">Médico</label>
            @livewire('search-select-user', ['selected_id' => 'medic_id',
                                            'user' => $fractionation->medic])
        </fieldset>
</div>

<div class="form-row">
    <fieldset class="form-group col">
        <label for="for_patient">Paciente</label>
        @livewire('pharmacies.search-select-user', ['selected_id' => 'patient_id',
                                        'user' => $fractionation->patient])
    </fieldset>

    <fieldset class="form-group col">
        <label for="for_acquirer">Adquiriente</label>
        <input type="text" name="acquirer" class="form-control" id="for_acquirer" placeholder="Nombre del adquiriente" value="{{$fractionation->acquirer}}">
    </fieldset>
</div>

<div class="form-row">
    <fieldset class="form-group col">
        <label for="for_qf_supervisor">QF Supervisor</label>
        @livewire('search-select-user', ['selected_id' => 'qf_supervisor_id',
                                        'user' => $fractionation->qfSupervisor])
    </fieldset>

    <fieldset class="form-group col">
        <label for="for_fractionator">Fraccionador</label>
        @livewire('search-select-user', ['selected_id' => 'fractionator_id',
                                        'user' => $fractionation->fractionator])
    </fieldset>
</div>


<div class="form-row">
    <fieldset class="form-group col">
        <label for="for_note">Nota</label>
        <input type="text" class="form-control" id="for_note" placeholder="" name="notes" value="{{$fractionation->notes}}">
    </fieldset>
</div>

<button type="submit" class="btn btn-primary">Guardar</button>
</form>

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

  </script>

@endsection
