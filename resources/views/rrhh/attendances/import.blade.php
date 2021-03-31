@extends('layouts.app')

@section('title', 'Importar marcas')

@section('content')
<h3 class="mb-3">Importar marcas</h3>

<form method="POST" class="form-horizontal" action="{{ route('rrhh.attendance.store') }}" enctype="multipart/form-data">
@csrf
@method('POST')

<div class="form-row">
    <div class="form-group">
      <label for="">Archivo de asistencia</label>
      <input type="file" class="form-control-file" name="attendances_file" id="file" aria-describedby="file">
      <small id="file" class="form-text text-muted">Archivo txt de reloj control</small>
    </div>
</div>

<button type="submit" class="btn btn-primary">Guardar</button>

</form>

@if($attendances ?? '')
<table class="table">
    <thead>
        <tr>
            <th>Run</th>
            <th>Marca</th>
            <th>Tipo</th>
            <th>Reloj</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach( $attendances ?? '' as $a)
        <tr>
            <td>{{ $a->user_id }}</td>
            <td>{{ $a->timestamp }}</td>
            <td>{{ $a->type }}</td>
            <td>{{ $a->clock_id }}</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@endsection

@section('custom_js')

@endsection