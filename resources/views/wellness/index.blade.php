@extends('layouts.app')

@section('title', 'Módulo de Bienestar')

@section('content')

@include('wellness.nav')

<div class="container my-5">
    <h1 class="text-center">¡Bienvenidos al Módulo de Bienestar!</h1>
    <hr>
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <p class="lead text-center">
                En este espacio podrás visualizar a través de la plataforma del iOnline, todos los archivos que sean cargados desde la plataforma en Excel de Bienestar, y el balance correspondiente.
            </p>
            <p class="text-center">
                Este módulo te permitirá tener un control más eficiente de los datos relacionados con el bienestar de los usuarios.
            </p>
        </div>
    </div>
</div>
@endsection