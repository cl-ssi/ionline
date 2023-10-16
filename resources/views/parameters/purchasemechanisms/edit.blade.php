@extends('layouts.bt4.app')

@section('title', 'Editar Mecanismo de Compra')

@section('content')

<h3 class="mb-3">Editar Mecanismo de Compra</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.purchasemechanisms.update', $purchaseMechanism) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <fieldset class="form-group col">
            <label for="for_prefix">Nombre</label>
            <input type="text" class="form-control" id="for_prefix"
            value="{{ $purchaseMechanism->name }}" name="name" required>
        </fieldset>
    </div>

    <div class="row">
      <div class="form-group col">
        <label for="exampleFormControlSelect1">Seleccionar Tipo de Compra:</label>
        <select multiple class="form-control" id="purchaseTypes" size="7" name="purchaseTypes[]" required>
          @foreach($lstPurchaseTypes as $purchaseType)
            <option value="{{ $purchaseType->id}} " @if($purchaseTypes->contains($purchaseType->id)) selected @endif >{{$purchaseType->name}}</option>
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
