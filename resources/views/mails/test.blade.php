@extends('layouts.mail')

@section('content')

<strong>CORREO DE PRUEBA ENVIADO DESDE IONLINE</strong><br><br>

<hr>

<div class="justify">
    <div class="card">
        <div class="card-body">

            <h3 class="mb-3">
                Usuario: {{ $user->shortName }}
            </h3>


            <div class="card">
                <div class="card-body">
                    Enviado a: {{ $user->email_personal }}
                </div>
            </div>



        </div>
    </div>
</div>

@endsection

@section('firmante', 'Intranet Servicio de Salud Tarapacá')

@section('linea1', 'Módulo de .....')

@section('linea2', 'Departamento de Tecnologías de la Información y Telecomunicaciones')

@section('linea3', 'sistemas.ssi@redsalud.gob.cl')
