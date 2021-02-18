@extends('layouts.mail')

@section('content')

<div style="text-align: justify;">
  <p>Junto con saludar cordialmente.</p>
  <p>Se informa que {{$sender_name}} ha derivado <b>{{$cantidad}}</b> solicitudes de contratación honorarios a su nombre.</p>
  <br>
  Saludos cordiales.
</div>

@endsection
