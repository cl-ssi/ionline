@extends('layouts.app')
@section('title', 'Calendario de Autoridades de la Unidad Organizacional')
@section('content')
<h1 class="mb-3">Calendario de Autoridades de la Unidad Organizacional {{ $ou->name }}</h1>
<div id="legend">
    <p>
        <span style="background-color: #FF0000;">&nbsp;&nbsp;&nbsp;&nbsp;</span> Feriados
        <span style="background-color: #00FF00;">&nbsp;&nbsp;&nbsp;&nbsp;</span> Manager
        <span style="background-color: #0000FF;">&nbsp;&nbsp;&nbsp;&nbsp;</span> Delegate
        <span style="background-color: #FFFF00;">&nbsp;&nbsp;&nbsp;&nbsp;</span> Secretary
        <a href="{{ route('rrhh.new-authorities.create', $ou) }}" class="btn btn-success float-right">Crear Autoridad</a>
    </p>
</div>
<div id="calendar"></div>
<!-- Modal para agregar una autoridad -->
<div class="modal fade" id="addAuthorityModal" tabindex="-1" role="dialog" aria-labelledby="addAuthorityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAuthorityModalLabel">Agregar Subrogante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('rrhh.new-authorities.store') }}" method="POST">
                    <div class="form-group">
                        <label for="authoritySelect">Subrogante:</label>
                        <select class="form-control" id="authoritySelect" name="user_id" required>
                            <option value="">Seleccionar Subrogante</option>
                            @foreach($subrogants as $subrogant)
                            <option value="{{ $subrogant->subrogant->id }}">{{$subrogant->subrogant->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="authorityDate">Desde:</label>
                        <input type="date" class="form-control" id="authorityDate" disabled>
                    </div>

                    <div class="form-group">
                        <label for="authorityDate">Hasta:</label>
                        <input type="text" class="form-control datepicker" id="endDate" name="end_date" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="addAuthorityButton">Agregar</button>
            </div>
        </div>
    </div>
</div>


@endsection
@section('custom_js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/es.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
<script>
  $(document).ready(function() {
    var holidays = @json($holidays);
    var events = [];
    holidays.forEach(function(holiday) {
      events.push({
        title: holiday.name,
        start: holiday.date,
        end: holiday.date,
        allDay: true,
        backgroundColor: '#FF0000'
      });
    });
    @foreach($newAuthorities as $newAuthority)
    events.push({
      title: "{{ $newAuthority->user->fullname }}",
      start: "{{ $newAuthority->date }}",
      end: "{{ $newAuthority->date }}",
      allDay: true,
      backgroundColor: '#00FF00'
    });
    @endforeach

    if (events.length > 0) {
      $('#calendar').fullCalendar({
        lang: 'es',
        firstDay: 1,
        events: events,
        eventClick: function(event, jsEvent, view) {
          $('#authorityDate').val(event.start.format());
          $('#addAuthorityModal').modal('show');
        },
        eventRender: function(event, element) {
          var MAX_LENGTH = 30; // tamaño máximo de la cadena
          var shortText = event.title;
          if (event.title.length > MAX_LENGTH) {
            shortText = event.title.substring(0, MAX_LENGTH) + '...';
          }
          element.find('.fc-title').text(shortText);
        }
      });
    }

    $('#addAuthorityButton').click(function() {
      var authorityId = $('#authoritySelect').val();
      var date = $('#authorityDate').val();

      $('#addAuthorityModal').modal('hide');
    });

  });
</script>

@endsection