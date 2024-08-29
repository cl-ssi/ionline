<div>
    <div>
        <div id='calendar-container' wire:ignore>
            <div id='calendar'></div>
        </div>
    </div>

    {{-- info modal start --}}
    <div class="modal fade" id="info-modal" aria-labelledby="info-modal-label" aria-hidden="true" tabindex="-1"
        wire:ignore.self
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" id="info-header">
                    <h5 class="info-modal-title" id="title-info">
                        </p>Informacion</h5>
                    <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span>
                        <h5>Fecha Inicio</h5>
                        <p id="start-date-info"></p>
                    </span>

                    <span>
                        <h5>Fecha Termino</h5>
                        <p id="end-date-info"></p>
                    </span>

                    @can('Calendar: car')
                    <div>
                        <span>
                            <h5>Conductor</h5>
                            <p id="driver-info"></p>
                        </span>
                    </div>

                    <span>
                        <h5>Destinario</h5>
                        <p id="recipient-info"></p>
                    </span>

                    <span>
                        <h5>Destino</h5>
                        <p id="location-info"></p>
                    </span>

                    <span>
                        <h5>Cantidad Pasajeros</h5>
                        <p id="passengers-info"></p>
                    </span>

                    <span>
                        <h5>Patente Vehiculo</h5>
                        <p id="car-info"></p>
                    </span>

                    <span>
                        <h5>Estado</h5>
                        <p id="state-info"></p>
                    </span>

                    @endcan
                </div>
                @can('Calendar: car')
                <div class="modal-footer">
                    <button class="btn btn-warning" id="edit-button" type="submit">Editar</button>
                    <button class="btn btn-danger" id="delete-button" type="submit">Eliminar</button>
                </div>
                @endcan

            </div>
        </div>
    </div>
    {{-- info modal ending --}}

    {{-- create modal start --}}
    <div class="modal fade" id="create-modal" aria-labelledby="create-modal-label" aria-hidden="true" tabindex="-1"
        wire:ignore.self
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="create-modal-title" id="create-modal-label">Crear Evento</h5>
                    <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="create_event_form">
                        <div class="form-group">
                            <label for="create_title_input">Titulo</label>
                            <input class="form-control" id="create_title_input" name="create_title_input" type="text"
                                placeholder="Escriba el Titulo del Evento"
                            >
                            <span class="text-danger" id="create_title_error"></span>
                        </div>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-6 pl-0 pr-1">
                                    <div class="form-group">
                                        <label for="create_start_input">Fecha Inicio</label>
                                        <input class="form-control" id="create_start_input" name="create_start_input"
                                            type="datetime-local"
                                        >
                                        <span class="text-danger" id="create_start_error"></span>

                                    </div>
                                </div>
                                <div class="col-6 pl-1 pr-0">
                                    <div class="form-group">
                                        <label for="create_end_input">Fecha Termino</label>
                                        <input class="form-control" id="create_end_input" name="end"
                                            type="datetime-local"
                                        >
                                        <span class="text-danger" id="create_end_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="crate_driver_id">Conductor</label>
                            @livewire('search-select-user', ['selected_id' => 'driver_id'])
                            <span class="text-danger" id="create_driver_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="create-recipient-id">Destinario</label>
                            @livewire('search-select-user', ['selected_id' => 'recipient_id'])
                            <span class="text-danger" id="create_recipient_error"></span>
                        </div>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-6 pl-0 pr-1">
                                    <div class="form-group">
                                        <label for="create_car_input">Patente Vehiculo</label>
                                        <input class="form-control" id="create_car_input" name="car_id" type="text"
                                            placeholder="Escriba la patente"
                                        >
                                    </div>
                                </div>
                                <div class="col-6 pl-1 pr-0">
                                    <div class="form-group">
                                        <label for="create_passengers_input">Numero de Pasajeros</label>
                                        <input class="form-control" id="create_passengers_input"
                                            name="passenger_number" type="number" placeholder="(Valor de 1 a 4)"
                                            min="1" max="4"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-6 pl-0 pr-1">
                                    <div class="form-group">
                                        <label for="create-location-input">Destino</label>
                                        <input class="form-control" id="create_location_input" name="location"
                                            type="text" placeholder="Escriba el Destino"
                                        >
                                        @error('location')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 pl-1 pr-0">
                                    <div class="form-group">
                                        <label for="create-state-input">Estado</label>
                                        <select class="custom-select" id="create_state_option"
                                            name='create_state_option'
                                        >
                                            <option selected>Seleccione un estado</option>
                                            <option
                                                value="En Mantencion"style="background-color: #d50300; color: white"
                                            >En Mantencion</option>
                                            <option value="Por Confirmar" style="background-color: #e67c73">Por
                                                Confirmar</option>
                                            <option value="En Espera" style="background-color: #f6bf25">En Espera
                                            </option>
                                            <option value="Agendado" style="background-color: #33b679">Agendado
                                            </option>
                                            <option value="Disponible" style="background-color: #039be5">Disponible
                                            </option>
                                            <option value="Suspendido"style="background-color: #626161; color: white">
                                                Suspendido</option>
                                        </select>
                                        @error('state')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="form-control btn btn-primary" id="create_submit_btn"
                            type="submit">Guardar</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    {{-- create modal ending --}}



    <div class="form-row mb-4 justify-content-end">
        <div style="color:#d50300">&#9632;</div>&nbsp;<p>En Mantencion</p>&nbsp;&nbsp;
        <div style="color:#e67c73">&#9632;</div>&nbsp;<p>Por Confirmar</p>&nbsp;&nbsp;
        <div style="color:#f6bf25">&#9632;</div>&nbsp;<p>En Espera</p>&nbsp;&nbsp;
        <div style="color:#33b679">&#9632;</div>&nbsp;<p>Agendado</p>&nbsp;&nbsp;
        <div style="color:#039be5">&#9632;</div>&nbsp;<p>Disponible</p>&nbsp;&nbsp;
        <div style="color:#626161">&#9632;</div>&nbsp;<p>Suspendido</p>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"
        ></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function getBackgroundColor($state) {
                switch ($state) {
                    case 'En Mantencion':
                        return '#d50300';
                        break;
                    case 'Por Confirmar':
                        return '#e67c73';
                        break;
                    case 'En Espera':
                        return '#f6bf25';
                        break;
                    case 'Agendado':
                        return '#33b679';
                        break;
                    case 'Disponible':
                        return '#039be5';
                        break;
                    case 'Suspendido':
                        return '#626161';
                        break;
                    default:
                        return '#33b679';
                        break;
                }
            }

            let canEditContent = false;

            document.addEventListener('livewire:init', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var Calendar = FullCalendar.Calendar;
                var calendarEl = document.getElementById('calendar');
                var calendar = new Calendar(calendarEl, {
                    timeZone: 'America/Santiago',
                    initialView: 'dayGridMonth',
                    dayMaxEvents: true,
                    selectable: true,
                    fixedWeekCount: false,
                    allDayText: 'Todo el dia',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    locale: 'es',
                    firstDay: 1,
                    buttonText: {
                        today: 'hoy',
                        month: 'mes',
                        week: 'semana',
                        day: 'dia',
                    },
                    events: '/vehicleCalendar',
                    eventClick: function(info) {
                        $('#info-modal').modal('toggle');
                        $('#title-info').text(info.event.title);
                        $('#start-date-info').text(new Date(info.event.startStr).toLocaleString('es-CL'));
                        $('#end-date-info').text(new Date(info.event.endStr).toLocaleString('es-CL'));
                        $('#info-header').css("backgroundColor", info.event.backgroundColor);
                        $('#location-info').text(info.event.extendedProps.location);
                        $('#car-info').text(info.event.extendedProps.car_id);
                        $('#passengers-info').text(info.event.extendedProps.passenger_number);
                        $('#state-info').text(info.event.extendedProps.state);
                        $('#driver-info').text(info.event.extendedProps.driver_fullname);
                        $('#recipient-info').text(info.event.extendedProps.recipient_fullname);

                        var id = info.event.id;

                        $('#delete-button').click(function(e) {
                            Swal.fire({
                                title: "Esta Seguro?",
                                text: "Este evento no se puede recuperar!",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Borrar!",
                                cancelButtonText: "Cancelar",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: "/vehicleCalendar/destroy/" + id,
                                        type: "DELETE",
                                        dataType: 'json',
                                        success: function(response) {
                                            info.event.remove();
                                            $('#info-modal').modal('toggle');
                                            Swal.fire({
                                                title: "Elemento eliminado!",
                                                text: "Se ha borrado el evento seleccionado!",
                                                icon: "success"
                                            });
                                        },
                                        error: function(error) {
                                            console.log(error)
                                        },
                                    });
                                }
                            })
                        });

                        $('#edit-button').click(function(e) {
                            $('#info-modal').modal('toggle');
                            $('#edit-modal').modal('toggle');

                            $('#edit_event_form').off('submit');

                            $('#edit_title_input').val(info.event.title);
                            $('#edit_start_input').val(info.event.startStr);
                            $('#edit_end_input').val(info.event.endStr);

                            $('#edit_car_input').val(info.event.extendedProps.car_id);
                            $('#edit_passengers_input').val(info.event.extendedProps
                                .passenger_number);
                            $('#edit_location_input').val(info.event.extendedProps.location);

                            $('#edit_state_option').val(info.event.extendedProps.state);

                            $('#edit_modal_header').css("backgroundColor", info.event
                                .backgroundColor);

                            $('#edit_event_form').submit(function(e) {
                                e.preventDefault();

                                var formData = {
                                    title: $('#edit_title_input').val(),
                                    start: $('#edit_start_input').val(),
                                    end: $('#edit_end_input').val(),
                                    driver_id: info.event.extendedProps.driver_id,
                                    recipient_id: info.event.extendedProps.recipient_id,
                                    car_id: $('#edit_car_input').val(),
                                    passenger_number: $('#edit_passengers_input').val(),
                                    location: $('#edit_location_input').val(),
                                    state: $('#edit_state_option').val(),
                                    backgroundColor: getBackgroundColor($(
                                            '#edit_state_option')
                                        .val()),
                                    type: 'vehicle',
                                };

                                $.ajax({
                                    url: "vehicleCalendar/edit/" + info.event.id,
                                    type: "PATCH",
                                    dataType: 'json',
                                    data: formData,
                                    success: function(response) {
                                        calendar.refetchEvents();
                                        $("#edit-modal").modal("hide");
                                    },
                                    error: function(error) {
                                        console.error(
                                            'Error al modificar evento:',
                                            error);
                                    },
                                });
                            });
                        });

                    },
                    select: function(info) {
                        $('#create_event_form').off('submit');
                        $('#create_start_input').val(info.startStr);
                        $('#create_end_input').val(info.endStr);

                        $('#create-modal').modal('toggle');

                        $('#create_event_form').submit(function(e) {
                            e.preventDefault();

                            var formData = {
                                title: $('#create_title_input').val(),
                                start: $('#create_start_input').val(),
                                end: $('#create_end_input').val(),
                                driver_id: $('input[name="driver_id"').val(),
                                recipient_id: $('input[name="recipient_id"').val(),
                                car_id: $('#create_car_input').val(),
                                passenger_number: $('#create_passengers_input').val(),
                                location: $('#create_location_input').val(),
                                state: $('#create_state_option').val(),
                                backgroundColor: getBackgroundColor($('#create_state_option')
                                    .val()),
                                type: 'vehicle',
                            };

                            $.ajax({
                                url: '/vehicleCalendar',
                                type: 'POST',
                                data: formData,
                                success: function(response) {
                                    calendar.refetchEvents();
                                    $("#create_event_form")[0].reset();
                                    $('#create-modal').modal('toggle');
                                },
                                error: function(error) {
                                    if (error.responseJSON.errors) {
                                        $('#create_title_error').html(error.responseJSON
                                            .errors
                                            .title);
                                        $('#create_start_error').html(error.responseJSON
                                            .errors
                                            .start);

                                        $('#create_end_error').html(error.responseJSON
                                            .errors
                                            .end);

                                        $('#create_driver_error').html(error
                                            .responseJSON
                                            .errors
                                            .driver);

                                        $('#create_recipient_error').html(error
                                            .responseJSON
                                            .errors
                                            .recipient);

                                        console.log(error.responseJSON.errors);
                                    }
                                },
                            });
                        });

                    },
                });

                $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function(e) {
                    calendar.render();

                });
            });
        </script>
    @endpush
