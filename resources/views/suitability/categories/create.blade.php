@extends('layouts.app')

@section('content')

@include('suitability.nav')
<h3 class="mb-3">Crear Categoría</h3>
<form method="POST" class="form-horizontal" action="{{ route('suitability.categories.store') }}">
    @csrf
    @method('POST')
    <div class="row">
        <fieldset class="form-group col-6">
            <label for="for_critic_stock">Nombre*</label>
            <input type="text" class="form-control" id="for_critic_stock" placeholder="" name="name" required="">
        </fieldset>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>

@endsection

@section('custom_js')

@endsection