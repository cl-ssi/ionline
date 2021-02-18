@extends('layouts.app')

@section('title', 'Reporte COVID-19')

@section('content')

<h3 class="mb-3">Reporte estado de solicitudes</h3>

<h4>Subtotales</h4>
<hr>
<table class="table table-sm table-bordered table-responsive small" >
    <thead>
        <tr class="text-center">
            <th>FUNCIONARIO</th>
            <th>CANTIDAD</th>
        </tr>
    </thead>
    <tbody>
      @foreach($group_array as $key => $data)
      @if($key != NULL)
        <tr>
          <td nowrap>{{$key}}</td>
          <td nowrap>{{$data}}</td>
        </tr>
      @endif
      @endforeach
    </tbody>
</table>

<h4>Detalle</h4>
<hr>
<table class="table table-sm table-bordered table-responsive small" >
    <thead>
        <tr class="text-center">
            <th>ID</th>
            <th>APROBADAS</th>
            <th>RECHAZADAS</th>
            <th>VISADOR PENDIENTE</th>
        </tr>
    </thead>
    <tbody>
      @foreach($array as $key => $data)
        <tr>
          <td nowrap>{{$key}}</td>
          <td nowrap>{{$data['aprobados']}}</td>
          <td nowrap>{{$data['rechazados']}}</td>
          <td nowrap>{{$data['falta_aprobar']}}</td>
        </tr>
      @endforeach
    </tbody>
</table>

@endsection

@section('custom_js_head')
<script type="text/javascript">

</script>
@endsection
