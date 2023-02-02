@extends('layouts.app')
@section('title', 'Calendario de Autoridades de la Unidad Organizacional')
@section('content')
<div>
   @livewire('authorities.show-subrogees', [
            'organizational_unit_id' => $ou->id,
            'organizational_unit_name' => $ou->name,
        ])
</div>
<hr>

<h1 class="mb-3">Calendario de Autoridades de la Unidad Organizacional {{ $ou->name }}</h1>
<div id="legend">
    <p>
        <span style="background-color: #FF0000;">&nbsp;&nbsp;&nbsp;&nbsp;</span> Feriados
        <span class="bg-primary text-dark;">&nbsp;&nbsp;&nbsp;&nbsp;</span> Manager
        <span class="bg-secondary text-dark;">&nbsp;&nbsp;&nbsp;&nbsp;</span> Delegate
        <span class="bg-warning text-dark;">&nbsp;&nbsp;&nbsp;&nbsp;</span> Secretary
        <a href="{{ route('rrhh.new-authorities.create', $ou) }}" class="btn btn-warning float-right">Crear Autoridad</a>
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
            <form action="{{ route('rrhh.new-authorities.update',$ou) }}" method="POST">
                @csrf
                @method('PUT')
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
                    <input type="date" class="form-control" id="authorityDate" name="start_date" readonly required>
                </div>

                <div class="form-group">
                    <label for="authorityDate">Hasta:</label>
                    <input type="date" class="form-control datepicker" id="endDate" name="end_date" required>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="updateFutureEventsCheck" name="updateFutureEventsCheck">
                        <label class="form-check-label" for="updateFutureEventsCheck">
                            ¿Desea modificar este y todos los eventos posteriores?
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Agregar">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
        
    </div>
</div>

</div>


@endsection
@section('custom_js')
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
      title: "{{ strtoupper($newAuthority->user->tinnyName) }}",
      start: "{{ $newAuthority->date }}",
      end: "{{ $newAuthority->date }}",
      allDay: true,
      backgroundColor: '#007bff',
      className:'authorities'
    });
    @endforeach

    @foreach($newAuthoritiesDelegate as $newAuthorityDelegate)
    events.push({
      title: "{{ strtoupper($newAuthorityDelegate->user->tinnyName) }}",
      start: "{{ $newAuthorityDelegate->date }}",
      end: "{{ $newAuthorityDelegate->date }}",
      allDay: true,
      backgroundColor: '#6c757d',
      className:'authorities'
    });
    @endforeach

    @foreach($newAuthoritiesSecretary as $newAuthoritySecretary)
    events.push({
      title: "{{ $newAuthoritySecretary->user->tinnyName }}".toLowerCase(),
      start: "{{ $newAuthoritySecretary->date }}",
      end: "{{ $newAuthoritySecretary->date }}",
      allDay: true,
      backgroundColor: '#ffc107'
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
          element.find('.fc-title').text(shortText).css({
    'text-align': 'center',
    'font-size': '17px'
  });
        }
      });
    }

    $('#addAuthorityButton').click(function() {
      var authorityId = $('#authoritySelect').val();
      var date = $('#authorityDate').val();

      $('#addAuthorityModal').modal('hide');

      $("#endDate").attr("min", $('#authorityDate').val());
    });


    $("#updateFutureEventsCheck").change(function() {
        if(this.checked) {
            $("#endDate").prop("disabled", true);
        } else {
            $("#endDate").prop("disabled", false);
        }
    });
  });
</script>
@endsection