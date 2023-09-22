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
        <div style="color:#CACACA">&#9632;</div>&nbsp;<p>Disponible</p>
        <div style="color:#EB9489">&#9632;</div>&nbsp;<p>Reservado</p>&nbsp;&nbsp;
        <div style="color:#85C1E9">&#9632;</div>&nbsp;<p>Bloqueado</p>
        <div style="color:#C4F7BF">&#9632;</div>&nbsp;<p>Mis reservas</p>
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
    <!-- <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"> -->
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

                    {{--<!-- <div class="row">
                        <fieldset class="form-group col-12 col-md-6">
                            <label for="for_users">Funcionario</label>
                            <div>
                                @livewire('search-select-user', ['selected_id' => 'patient_id', 
                                                                 'required' => 'required'])
                            </div>
                        </fieldset>

                        <fieldset class="form-group col-12 col-md-6">
                            <label for="for_contact_number">Teléfono de contacto</label>
                            <input class="form-control" type="text" id="" name="contact_number" placeholder="+569">
                        </fieldset>
                        
                    </div> -->--}}

                    @livewire('prof-agenda.employee-data')

                    <div class="row">
                        <fieldset class="form-group col-12 col-md-12">
                            <label for="for_observation">Motivo consulta</label>
                            <textarea class="form-control" name="observation" id="" cols="30" rows="5"></textarea>
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
                                <textarea class="form-control" name="deleted_bloqued_observation" id="" cols="30" rows="5"></textarea>
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
    <div class="modal fade" id="reservedHour" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modalTitle" id=""></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <form method="POST" class="form-horizontal" onsubmit="return confirm('¿Está seguro de eliminar la reserva?');" action="{{ route('prof_agenda.open_hour.delete_reservation') }}">
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
                        <fieldset class="form-group col-12 col-md-6">
                            <label for="for_users">Funcionario</label>
                            <div>
                                <input type="text" class="form-control" id="patient" disabled>
                            </div>
                        </fieldset>

                        <fieldset class="form-group col-12 col-md-6">
                            <label for="for_users">Telefono de contacto</label>
                            <div>
                                <input type="text" class="form-control" id="contact_number" disabled>
                            </div>
                        </fieldset>
                    </div>

                    <div class="row">
                        <fieldset class="form-group col-12 col-md-12">
                            <label for="for_observation">Motivo consulta</label>
                            <textarea class="form-control observation" name="observation" id="" cols="30" rows="5" disabled></textarea>
                        </fieldset>
                    </div>

                    <div class="row">
                        <fieldset class="form-group col-12 col-md-12">
                            <label for="for_deleted_bloqued_observation">Motivo eliminación</label>
                            <textarea class="form-control" name="deleted_bloqued_observation" id="" cols="30" rows="5"></textarea>
                        </fieldset>
                    </div>

                    <div class="row">
                        <fieldset class="form-group col-12 col-md-6">
                            <label for="for_profesion_id"><br></label>
                            <button type="submit" class="form-control btn btn-danger">Eliminar reserva</button>
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
                            <textarea class="form-control" id="deleted_bloqued_observation" cols="30" rows="5" disabled></textarea>
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
            document.addEventListener('livewire:load', function() {
            // document.addEventListener('DOMContentLoaded', function() {
                var Calendar = FullCalendar.Calendar;
                var calendarEl = document.getElementById('calendar');
                // var data =   @this.events;
                var calendar = new Calendar(calendarEl, {

                    editable: true,
                    selectable: true,
                    
                    eventClick: function(info) {
                        console.info(info.event.extendedProps);
                        $('.modalTitle').html(info.event.title);
                        $('#patient').val(info.event.title);
                        $('#contact_number').val(info.event.extendedProps.contact_number);
                        $('.openHours_id').val(info.event.id);
                        $('.finicio').val(info.event.start.toLocaleString());
                        $('.ftermino').val(info.event.end.toLocaleString());
                        $('.observation').val(info.event.extendedProps.observation);

                        // se verifica si es un bloque vacio o ya reservado
                        if(info.event.extendedProps.status=="Disponible"){
                            $('#newHour').modal();
                        }else if(info.event.extendedProps.status=="Reservado"){
                            $('#reservedHour').modal();
                        }
                        else if(info.event.extendedProps.status=="Bloqueado"){
                            $('#deleted_bloqued_observation').val(info.event.extendedProps.deleted_bloqued_observation);
                            $('#unblockHour').modal();   
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
                    events: JSON.parse(@this.events),

                });
                
                // console.log(@this.events),
                calendar.render();

                @this.on('refreshCalendar', () => {
                    // console.log(@this.events),
                    calendar.refetchEvents()
                    // calendar.render()
                });

                // Livewire.on('refreshCalendar', () => {
                //     calendar.refetchEvents(),
                //     calendar.render(),
                //     alert("")
                // });
                
            });

            // $(document).ready(function () {
            //     window.livewire.emit('show');
            // });

            // window.livewire.on('show', () => {
            //     $('#calendarModal').modal('show');
            // });

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