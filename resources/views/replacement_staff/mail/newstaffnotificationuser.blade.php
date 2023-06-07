@extends('layouts.mail')

@section('content')

<div style="text-align: justify;">

  <h4>Estimado/a {{ $replacementStaff->name }}</h4>

  <br>

  <p align="justify">El Servicio de Salud Tarapacá agradece su interés de postular a ser parte de nuestro
    Staff de Reemplazos, sus antecedentes han sido ingresados a nuestra base de datos
    para ser considerados en los requerimientos de nuestra institución.
  </p>

  <p align="justify">Sobre lo anterior, se sugiere mantener actualizados los datos requeridos en el sistema,
    completando los apartados de <strong>Perfil de Experiencia Laboral</strong> y de <strong>Capacitaciones</strong>
    (en caso que posea), esto permitirá a nuestro equipo evaluar sus antecedentes y
    poder considerarlo para ser parte de los procesos de reemplazos y suplencias del Servicio de Salud Iquique.
  </p>

  <ul>
      <li><strong>Fecha de Ingreso de Antecedentes</strong>: {{ \Carbon\Carbon::parse($replacementStaff->created_at)->format('d-m-Y H:i:s') }}</li>
  </ul>

  <hr>

  <br>

  <p>Esto es un mensaje automatico de: {{ env('APP_NAME') }} -  {{ env('APP_SS') }}.</p>

</div>

@endsection
