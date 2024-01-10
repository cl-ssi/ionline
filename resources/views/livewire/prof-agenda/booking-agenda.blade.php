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
        <div style="color:#85C1E9">&#9632;</div>&nbsp;<p>No disponible</p>&nbsp;&nbsp; <!--plomo-->
        <div style="color:#E7EB89">&#9632;</div>&nbsp;<p>Reservado</p>&nbsp;&nbsp; <!--amarillo-->
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

                    <input type="hidden" value="{{auth()->user()->id}}" name="user_id">

                    <div class="row">
                        <fieldset class="form-group col-12 col-md-12">
                            <label for="for_observation">Motivo consulta</label>
                            <textarea class="form-control" name="observation" id="" cols="30" rows="3"></textarea>
                        </fieldset>
                    </div>

                    <button type="submit" class="form-control btn btn-primary">Guardar</button>

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
                        <fieldset class="form-group col-12 col-md-4">
                            <label for="for_rut">Rut</label>
                            <div>
                                <input type="text" class="form-control rut" id="" disabled>
                            </div>
                        </fieldset>

                        <fieldset class="form-group col-12 col-md-4">
                            <label for="for_patient">Funcionario</label>
                            <div>
                                <input type="text" class="form-control patient" id="" disabled>
                            </div>
                        </fieldset>

                        <fieldset class="form-group col-12 col-md-4">
                            <label for="for_contact_number">Telefono de contacto</label>
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

                    <!--<hr>

                    <div class="row">
                        <fieldset class="form-group col-12 col-md-9">
                            <label for="for_deleted_bloqued_observation">Motivo eliminación</label>
                            <input type="text" class="form-control" name="deleted_bloqued_observation">
                        </fieldset>

                        <fieldset class="form-group col-12 col-md-3">
                            <label for="for_profesion_id"><br></label>
                            <button type="submit" class="form-control btn btn-warning">Eliminar reserva</button>
                        </fieldset>
                    </div> -->

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

                    // editable: true,
                    selectable: true,
                    slotDuration: '00:20',
                    
                    eventClick: function(info) {
                        console.info(info.event.extendedProps);
                        $('.modalTitle').html(info.event.title);
                        $('.patient').val(info.event.title);
                        $('.contact_number').val(info.event.extendedProps.contact_number);
                        $('.openHours_id').val(info.event.id);
                        $('.finicio').val(info.event.start.toLocaleString());
                        $('.ftermino').val(info.event.end.toLocaleString());
                        $('.observation').val(info.event.extendedProps.observation);

                        // se verifica si es un bloque vacio o ya reservado
                        if(info.event.extendedProps.status=="Disponible"){
                            $('#newHour').modal();
                        }else if(info.event.extendedProps.status=="Reservado"){
                            $('.rut').val(info.event.extendedProps.rut);
                            $('#reservedHour').modal();
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