@extends('layouts.mail')

@section('content')

    <div style="text-align: justify;">
        <p> <h2>{{$birthdayEmailConfiguration->tittle}}</h2></p>
        <p> Estimado(a) {{$sirhActiveUser->name}},</p>
        <p> {!!$birthdayEmailConfiguration->message!!}</p>
    </div>

@endsection

@section('firmante', 'Servicio de Salud Iquique')

@section('linea1', 'Anexo Minsal: 579502 - 579503')