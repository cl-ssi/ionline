@extends('layouts.bt4.app')

@section('title', 'Crear Denominación')

@section('content')

<h3 class="mb-3">Crear Denominaciones</h3>

<form method="POST" class="form-horizontal" action="{{ route('rrhh.service-request.parameters.1121.store') }}">
    @csrf

    <div class="row">
        <fieldset class="form-group col-3">
            <label for="for_name">ID</label>
            <input type="number" class="form-control" disabled>
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_address">Código</label>
            <input type="number" class="form-control" name="code" required>
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_address">Pabellón</label>
            <input type="number" class="form-control"  name="pavilion">
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_address">EQ.</label>
            <input type="number" class="form-control"  name="eq">
        </fieldset>
    </div>

    <div class="row">
      <fieldset class="form-group col-12">
          <label for="for_name">Denominación</label>
          <textarea type="text" rows="4" class="form-control" id="for_name" name="denomination"></textarea>
      </fieldset>
    </div>

    <br>
    <div class="row">
      <label class="font-weight-bold">Anestesiólogo</label>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Valor Total</th>
            <th scope="col">Aporte Benef.</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Nivel 1</th>
            <td><input type="number" class="form-control"  name="anest_level1_value"></td>
            <td><input type="number" class="form-control"  name="anest_level1_aport"></td>
          </tr>
          <tr>
            <th scope="row">Nivel 2</th>
            <td><input type="number" class="form-control"  name="anest_level2_value"></td>
            <td><input type="number" class="form-control"  name="anest_level2_aport"></td>
          </tr>
          <tr>
            <th scope="row">Nivel 3</th>
            <td><input type="number" class="form-control"  name="anest_level3_value"></td>
            <td><input type="number" class="form-control"  name="anest_level3_aport"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <hr>
    <br>
    <div class="row">
      <label class="font-weight-bold">Horario Quirúrgico</label>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Valor Total</th>
            <th scope="col">Aporte Benef.</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Nivel 1</th>
            <td><input type="number" class="form-control"  name="surgical_level1_value"></td>
            <td><input type="number" class="form-control"  name="surgical_level1_aport"></td>
          </tr>
          <tr>
            <th scope="row">Nivel 2</th>
            <td><input type="number" class="form-control"  name="surgical_level2_value"></td>
            <td><input type="number" class="form-control"  name="surgical_level2_aport"></td>
          </tr>
          <tr>
            <th scope="row">Nivel 3</th>
            <td><input type="number" class="form-control"  name="surgical_level3_value"></td>
            <td><input type="number" class="form-control"  name="surgical_level3_aport"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <hr>
    <br>
    <div class="row">
      <label class="font-weight-bold">Procedimientos</label>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Valor Total</th>
            <th scope="col">Aporte Benef.</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Nivel 1</th>
            <td><input type="number" class="form-control"  name="procedure_level1_value"></td>
            <td><input type="number" class="form-control"  name="procedure_level1_aport"></td>
          </tr>
          <tr>
            <th scope="row">Nivel 2</th>
            <td><input type="number" class="form-control"  name="procedure_level2_value"></td>
            <td><input type="number" class="form-control"  name="procedure_level2_aport"></td>
          </tr>
          <tr>
            <th scope="row">Nivel 3</th>
            <td><input type="number" class="form-control"  name="procedure_level3_value"></td>
            <td><input type="number" class="form-control"  name="procedure_level3_aport"></td>
          </tr>
        </tbody>
      </table>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('rrhh.service-request.parameters.1121.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
