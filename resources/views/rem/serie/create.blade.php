@extends('layouts.bt4.app')

@section('content')
@include('rem.nav')

<h3 class="mb-3">Crear Nueva Serie de REM</h3>
<form method="post" id="form-edit" action="{{ route('rem.series.store') }}">
    @csrf
    @method('POST')
    <div class="form-row">
        <fieldset class="form-group col-2">
            <label for="for_name">Nombre Serie</label>
            <input type="text" class="form-control" name="name" id="for_name" autocomplete="off" maxlength="2">
        </fieldset>
    </div>
    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
</form>

@endsection

@section('custom_js')

@endsection