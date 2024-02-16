@extends('layouts.bt4.app')

@section('title', 'Crear Producto')

@section('content')

@include('pharmacies.nav')

<h3 class="mb-3">Crear Producto</h3>

<form method="POST" class="form-horizontal" action="{{ route('pharmacies.products.store') }}">
    @csrf
    @method('POST')

    <div class="form-row">
        <fieldset class="form-group col-2">
            <label for="for_barcode">Código producto</label>
            <input type="text" class="form-control" id="for_barcode" placeholder="Código interno del producto" name="barcode" required="">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_barcode">Código experto</label>
            <input type="text" class="form-control" id="for_experto_id" placeholder="Código experto del producto" name="experto_id" required="">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_barcode">Código Mercado público</label>
            <input type="text" class="form-control" id="for_unspsc_product_id" placeholder="Código mercado público" name="unspsc_product_id">
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name" placeholder="Nombre del producto" name="name" required="">
        </fieldset>

    </div>

    <div class="form-row">

        <fieldset class="form-group col-2">
            <label for="for_unit">Unidad</label>
            <!--<input type="text" class="form-control" id="for_unit" placeholder="ML, GR, etc." name="unit" required="">-->
            <select name="unit" id="for_unit" class="form-control">
            @foreach($units as $unit)
            <option value='{{ $unit->name }}'>{{ $unit->name }}</option>
            @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_category">Categoria</label>
            <select name="category_id" id="for_category" class="form-control">
            @foreach($categories as $category)
            <option value='{{ $category->id }}'>{{ $category->name }}</option>
            @endforeach
            </select>
        </fieldset>

        <!--<fieldset class="form-group col">
            <label for="for_program">Programa</label>
            <input type="text" class="form-control" id="for_program" placeholder="Nombre del programa al que pertenece" name="program" required="">
        </fieldset>-->
        <fieldset class="form-group col">
            <label for="for_category">Programa</label>
            <select name="program_id" id="for_program" class="form-control">
            @foreach($programs as $program)
            <option value='{{ $program->id }}'>{{ $program->name }}</option>
            @endforeach
            </select>
        </fieldset>

    </div>

    <div class="form-row">

      <fieldset class="form-group col-4">
          <label for="for_critic_stock">Stock Crítico</label>
          <input type="text" class="form-control" id="for_critic_stock" placeholder="" name="critic_stock">
      </fieldset>

      <fieldset class="form-group col-4">
          <label for="for_min_stock">Stock Min.</label>
          <input type="text" class="form-control" id="for_min_stock" name="min_stock">
      </fieldset>

      <fieldset class="form-group col-4">
          <label for="for_max_stock">Stock Max.</label>
          <input type="text" class="form-control" id="for_max_stock" name="max_stock">
      </fieldset>

    </div>

    <div class="form-row">
      <fieldset class="form-group col">
          <label for="for_storage_conditions">Condiciones de Almacenamiento</label>
          <input type="text" class="form-control" id="for_storage_conditions" placeholder="" name="storage_conditions">
      </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">Crear</button>

</form>

@endsection

@section('custom_js')
  <script>
    $( document ).ready(function() {
      document.getElementById("for_barcode").focus();
    });
  </script>
@endsection
