@extends('layouts.bt4.app')

@section('title', 'Editar Tipo de Compra')

@section('content')

<h3 class="mb-3">Editar Tipo de Compra</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.purchasetypes.update', $purchaseType) }}">
    @csrf
    @method('PUT')
    <div class="row">

        <fieldset class="form-group col">
            <label for="for_prefix">Nombre</label>
            <input type="text" class="form-control" id="for_prefix"
            value="{{ $purchaseType->name }}" name="name" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_prefix">Días Habiles Finanza</label>
            <input type="number" class="form-control" id="for_prefix"
            value="{{ $purchaseType->finance_business_day }}" name="finance_business_day" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_prefix">Días Corridos Abastecimiento</label>
            <input type="number" class="form-control" id="for_prefix"
            value="{{ $purchaseType->supply_continuous_day }}" name="supply_continuous_day" required>
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.purchasetypes.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
