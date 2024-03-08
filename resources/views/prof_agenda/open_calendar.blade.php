@extends('layouts.bt4.app')

@section('title', 'Aperturar agenda')

@section('content')

@include('prof_agenda.partials.nav')

<h3>Aperturar agenda</h3>

<form method="GET" class="form-horizontal" action="{{ route('prof_agenda.proposals.open_calendar') }}">

<div class="row">
    <fieldset class="form-group col col-md-4">
        <label for="for_type">Funcionario</label>
        <select class="form-control" name="user_id">
            <option value=""></option>
            @foreach($users as $user)
                <option value="{{$user->id}}" @selected(old('user_id') == $user->id)>{{$user->shortName}}</option>
            @endforeach
        </select>
    </fieldset>
    <fieldset class="form-group col col-md">
        <label for="for_start_date">Fecha Inicio</label>
        <input type="date" class="form-control" name="start_date" value="{{old('start_date')}}" required>
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_end_date">Fecha Término</label>
        <input type="date" class="form-control" name="end_date" value="{{old('end_date')}}" required>
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_end_date"><br></label>
        <button type="submit" class="btn btn-success form-control">
            <i class="fa fa-folder-open"></i> Aperturar
        </button>
    </fieldset>
    
</div>

</form>

<hr>

<html lang='en'>
  <head>
    <meta charset='utf-8' />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            

            editable: false,
            // headerToolbar : {
            //     start: '', // will normally be on the left. if RTL, will be on the right
            //     center: '',
            //     end: '' // will normally be on the right. if RTL, will be on the left
            // },
            
            // dayHeaderFormat : { weekday: 'short' }, 

            initialView: 'timeGridWeek',
            allDaySlot: false,
            firstDay: 1,
            slotMinTime: "08:00:00",
            locale: 'es',
            displayEventTime: false,
            slotDuration: '00:20',

            events: [

              // última ficha aceptada
              @foreach($block_dates as $key => $block_date)
                {
                title: '{{$block_date['activity_name']}}',
                start: '{{$block_date['start_date']}}',
                end: '{{$block_date['end_date']}}',
                color: '{{$block_date['color']}}'
                },
              @endforeach
            ],
        });

        calendar.render();
      });

    </script>
  </head>
  <body>
    <div id='calendar'></div>
  </body>
</html>


@endsection

<!-- CSS Custom para el calendario -->
@section('custom_css')

@endsection

@section('custom_js')

@endsection
