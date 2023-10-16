@extends('layouts.bt4.app')

@section('title', 'Formulas')

@section('content')

<h3 class="mb-3">Formulas</h3>

<a class="btn btn-primary mb-3" href="{{ route('rrhh.service-request.parameters.formula.create') }}">

    Crear
</a>

@foreach($denominationsFormula as $denominationFormula)
<div class="row">
<table class="table table-bordered table-sm">
  <thead>
    <tr>
      <th scope="col" class="text-center">Código</th>
      <th scope="row" colspan="4" class="text-center">Denominación</th>
      <th scope="row" class="text-center">ID</th>
      <th scope="col" class="text-center">Pabellón</th>
      <th scope="col" class="text-center">EQ</th>
      <th scope="col" class="text-center">Editar</th>
    </tr>
  </thead>

  <tbody>
    <tr>
      <td rowspan="8" class="align-middle text-center">{{ $denominationFormula->code }}</th>
      <td colspan="4" rowspan="2">{{ $denominationFormula->denomination }}</td>
      <td>{{ $denominationFormula->id }}</td>
      <td>{{ $denominationFormula->pavilion }}</td>
      <td>{{ $denominationFormula->eq }}</td>
      <td rowspan="7" class="align-middle text-center"><a class="btn btn-primary mb-3" href="{{ route('rrhh.service-request.parameters.formula.edit', $denominationFormula) }}"><i class="fas fa-edit"></i></a></td>
    </tr>

    <tr>
      <th class="text-center">Nivel 1</th>
      <th class="text-center">Nivel 2</th>
      <th class="text-center">Nivel 3</th>
    </tr>

    <tr>
      <th colspan="4">Primer Cirujano</th>
      <td>{{ $denominationFormula->surgical1_level1}}</td>
      <td>{{ $denominationFormula->surgical1_level2}}</td>
      <td>{{ $denominationFormula->surgical1_level3}}</td>
    </tr>

    <tr>
      <th colspan="4">Segundo Cirujano</th>
      <td>{{ $denominationFormula->surgical2_level1}}</td>
      <td>{{ $denominationFormula->surgical2_level2}}</td>
      <td>{{ $denominationFormula->surgical2_level3}}</td>
    </tr>

    <tr>
      <th colspan="4">Tercer Cirujano</th>
      <td>{{ $denominationFormula->surgical3_level1}}</td>
      <td>{{ $denominationFormula->surgical3_level2}}</td>
      <td>{{ $denominationFormula->surgical3_level3}}</td>
    </tr>

    <tr>
      <th colspan="4">Cuarto Cirujano</th>
      <td>{{ $denominationFormula->surgical4_level1}}</td>
      <td>{{ $denominationFormula->surgical4_level2}}</td>
      <td>{{ $denominationFormula->surgical4_level3}}</td>
    </tr>

    <tr>
      <th colspan="4">Anestecista</th>
      <td>{{ $denominationFormula->anest1_level1}}</td>
      <td>{{ $denominationFormula->anest1_level2}}</td>
      <td>{{ $denominationFormula->anest1_level3}}</td>
    </tr>

  </tbody>
</table>
</div>
<br>
@endforeach

@endsection

@section('custom_js')

@endsection
