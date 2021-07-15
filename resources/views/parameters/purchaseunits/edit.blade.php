@extends('layouts.app')

@section('title', 'Editar Unidad de Compra')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Editar Unidad de Compra</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.purchaseunits.update', $purchaseUnit) }}">
    @csrf
    @method('PUT')
    <div class="row">

        <fieldset class="form-group col">
            <label for="for_prefix">Nombre</label>
            <input type="text" class="form-control" id="for_prefix"
            value="{{ $purchaseUnit->name }}" name="name" required>
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.purchaseunits.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
