@extends('layouts.app')

@section('title', 'Valor Hora/Jornada')

@section('content')

@include('parameters/nav')
<h3 class="mb-3">Crear nuevo valor Hora/Jornada</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.values.store') }}">
    @csrf
    @method('POST')

    <div class="row">
        <fieldset class="form-group col-6 col-md-4">
            <label for="for_contract_type">Tipo de Contrato*</label>
            <input type="text" class="form-control" id="for_contract_type" name="contract_type" required>
        </fieldset>

        <fieldset class="form-group col-6 col-md-4">
            <label for="for_guard_name">Jornada</label>
            <input type="text" class="form-control" id="for_work_type" name="work_type" required>
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_descripcion">Monto</label>
            <input type="number" class="form-control" id="for_amount" name="amount" required>
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_descripcion">Vigencia</label>
            <input type="date" class="form-control" id="for_validity_from" name="validity_from" required>
        </fieldset>
    </div>




    <button type="submit" class="btn btn-primary">Guardar</button>

</form>
@endsection

@section('custom_js')

@endsection