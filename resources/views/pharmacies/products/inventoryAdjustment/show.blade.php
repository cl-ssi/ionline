@extends('layouts.bt4.app')

@section('title', 'Crear nuevo ajuste de inventario')

@section('content')

@include('pharmacies.nav')

<h3>Nuevo Ajuste de Inventario</h3>

<div class="form-row">
      <fieldset class="form-group col-3">
          <label for="for_date">Fecha</label>
          <input type="text" class="form-control" id="for_date" value="{{ Carbon\Carbon::parse($inventoryAdjustment->date)->format('d/m/Y')}}" disabled>
      </fieldset>

      <fieldset class="form-group col">
        <label for="for_note">Tipo Ajuste de Inventario</label>
        <input type="text" class="form-control" id="for_note" value="{{$inventoryAdjustment->type->name}}" disabled>
    </fieldset>

      <fieldset class="form-group col">
        <label for="for_note">Observación</label>
        <input type="text" class="form-control" id="for_note" value="{{$inventoryAdjustment->notes}}" disabled>
    </fieldset>
</div>

<hr>

<form method="POST" action="{{ route('pharmacies.products.inventory_adjustments.store_detail') }}">
	@csrf

    <input type="hidden" name="inventoryAdjustment_id" value="{{$inventoryAdjustment->id}}">
    @livewire('pharmacies.product-stock-adjustment')

</form>


@endsection

@section('custom_js')

@endsection
