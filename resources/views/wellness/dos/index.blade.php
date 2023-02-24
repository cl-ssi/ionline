@extends('layouts.app')

@section('title', 'Carga de archivos TXT')

@section('content')

@include('wellness.nav')

<h3>Carga de archivos TXT</h3>
<form method="POST" action="#" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="file">Archivo TXT:</label>
        <input type="file" name="file" id="file" accept=".txt">
    </div>
    <button type="submit" class="btn btn-primary">Importar datos de TXT</button>
</form>
@endsection
