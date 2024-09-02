<div>
    <style>
        #calendar-container{
            /* width: 100%; */
        }
        #calendar{
            /* padding: 10px; */
            /* margin: 10px; */
            /* width: 1340px; */
            /* height: 610px; */
            /* border:2px solid black; */
        }
    </style>

    <div class="form-row mb-4 justify-content-end">
        <div style="color:#CACACA">&#9632;</div>&nbsp;<p>Disponible</p>&nbsp;&nbsp; <!--plomo-->
        <div style="color:#E7EB89">&#9632;</div>&nbsp;<p>Reservado</p>&nbsp;&nbsp; <!--amarillo-->
        <div style="color:#C4F7BF">&#9632;</div>&nbsp;<p>Asistió</p>&nbsp;&nbsp; <!--verde-->
        <div style="color:#EB9489">&#9632;</div>&nbsp;<p>No asistió</p>&nbsp;&nbsp; <!--rojo-->
        <div style="color:#85C1E9">&#9632;</div>&nbsp;<p>Bloqueado</p>&nbsp;&nbsp; <!--celeste-->
        <div style="color:#444444">&#9632;</div>&nbsp;<p>Feriado</p> <!--negro-->
    </div>

    <div>
        <div id='calendar-container' wire:ignore>
            <div id='calendar'></div>
        </div>
    </div>

    <!-- modal para registrar una nueva reserva -->
    <div class="modal fade bd-example-modal-lg" id="newHour" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modalTitle" id="">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <form method="POST" class="form-horizontal" action="{{ route('prof_agenda.open_hour.store') }}">
                @csrf
                @method('POST')

                    <div class="row">
                        <input class="openHours_id" type="hidden" id="" name="openHours_id">
                        <fieldset class="form-group col-12 col-md-6">
                            <label for="for_users">F.Inicio</label>
                            <input class="form-control finicio" type="datetime" id="" disabled>
                        </fieldset>

                        <fieldset class="form-group col-12 col-md-6">
                            <label for="for_profesion_id">F.Término</label>
                            <input class="form-control ftermino" type="datetime" id="" disabled>
                        </fieldset>
                    </div>

                    <div class="row">
                        <fieldset class="form-group col-12 col-md-10">
                            <label for="for_users">Buscar funcionario</label>
                            <div>
                                @livewire('search-select-user', ['selected_id' => 'patient_id', 
                                                                 'emit_name' => 'loadUserData'])
                            </div>
                        </fieldset>
                    </div>     

                    @livewire('prof-agenda.employee-data')

                    <div class="row">
                        <fieldset class="form-group col-12 col-md-12">
                            <label for="for_observation">Motivo consulta</label>
                            <textarea class="form-control" name="observation" id="" cols="30" rows="3"></textarea>
                        </fieldset>
                    </div>

                    <button type="submit" class="form-control btn btn-primary">Guardar</button>

                </form>

                <hr>

                <form method="POST" class="form-horizontal" onsubmit="return confirm('¿Está seguro de bloquear el bloque de horario?');" action="{{ route('prof_agenda.open_hour.block') }}">
                @csrf
                @method('POST')
                    <div class="row">
                            <input class="openHours_id" type="hidden" id="" name="openHours_id">
                            <fieldset class="form-group col-12 col-md-12">
                                <label for="for_deleted_bloqued_observation">Motivo del bloqueo de bloque horario</label>
                                <textarea class="form-control" name="deleted_bloqued_observation" id="" cols="30" rows="3"></textarea>
                            </fieldset>
                    </div>

                    <button type="submit" class="form-control btn btn-warning">Bloquear</button>

                </form>
                
                <hr>

                <form method="POST" class="form-horizontal" onsubmit="return confirm('¿Está seguro de eliminar el bloque de horario?');" action="{{ route('prof_agenda.open_hour.destroy') }}">
                @csrf
                @method('POST')
                    <input class="openHours_id" type="hidden" id="" name="openHours_id">
                    <button type="submit" class="form-control btn btn-danger">Eliminar</button>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>

    <!-- modal para eliminar una reserva -->
    <div class="modal fade bd-example-modal-lg" id="reservedHour" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <a id="miEnlace" href="#">
                    <h5 class="modal-title modalTitle" id="">Modal title</h5>
                </a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-horizontal" onsubmit="return confirm('¿Está seguro de eliminar la reserva?');" action="{{ route('prof_agenda.open_hour.delete_reservation') }}">
                @csrf
                @method('POST')

                    <div class="row">
                        <!-- wire:model.live="openHours_id" -->
                        <input class="openHours_id" type="hidden" id="" name="openHours_id">
                        <fieldset class="form-group col-12 col-md-5">
                            <label for="for_users">F.Inicio</label>
                            <input class="form-control finicio" type="datetime" id="" disabled>
                        </fieldset>

                        <fieldset class="form-group col-12 col-md-5">
                            <label for="for_profesion_id">F.Término</label>
                            <input class="form-control ftermino" type="datetime" id="" disabled>
                        </fieldset>
                    </div>

                    <div class="row">
                        <fieldset class="form-group col-12 col-md-3">
                            <label for="for_rut">Rut</label>
                            <div>
                                <input type="text" class="form-control rut" id="" disabled>
                            </div>
                        </fieldset>

                        <fieldset class="form-group col-12 col-md-3">
                            <label for="for_patient">Funcionario</label>
                            <div>
                                <input type="text" class="form-control patient" id="" disabled>
                            </div>
                        </fieldset>

                        <fieldset class="form-group col-12 col-md-3">
                            <label for="for_patient">Sexo</label>
                            <div>
                                <input type="text" class="form-control gender" id="" disabled>
                            </div>
                        </fieldset>

                        <fieldset class="form-group col-12 col-md-3">
                            <label for="for_contact_number">Teléfono</label>
                            <div>
                                <input type="text" class="form-control contact_number" disabled>
                            </div>
                        </fieldset>
                    </div>

                    <div class="row">
                        <fieldset class="form-group col-12 col-md-12">
                            <label for="for_observation">Motivo consulta</label>
                            <textarea class="form-control observation" name="observation" id="" cols="30" rows="3" disabled></textarea>
                        </fieldset>
                    </div>

                    <hr>

                    <div class="row">
                        <fieldset class="form-group col-12 col-md-9">
                            <label for="for_deleted_bloqued_observation">Motivo eliminación</label>
                            <!-- <textarea class="form-control" name="deleted_bloqued_observation" id="" cols="30" rows="5"></textarea> -->
                            <input type="text" class="form-control" name="deleted_bloqued_observation">
                        </fieldset>

                        <fieldset class="form-group col-12 col-md-3">
                            <label for="for_profesion_id"><br></label>
                            <button type="submit" class="form-control btn btn-warning">Eliminar reserva</button>
                        </fieldset>
                    </div>
                </form>

                <hr>

                <h6>¿Paciente asistió a la cita?</h6>

                <div class="row">

                        <fieldset class="form-group col-12 col-md-6">
                            <label for="for_profesion_id"><br></label>
                            <form method="POST" class="form-horizontal" onsubmit="return confirm('¿Está seguro de confirmar la asistencia?');" action="{{ route('prof_agenda.open_hour.assistance_confirmation') }}">
                            @csrf
                            @method('POST')
                                <input class="openHours_id" type="hidden" id="" name="openHours_id">
                                <button type="submit" class="form-control btn btn-success">Asistió</button>
                            </form>
                        </fieldset>

                    <fieldset class="form-group col-12 col-md-6">
                        <label for="for_profesion_id"><br></label>
                        <button type="submit" class="form-control btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#put_absence_reason">No asistió</button>
                    </fieldset>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>

    <!-- modal para mostrar info de reserva con asistencia -->
    <div class="modal fade bd-example-modal-lg" id="confirmedHour" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <a id="miEnlace3" href="#">
                    <h5 class="modal-title modalTitle" id="">Modal title</h5>
                </a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <input class="openHours_id" type="hidden" id="" name="openHours_id">
                    <fieldset class="form-group col-12 col-md-6">
                        <label for="for_users">F.Inicio</label>
                        <input class="form-control finicio" type="datetime" id="" disabled>
                    </fieldset>

                    <fieldset class="form-group col-12 col-md-6">
                        <label for="for_profesion_id">F.Término</label>
                        <input class="form-control ftermino" type="datetime" id="" disabled>
                    </fieldset>
                </div>

                <div class="row">
                    <fieldset class="form-group col-12 col-md-3">
                        <label for="for_rut">Rut</label>
                        <div>
                            <input type="text" class="form-control rut" id="" disabled>
                        </div>
                    </fieldset>

                    <fieldset class="form-group col-12 col-md-3">
                        <label for="for_patient">Funcionario</label>
                        <div>
                            <input type="text" class="form-control patient" id="" disabled>
                        </div>
                    </fieldset>

                    <fieldset class="form-group col-12 col-md-3">
                            <label for="for_patient">Sexo</label>
                            <div>
                                <input type="text" class="form-control gender" id="" disabled>
                            </div>
                        </fieldset>

                    <fieldset class="form-group col-12 col-md-3">
                        <label for="for_contact_number">Teléfono</label>
                        <div>
                            <input type="text" class="form-control contact_number" disabled>
                        </div>
                    </fieldset>
                </div>

                <div class="row">
                    <fieldset class="form-group col-12 col-md-12">
                        <label for="for_observation">Motivo consulta</label>
                        <textarea class="form-control observation" name="observation" id="" cols="30" rows="3" disabled></textarea>
                    </fieldset>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>

    <!-- modal put absence_reason -->
    <div class="modal fade" id="put_absence_reason" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modalTitle" id=""></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-horizontal" onsubmit="return confirm('¿Está seguro de confirmar la inasistencia?');" action="{{ route('prof_agenda.open_hour.absence_confirmation') }}">
                @csrf
                @method('POST')
                
                <div class="row">
                    <input class="openHours_id" type="hidden" id="" name="openHours_id">
                    <fieldset class="form-group col-12 col-md-6">
                        <label for="for_users">Motivo</label>
                        <select class="form-control" name="absence_reason" required>
                            <option value=""></option>
                            <option value="Sin justificación">Sin justificación</option>
                            <option value="Suspende">Suspende</option>
                            <option value="Se retira">Se retira</option>
                            <option value="Reagenda">Reagenda</option>
                            <option value="Profesional ausente">Profesional ausente</option>
                            <option value="Error asistencia">Error asistencia</option>
                            <option value="Fallo agenda">Fallo agenda</option>
                        </select>
                    </fieldset>

                    <fieldset class="form-group col-12 col-md-6">
                        <label for="for_profesion_id"><br></label>
                        <input class="openHours_id" type="hidden" id="" name="openHours_id">
                        <button type="submit" class="form-control btn btn-danger">No asistió</button>
                    </fieldset>
                </div>

                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>

    <!-- inasistencia -->
    <div class="modal fade" id="show_absence_reason" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <a id="miEnlace2" href="#">
                    <h5 class="modal-title modalTitle" id="">Modal title</h5>
                </a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <fieldset class="form-group col-3">
                        <label for="for_rut">Rut</label>
                        <div>
                            <input type="text" class="form-control rut" id="" disabled>
                        </div>
                    </fieldset>

                    <fieldset class="form-group col-3">
                        <label for="for_patient">Funcionario</label>
                        <div>
                            <input type="text" class="form-control patient" id="" disabled>
                        </div>
                    </fieldset>

                    <fieldset class="form-group col-12 col-md-3">
                        <label for="for_patient">Sexo</label>
                        <div>
                            <input type="text" class="form-control gender" id="" disabled>
                        </div>
                    </fieldset>

                    <fieldset class="form-group col-3">
                        <label for="for_contact_number">Teléfono</label>
                        <div>
                            <input type="text" class="form-control contact_number" disabled>
                        </div>
                    </fieldset>
                </div>
                
                <div class="row">
                    <fieldset class="form-group col-12 col-md">
                        <label for="for_profesion_id"><br>Motivo inasistencia</label>
                        <input class="form-control" type="text" id="absence_reason" disabled>
                    </fieldset>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>

    <!-- modal para desbloquear un bloque de horario -->
    <div class="modal fade" id="unblockHour" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modalTitle" id=""></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <form method="POST" class="form-horizontal" onsubmit="return confirm('¿Está seguro de desbloquear?');" action="{{ route('prof_agenda.open_hour.unblock') }}">
                @csrf
                @method('POST')

                    <div class="row">
                        <input class="openHours_id" type="hidden" id="" name="openHours_id">
                        <fieldset class="form-group col-12 col-md-6">
                            <label for="for_users">F.Inicio</label>
                            <input class="form-control finicio" type="datetime" id="" disabled>
                        </fieldset>

                        <fieldset class="form-group col-12 col-md-6">
                            <label for="for_profesion_id">F.Término</label>
                            <input class="form-control ftermino" type="datetime" id="" disabled>
                        </fieldset>
                    </div>

                    <div class="row">
                        <input class="openHours_id" type="hidden" id="" name="openHours_id">
                        <fieldset class="form-group col-12 col-md-12">
                            <label for="for_users">Motivo</label>
                            <textarea class="form-control" id="deleted_bloqued_observation" cols="30" rows="3" disabled></textarea>
                        </fieldset>
                    </div>

                    

                    <div class="row">
                        <!-- <input class="openHours_id" type="hidden" id="" name="openHours_id"> -->
                        <fieldset class="form-group col-12 col-md-6">
                            <label for="for_profesion_id"><br></label>
                            <button type="submit" class="form-control btn btn-warning">Desbloquear</button>
                        </fieldset>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
            
        </div>
    </div>

    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.js'></script>
        <script>
            

            document.addEventListener('livewire:init', function() {
                
                var Calendar = FullCalendar.Calendar;
                var calendarEl = document.getElementById('calendar');
                var events = JSON.parse(@json($events)); // Convierte la propiedad Livewire en JSON
                
                var calendar = new Calendar(calendarEl, {

                    editable: true,
                    selectable: true,
                    slotDuration: '00:20',
                    
                    eventClick: function(info) {
                        // console.info(info.event.extendedProps);
                        $('.modalTitle').html(info.event.id + " - " + info.event.title);
                        $('.patient').val(info.event.extendedProps.patient_name);
                        $('.contact_number').val(info.event.extendedProps.contact_number);
                        $('.gender').val(info.event.extendedProps.gender);
                        $('.openHours_id').val(info.event.id);
                        $('.finicio').val(info.event.start.toLocaleString());
                        $('.ftermino').val(info.event.end.toLocaleString());
                        $('.observation').val(info.event.extendedProps.observation);

                        // se verifica si es un bloque vacio o ya reservado
                        if(info.event.extendedProps.status=="Disponible"){
                            $('#newHour').modal();
                        }else if(info.event.extendedProps.status=="Reservado"){
                            // asigna ruta href
                            var eventId = info.event.id;
                            var enlace = document.getElementById("miEnlace");
                            var route = "{{ route('prof_agenda.reports.clinicalreportusu', ':eventId') }}";
                            route = route.replace(':eventId', eventId);
                            enlace.href = route;

                            $('.rut').val(info.event.extendedProps.rut);
                            $('#reservedHour').modal();
                        }
                        else if(info.event.extendedProps.status=="Asistió"){
                            // asigna ruta href
                            var eventId = info.event.id;
                            var enlace = document.getElementById("miEnlace3");
                            var route = "{{ route('prof_agenda.reports.clinicalreportusu', ':eventId') }}";
                            route = route.replace(':eventId', eventId);
                            enlace.href = route;

                            $('.rut').val(info.event.extendedProps.rut);
                            $('#confirmedHour').modal();
                        }
                        else if(info.event.extendedProps.status=="Bloqueado"){
                            $('#deleted_bloqued_observation').val(info.event.extendedProps.deleted_bloqued_observation);
                            $('#unblockHour').modal();   
                        }

                        else if(info.event.extendedProps.status=="No asistió"){
                            // asigna ruta href
                            var eventId = info.event.id;
                            var enlace = document.getElementById("miEnlace2");
                            var route = "{{ route('prof_agenda.reports.clinicalreportusu', ':eventId') }}";
                            route = route.replace(':eventId', eventId);
                            enlace.href = route;

                            $('.rut').val(info.event.extendedProps.rut);
                            $('#absence_reason').val(info.event.extendedProps.absence_reason);
                            $('#show_absence_reason').modal();   
                        }
                        // change the border color just for fun
                        // info.el.style.borderColor = 'red';
                    },

                    eventDrop: function(info) {
                        // alert(info.event.title + " was dropped on " + info.event.start.toISOString());
                        var date = new Date(info.event.start.toISOString());

                        if (!confirm("¿Está seguro de realizar este cambio?")) {
                            info.revert();
                        }else{
                            let url = "{{ route('prof_agenda.open_hour.change_hour', [':id', ':start_date']) }}";
                            url = url.replace(':id', info.event.id);
                            url = url.replace(':start_date', formatDate(date));
                            document.location.href=url;
                        }
                    },

                    initialView: 'timeGridWeek',
                    allDaySlot: false,
                    firstDay: 1,
                    slotMinTime: "08:00:00",
                    locale: 'es',
                    displayEventTime: false,
                    events: events,

                });
                
                calendar.render();
                
            });

            function padTo2Digits(num) {
            return num.toString().padStart(2, '0');
            }

            function formatDate(date) {
            return (
                [
                date.getFullYear(),
                padTo2Digits(date.getMonth() + 1),
                padTo2Digits(date.getDate()),
                ].join('-') +
                ' ' +
                [
                padTo2Digits(date.getHours()),
                padTo2Digits(date.getMinutes()),
                padTo2Digits(date.getSeconds()),
                ].join(':')
            );
            }

        </script>

        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.css' rel='stylesheet' />
    @endpush
</div>