</div>


{{-- edit modal start --}}
<div class="modal fade" id="edit-modal" aria-labelledby="edit-modal-label" aria-hidden="true" tabindex="-1"
    wire:ignore
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="edit_modal_header">
                <h5 class="create-modal-title" id="edit-modal-label">Editar Evento</h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="edit_event_form">
                    <div class="form-group">
                        <label for="edit_title_input">Titulo</label>
                        <input class="form-control" id="edit_title_input" name="edit_title_input" type="text"
                            placeholder="Escriba el Titulo del Evento"
                        >
                        <span class="text-danger" id="edit_title_error"></span>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-6 pl-0 pr-1">
                                <div class="form-group">
                                    <label for="edit_start_input">Fecha Inicio</label>
                                    <input class="form-control" id="edit_start_input" name="edit_start_input"
                                        type="datetime-local"
                                    >
                                    <span class="text-danger" id="edit_start_error"></span>

                                </div>
                            </div>
                            <div class="col-6 pl-1 pr-0">
                                <div class="form-group">
                                    <label for="edit_end_input">Fecha Termino</label>
                                    <input class="form-control" id="edit_end_input" name="edit_end_input"
                                        type="datetime-local"
                                    >
                                    <span class="text-danger" id="edit_end_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-6 pl-0 pr-1">
                                <div class="form-group">
                                    <label for="edit_car_input">Patente Vehiculo</label>
                                    <input class="form-control" id="edit_car_input" name="edit_car_id"
                                        type="text" placeholder="Escriba la patente"
                                    >
                                </div>
                            </div>
                            <div class="col-6 pl-1 pr-0">
                                <div class="form-group">
                                    <label for="edit_passengers_input">Numero de Pasajeros</label>
                                    <input class="form-control" id="edit_passengers_input" name="passenger_number"
                                        type="number" placeholder="(Valor de 1 a 4)" min="1" max="4"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-6 pl-0 pr-1">
                                <div class="form-group">
                                    <label for="edit_location_input">Destino</label>
                                    <input class="form-control" id="edit_location_input" name="location"
                                        type="text" placeholder="Escriba el Destino"
                                    >
                                    @error('location')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 pl-1 pr-0">
                                <div class="form-group">
                                    <label for="edit_state_option">Estado</label>
                                    <select class="custom-select" id="edit_state_option" name='edit_state_option'>
                                        <option selected>Seleccione un estado</option>
                                        <option value="En Mantencion"style="background-color: #d50300; color: white">En
                                            Mantencion</option>
                                        <option value="Por Confirmar" style="background-color: #e67c73">Por
                                            Confirmar</option>
                                        <option value="En Espera" style="background-color: #f6bf25">En Espera
                                        </option>
                                        <option value="Agendado" style="background-color: #33b679">Agendado
                                        </option>
                                        <option value="Disponible" style="background-color: #039be5">Disponible
                                        </option>
                                        <option value="Suspendido"style="background-color: #626161; color: white">
                                            Suspendido</option>
                                    </select>
                                    @error('state')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="form-control btn btn-primary" id="edit_submit_btn" type="submit">Guardar</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
{{-- edit modal ending --}}
