@extends('layouts.bt4.app')

@section('title', 'Editar Denominación Formula')

@section('content')

<h3 class="mb-3">Editar Horarios de Cirujanos y Anestecistas por Nivel</h3>

<form method="POST" class="form-horizontal" action="{{ route('rrhh.service-request.parameters.formula.update', $denominationFormula) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <fieldset class="form-group col-3">
            <label for="for_name">ID</label>
            <input type="number" class="form-control"   value="{{ $denominationFormula->id }}" disabled>
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_address">Código</label>
            <input type="number" class="form-control" name="code" value="{{ $denominationFormula->code }}" required>
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_address">Pabellón</label>
            <input type="number" class="form-control"  name="pavilion" value="{{ $denominationFormula->pavilion }}">
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_address">EQ.</label>
            <input type="number" class="form-control"  name="eq" value="{{ $denominationFormula->eq }}">
        </fieldset>
    </div>

    <div class="row">
      <fieldset class="form-group col-12">
          <label for="for_name">Denominación</label>
          <textarea type="text" rows="4" class="form-control"  name="denomination">{{ $denominationFormula->denomination }}</textarea>
      </fieldset>
    </div>

    <br>

    <div class="row">
      <label class="font-weight-bold col-12">Primer Cirujano</label>
    </div>
    <div class="row">
        <fieldset class="form-group col-4">
            <label for="for_name">Nivel 1</label>
            <input type="number" class="form-control" name="surgical1_level1" value="{{ $denominationFormula->surgical1_level1 }}">
        </fieldset>
        <fieldset class="form-group col-4">
            <label for="for_name">Nivel 2</label>
            <input type="number" class="form-control" name="surgical1_level2" value="{{ $denominationFormula->surgical1_level2 }}">
        </fieldset>
        <fieldset class="form-group col-4">
            <label for="for_name">Nivel 3</label>
            <input type="number" class="form-control" name="surgical1_level3" value="{{ $denominationFormula->surgical1_level3 }}">
        </fieldset>
    </div>
<hr>
    <div class="row">
      <label class="font-weight-bold col-12">Segundo Cirujano</label>
    </div>
    <div class="row">
        <fieldset class="form-group col-4">
            <label for="for_name">Nivel 1</label>
            <input type="number" class="form-control" name="surgical2_level1" value="{{ $denominationFormula->surgical2_level1 }}">
        </fieldset>
        <fieldset class="form-group col-4">
            <label for="for_name">Nivel 2</label>
            <input type="number" class="form-control" name="surgical2_level2" value="{{ $denominationFormula->surgical2_level2 }}">
        </fieldset>
        <fieldset class="form-group col-4">
            <label for="for_name">Nivel 3</label>
            <input type="number" class="form-control" name="surgical2_level3" value="{{ $denominationFormula->surgical2_level3 }}">
        </fieldset>
    </div>
<hr>
    <div class="row">
      <label class="font-weight-bold col-12">Tercer Cirujano</label>
    </div>
    <div class="row">
        <fieldset class="form-group col-4">
            <label for="for_name">Nivel 1</label>
            <input type="number" class="form-control" name="surgical3_level1" value="{{ $denominationFormula->surgical3_level1 }}">
        </fieldset>
        <fieldset class="form-group col-4">
            <label for="for_name">Nivel 2</label>
            <input type="number" class="form-control" name="surgical3_level2" value="{{ $denominationFormula->surgical3_level2 }}">
        </fieldset>
        <fieldset class="form-group col-4">
            <label for="for_name">Nivel 3</label>
            <input type="number" class="form-control" name="surgical3_level3" value="{{ $denominationFormula->surgical3_level3 }}">
        </fieldset>
    </div>
<hr>
    <div class="row">
      <label class="font-weight-bold col-12">Cuarto Cirujano</label>
    </div>
    <div class="row">
        <fieldset class="form-group col-4">
            <label for="for_name">Nivel 1</label>
            <input type="number" class="form-control" name="surgical4_level1" value="{{ $denominationFormula->surgical4_level1 }}">
        </fieldset>
        <fieldset class="form-group col-4">
            <label for="for_name">Nivel 2</label>
            <input type="number" class="form-control" name="surgical4_level2" value="{{ $denominationFormula->surgical4_level2 }}">
        </fieldset>
        <fieldset class="form-group col-4">
            <label for="for_name">Nivel 3</label>
            <input type="number" class="form-control" name="surgical4_level3" value="{{ $denominationFormula->surgical4_level3 }}">
        </fieldset>
    </div>
    <hr>
        <div class="row">
          <label class="font-weight-bold col-12">Anestecista</label>
        </div>
        <div class="row">
            <fieldset class="form-group col-4">
                <label for="for_name">Nivel 1</label>
                <input type="number" class="form-control" name="anest1_level1" value="{{ $denominationFormula->anest1_level1 }}">
            </fieldset>
            <fieldset class="form-group col-4">
                <label for="for_name">Nivel 2</label>
                <input type="number" class="form-control" name="anest1_level2" value="{{ $denominationFormula->anest1_level2 }}">
            </fieldset>
            <fieldset class="form-group col-4">
                <label for="for_name">Nivel 3</label>
                <input type="number" class="form-control" name="anest1_level3" value="{{ $denominationFormula->anest1_level3 }}">
            </fieldset>
        </div>
<br>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('rrhh.service-request.parameters.formula.index') }}">Volver</a>
</form>


@endsection

@section('custom_js')

@endsection
