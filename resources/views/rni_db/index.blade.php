@extends('layouts.app')

@section('title', 'Base datos RNI')

@section('content')

<h3 class="mb-3">Base de datos RNI</h3>

@can('RNI Database: admin')
<form method="POST" class="form-inline" action="{{ route('indicators.rni_db.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label class="sr-only" for="importFile">Example file input</label>
        <input type="file" name="file" class="form-control-file form-control-sm mb-2 mr-sm-2 pl-0" id="importFile" accept=".xlsx, .xls, .csv" required>
    </div>
    <button type="submit" class="btn btn-primary mb-2 btn-sm"><i class="fas fa-save" aria-hidden="true"></i> Guardar</button>
</form>
@endcan

<table class="table table-condensed table-bordered table-sm small">
    <thead>
        <tr>
            <th>Nombre Archivo</th>
            <th>Tamaño</th>
            <th>Última actualización</th>
            <th>Descargar</th>
        </tr>
    </thead>

@foreach ($files as $file)
<tr>
    <td>{{ $file['basename'] }}</td>
    <td>{{ number_format($file['size']/1024, 2) }} KB</td>
    <td>{{ Carbon\Carbon::createFromTimestamp($file['timestamp'])->diffForHumans()}}</td>
    <td>
      <a href="{{ route('indicators.rni_db.download', $file['basename']) }}" class="btn btn-outline-secondary btn-sm" title="">
                        <span class="fas fa-download" aria-hidden="true"></span></a>
    </td>
</tr>
@endforeach

</table>

@endsection

@section('custom_js')
<script type="text/javascript">
    $('input[type="file"]').bind('change', function(e) {
    //Validación de tamaño
    if((this.files[0].size / 1024 / 1024) > 3){
        alert('No puede cargar archivos de más de 3 MB.');
        $(this).val('');
    }
    //Validación de .xlsx, .xls, .csv
    const allowedExtensions = ["xlsx", "xls", "csv"];
    if( (this).id == 'importFile' && !allowedExtensions.includes(this.files[0]?.name.split('.').pop())){
        alert("Debe seleccionar un archivo con extensión xlsx, xls o csv.");
        $(this).val('');
    }
    });
</script>
@endsection

@section('custom_js_head')

@endsection
