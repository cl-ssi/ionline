@extends('layouts.bt4.app')

@section('title', 'Editar Producto')

@section('content')

@include('pharmacies.nav')

<h3 class="mb-3">Editar Producto</h3>

<form method="POST" class="form-horizontal" action="{{ route('pharmacies.products.update', $product) }}">
    @csrf
    @method('PUT')

    <div class="form-row">
        <fieldset class="form-group col-2">
            <label for="for_barcode">Código producto</label>
            <input type="text" class="form-control" id="for_barcode"
                value = '{{ $product->barcode }}' name="barcode">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_barcode">Código experto</label>
            <input type="text" class="form-control" id="for_experto_id" placeholder="Código experto del producto" 
            name="experto_id" value="{{$product->experto_id}}">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_barcode">Código Mercado público</label>
            <input type="text" class="form-control" id="for_unspsc_product_id" placeholder="Código mercado público" 
            name="unspsc_product_id" value="{{$product->unspsc_product_id}}">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name"
            value = '{{ $product->name }}' name="name" required>
        </fieldset>

        
    </div>

    <div class="form-row">
        <fieldset class="form-group col-2">
            <label for="for_unit">Unidad</label>
            <input type="text" class="form-control" id="for_unit"
            value = '{{ $product->unit }}' name="unit" required>
        </fieldset>

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

    </div>

    <div class="form-row">

      <fieldset class="form-group col-4">
          <label for="for_critic_stock">Stock Crítico</label>
          <input type="text" class="form-control" id="for_critic_stock"
          value = '{{ $product->critic_stock }}' name="critic_stock">
      </fieldset>

      <fieldset class="form-group col-4">
          <label for="for_min_stock">Stock Min.</label>
          <input type="text" class="form-control" id="for_min_stock"
          value = '{{ $product->min_stock }}' name="min_stock">
      </fieldset>

      <fieldset class="form-group col-4">
          <label for="for_max_stock">Stock Max.</label>
          <input type="text" class="form-control" id="for_max_stock"
          value = '{{ $product->max_stock }}' name="max_stock">
      </fieldset>

    </div>

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_storage_conditions">Condiciones de Almacenamiento</label>
            <textarea name="storage_conditions" class="form-control" id="for_storage_conditions">
            {{ $product->storage_conditions }}
            </textarea>
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

<hr>

<h4>Lotes</h4>

<div class="alert alert-warning" role="alert">
    <li>Se actualizará la información de todas las compras, ingresos y salidas del lote modificado.</li>
    <li>La cantidad no puede ser modificada en esta opción.</li>
</div>

@foreach($product->batchs as $batch )

    <form method="POST" class="form-horizontal" action="{{ route('pharmacies.products.batchs.update', $batch) }}">
    @csrf
    @method('PUT')

        <div class="form-row">

            <fieldset class="form-group col-3">
                <label for="for_min_stock">Lote</label>
                <input type="text" class="form-control" value = '{{ $batch->batch }}' name="batch">
            </fieldset>

            <fieldset class="form-group col-3">
                <label for="for_critic_stock">F.Vencimiento</label>
                <input type="date" class="form-control" value = '{{ $batch->due_date->format("Y-m-d") }}' name="due_date">
            </fieldset>

            <fieldset class="form-group col-3">
                <label for="for_max_stock">Cantidad</label>
                <input type="text" class="form-control" value = '{{ $batch->count }}' name="count" disabled>
            </fieldset>

            <fieldset class="form-group col-2">
                <label for="for_max_stock"><br></label>
                <button type="submit" class="btn btn-primary form-control">Guardar</button>
            </fieldset>

        </div>

    </form>

@endforeach

@endsection

@section('custom_js')

@endsection
