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
        </div>
    </div>

    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.js'></script>
        <script>
            document.addEventListener('livewire:init', function() {
            // document.addEventListener('DOMContentLoaded', function() {
                var Calendar = FullCalendar.Calendar;
                var calendarEl = document.getElementById('calendar');
                var events = JSON.parse(@json($events));

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
                    events: events,
                    slotDuration: '00:20',

                });
                
                calendar.render();
                
            });

        </script>
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.css' rel='stylesheet' />
    @endpush
</div>
