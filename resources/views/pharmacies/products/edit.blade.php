@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')

@include('pharmacies.nav')

<h3 class="mb-3">Editar un producto</h3>

<form method="POST" class="form-horizontal" action="{{ route('pharmacies.products.update', $product) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <fieldset class="form-group col-3">
            <label for="for_barcode">Código</label>
            <input type="text" class="form-control" id="for_barcode"
                value = '{{ $product->barcode }}' name="barcode">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name"
            value = '{{ $product->name }}' name="name" required>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_unit">Unidad</label>
            <input type="text" class="form-control" id="for_unit"
            value = '{{ $product->unit }}' name="unit" required>
        </fieldset>
    </div>

    <div class="row">
        <!--<fieldset class="form-group col-4">
            <label for="for_expiration">Fecha Expiración</label>
            <input type="date" class="form-control" id="for_expiration"
            value = '{{ $product->expiration }}' name="expiration" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_batch">Lote</label>
            <input type="text" class="form-control" id="for_batch"
            value = '{{ $product->batch }}' name="batch" required>
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_price">Precio</label>
            <input type="number" class="form-control" id="for_price"
            value = '{{ $product->price }}' name="price">
        </fieldset>-->

        <fieldset class="form-group col-3">
            <label for="for_category">Categoria</label>
            <select name="category_id" id="for_category" class="form-control">
                @foreach ($categories as $key => $category)
                  <option value="{{$category->id}}" @if ($category->id == $product->category_id)
                    selected="selected"
                  @endif>{{$category->name}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_program">Programa</label>
            <!--<input type="text" class="form-control" id="for_program"
            value = '{{ $product->program }}' name="program">-->
            <select name="program_id" id="for_program" class="form-control">
                @foreach ($programs as $key => $program)
                  <option value="{{$program->id}}" @if ($program->id == $product->program_id)
                    selected="selected"
                  @endif>{{$program->name}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_critic_stock">Stock Crítico</label>
            <input type="text" class="form-control" id="for_critic_stock"
            value = '{{ $product->critic_stock }}' name="critic_stock" required>
        </fieldset>

    </div>

    <div class="row">
      <fieldset class="form-group col">
          <label for="for_storage_conditions">Condiciones de Almacenamiento</label>
          <input type="text" class="form-control" id="for_storage_conditions" placeholder="" name="storage_conditions" value = '{{ $product->storage_conditions }}'>
      </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
