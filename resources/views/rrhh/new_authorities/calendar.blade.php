@extends('layouts.app')
@section('title', 'Calendario de Autoridades de la Unidad Organizacional')
@section('content')

<h1 class="mb-3">Calendario de Autoridades de la Unidad Organizacional {{ $ou->name }}</h1>

<div id="legend">
  <p>
    <span style="background-color: #FF0000;">&nbsp;&nbsp;&nbsp;&nbsp;</span> Feriados
    <span style="background-color: #00FF00;">&nbsp;&nbsp;&nbsp;&nbsp;</span> Oficial
  </p>
  <!-- Agregar más elementos aquí según sea necesario -->
</div>
<div id="calendar"></div>

@endsection
@section('custom_js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/es.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
  <script>
$(document).ready(function () {
  var holidays = @json($holidays);
  var events = [];
  holidays.forEach(function (holiday) {
    events.push({
      title: holiday.name,
      start: holiday.date,
      end: holiday.date,
      allDay: true,
      backgroundColor: '#FF0000'
    });
  });
  @foreach ($newAuthorities as $newAuthority)
    events.push({
      title: "{{ $newAuthority->user->fullname }}",
      start: "{{ $newAuthority->from }}",
      end: "{{ $newAuthority->to }}",
      allDay: true,
      backgroundColor: '#00FF00'
    });
  @endforeach
  $('#calendar').fullCalendar({
    lang: 'es',
    firstDay: 1,
    events: events,
    eventRender: function(event, element) {
    element.css('background-color', event.backgroundColor);
    element.css('text-align', 'center');
    element.css('vertical-align', 'middle');
    element.css('height', '100%');
    element.css('width', '100%');
    element.css('display', 'table');
  }
  });
});
  </script>
@endsection