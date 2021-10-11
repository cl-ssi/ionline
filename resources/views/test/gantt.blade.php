<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8' />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.9.0/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.9.0/main.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
  schedulerLicenseKey: '0404885988-fcs-1582214203',
    timeZone: 'UTC',
    initialView: 'resourceTimelineMonth',
    slotDuration: '24:00:00',
    aspectRatio: 1.5,
    headerToolbar: {
      left: 'prev,next',
      center: 'title',
      right: 'resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth'
    },
    editable: true,
    resourceAreaHeaderContent: 'Rooms',
    resources: 'https://fullcalendar.io/demo-resources.json?with-nesting&with-colors',
    events: 'https://fullcalendar.io/demo-events.json?single-day&for-resource-timeline'
  });

  calendar.render();
});

    </script>
  </head>
  <body>
    <div id='calendar'></div>
  </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.9.0/locales-all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.9.0/main.min.js"></script>
