@extends('layouts.bt4.app')

@section('title', 'Denominación 1121')

@section('content')

<h3 class="mb-3">Denominación 1121</h3>

<a class="btn btn-primary mb-3" href="{{ route('rrhh.service-request.parameters.1121.create') }}">
    Crear
</a>

    @foreach($denominations1121 as $denomination1121)
    <div class="row">
    <table class="table table-bordered table-sm">
      <thead>
        <tr>
          <th scope="col" class="text-center">Código</th>
          <th scope="row" colspan="4" class="text-center">Denominación</th>
          <th scope="row" colspan="2" class="text-center">ID</th>
          <th scope="col" colspan="2" class="text-center">Pabellón</th>
          <th scope="col" colspan="2" class="text-center">EQ</th>
          <th scope="col" class="text-center">Editar</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td rowspan="6" class="align-middle text-center">{{ $denomination1121->code }}</th>
          <td colspan="4" rowspan="3">{{ $denomination1121->denomination }}</td>
          <td colspan="2">{{ $denomination1121->id }}</td>
          <td colspan="2">{{ $denomination1121->pavilion }}</td>
          <td colspan="2">{{ $denomination1121->eq }}</td>
          <td rowspan="7" class="align-middle text-center"><a class="btn btn-primary mb-3" href="{{ route('rrhh.service-request.parameters.1121.edit', $denomination1121) }}"><i class="fas fa-edit"></i></a></td>
        </tr>

        <tr>
          <th colspan="2" class="text-center">Nivel 1</th>
          <th colspan="2" class="text-center">Nivel 2</th>
          <th colspan="2" class="text-center">Nivel 3</th>
        </tr>

        <tr>
          <th class="text-center">Valor Total</th>
          <th class="text-center">Aporte B.</th>
          <th class="text-center">Valor Total</th>
          <th class="text-center">Aporte B.</th>
          <th class="text-center">Valor Total</th>
          <th class="text-center">Aporte B.</th>
        </tr>

        <tr>
          <th colspan="4">Anesteciólogo</th>
          <td>{{ $denomination1121->anest_level1_value}}</td>
          <td>{{ $denomination1121->anest_level1_aport}}</td>
          <td>{{ $denomination1121->anest_level2_value}}</td>
          <td>{{ $denomination1121->anest_level2_aport}}</td>
          <td>{{ $denomination1121->anest_level3_value}}</td>
          <td>{{ $denomination1121->anest_level3_aport}}</td>
        </tr>

        <tr>
          <th colspan="4">Horario Quirúrgico</th>
          <td>{{ $denomination1121->surgical_level1_value}}</td>
          <td>{{ $denomination1121->surgical_level1_aport}}</td>
          <td>{{ $denomination1121->surgical_level2_value}}</td>
          <td>{{ $denomination1121->surgical_level2_aport}}</td>
          <td>{{ $denomination1121->surgical_level3_value}}</td>
          <td>{{ $denomination1121->surgical_level3_aport}}</td>
        </tr>

        <tr>
          <th colspan="4">Procedimientos</th>
          <td>{{ $denomination1121->procedure_level1_value}}</td>
          <td>{{ $denomination1121->procedure_level1_aport}}</td>
          <td>{{ $denomination1121->procedure_level2_value}}</td>
          <td>{{ $denomination1121->procedure_level2_aport}}</td>
          <td>{{ $denomination1121->procedure_level3_value}}</td>
          <td>{{ $denomination1121->procedure_level3_aport}}</td>
        </tr>

      </tbody>
    </table>
    </div>
    <br>
    @endforeach

@endsection

@section('custom_js')

@endsection
