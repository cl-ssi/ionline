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

    <div>
        <div id='calendar-container'>
            <div id='calendar'></div>
        </div>as
    </div>

    <!-- {{$proposal->details->count()}} -->
    <!-- {{$events}} -->

    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.js'></script>
        <script>
            document.addEventListener('livewire:load', function() {
            // document.addEventListener('DOMContentLoaded', function() {
                var Calendar = FullCalendar.Calendar;
                var calendarEl = document.getElementById('calendar');
                // var data =   @this.events;
                var calendar = new Calendar(calendarEl, {

                    editable: false,
                    headerToolbar : {
                        start: '', // will normally be on the left. if RTL, will be on the right
                        center: '',
                        end: '' // will normally be on the right. if RTL, will be on the left
                    },
                    
                    dayHeaderFormat : { weekday: 'short' }, 

                    initialView: 'timeGridWeek',
                    allDaySlot: false,
                    firstDay: 1,
                    slotMinTime: "08:00:00",
                    locale: 'es',
                    displayEventTime: false,
                    events: JSON.parse(@this.events),

                });
                
                console.log(@this.events),
                calendar.render();

                @this.on('refreshCalendar', () => {
                    console.log(@this.events),
                    calendar.refetchEvents()
                    // calendar.render()
                });

                // Livewire.on('refreshCalendar', () => {
                //     calendar.refetchEvents(),
                //     calendar.render(),
                //     alert("")
                // });
                
            });

        </script>
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.css' rel='stylesheet' />
    @endpush
</div>
