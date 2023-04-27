@extends('layouts.mail')

@section('content')

<strong>COMPROBANTE DE INGRESO DE NUEVO REGISTRO</strong><br><br>
<strong>MÓDULO DE INTEGRIDAD Y ÉTICA</strong><br><br>
<hr>
<div class="justify">
    <div class="card">
        <div class="card-body">

            <h3 class="mb-3">
                Correo de prueba enviado a {{ $user->shortName }}
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

@section('firmante', 'SSI Intranet')

@section('linea1', 'Módulo de integridad y ética')

@section('linea2', 'Unidad de Informática y Tecnología')

@section('linea3', 'sistemas.ssi@redsalud.gob.cl')
