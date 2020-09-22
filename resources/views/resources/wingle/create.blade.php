@extends('layouts.app')

@section('title', 'Crear Banda Ancha Movil')

@section('content')

<h3 class="mb-3">Ingresar nueva Banda Ancha Móvil</h3>

<form method="POST" class="form-horizontal" action="{{ route('resources.wingle.store') }}">
    {{ csrf_field() }} <!-- input hidden contra ataques CSRF -->

     <fieldset class="form-group">
        <label for="forbrand">Marca</label>
        <input type="text" class="form-control" id="forbrand" placeholder="Marca" name="brand" required="">
     </fieldset>

     <fieldset class="form-group">
        <label for="formodel">Modelo</label>
        <input type="text" class="form-control" id="formodel" placeholder="Ingrese el modelo" name="model" required="">
     </fieldset>

     <fieldset class="form-group">
       <label for="forcompany">Compañia</label>
       <input type="text" class="form-control" id="forcompany" placeholder="Ingrese la compañia" name="company" required="">
     </fieldset>

     <fieldset class="form-group">
        <label for="formei">IMEI</label>
        <input type="text" class="form-control" id="forimei" placeholder="" name="imei" required="">
     </fieldset>

     <fieldset class="form-group">
        <label for="formpassword">Password Activación</label>
        <input type="text" class="form-control" id="forpassword" placeholder="contraseña" name="password" required="">
     </fieldset>

     <p align="right">
       <a href="{{ route('resources.wingle.index') }}" class="btn btn-outline-secondary">Cancelar</a>
       <a href="{{ route('resources.wingle.create') }}"><button class="btn btn-outline-secondary"><i class="fas fa-save"></i> Enviar</button></a></p>

</form>

@endsection
