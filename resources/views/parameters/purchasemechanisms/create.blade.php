@extends('layouts.bt4.app')

@section('title', 'Crear Mecanismo de Compra')

@section('content')

<h3 class="mb-3">Crear Mecanismo de Compra</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.purchasemechanisms.store') }}">
    @csrf

    <div class="row">
        <fieldset class="form-group col">
            <label for="for_name">Nombre:</label>
            <input type="text" class="form-control" id="for_name" name="name" required>
        </fieldset>
    </div>

    <div class="row">
      <div class="form-group col">
        <label for="exampleFormControlSelect1">Seleccionar Tipo de Compra:</label>
        <select multiple class="form-control" id="exampleFormControlSelect1" size="7" name="purchaseTypes[]" required>
          @foreach($purchaseTypes as $purchaseType)
          <option value="{{$purchaseType->id}}">{{$purchaseType->name}}</option>
          @endforeach
        </select>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.purchasemechanisms.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
