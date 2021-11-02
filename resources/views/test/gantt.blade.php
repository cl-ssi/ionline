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
			schedulerLicenseKey: '',
			timeZone: 'UTC',
			initialView: 'resourceTimelineMonth',
			//slotDuration: '24:00:00',
			aspectRatio: 1.5,
			headerToolbar: {
				left: 'prev,next',
				center: 'title',
				//right: 'resourceTimelineMonth'
			},
			editable: true,
			resourceAreaHeaderContent: 'Dias',
			//resources: 'https://fullcalendar.io/demo-resources.json?with-nesting&with-colors',
			// resources: [
			// 	{"id":"a","title":"Auditorium A"},
			// 	{"id":"b","title":"Auditorium B"},
			// 	{"id":"c","title":"Auditorium C"},
			// 	{"id":"d","title":"Auditorium D","children":[{"id":"d1","title":"Room D1"},{"id":"d2","title":"Room D2"}]},
			// 	{"id":"e","title":"Auditorium E"},
			// 	{"id":"f","title":"Auditorium F"},
			// 	{"id":"g","title":"Auditorium G"},
			// 	{"id":"h","title":"Auditorium H"},
			// ],
			resources: {!! $resources !!},
			//events: 'https://fullcalendar.io/demo-events.json?single-day&for-resource-timeline',
			events: {!! $events !!}
			// events: [
			// {
			// 	"resourceId":"a",
			// 	"title":"event 4",
			// 	"start":"2021-10-13",
			// 	"end":"2021-10-15","color":"red"
			// },
			// {
			// 	"resourceId":"b",
			// 	"title":"event 5",
			// 	"start":"2021-10-11",
			// 	"end":"2021-10-12","color":"green"
			// },
			// {
			// 	"resourceId":"c",
			// 	"title":"event 3",
			// 	"start":"2021-10-12",
			// 	"end":"2021-10-14","color":"orange"
			// },
			// {
			// 	"resourceId":"d",
			// 	"title":"event 1",
			// 	"start":"2021-10-10",
			// 	"end":"2021-10-12"
			// },
			// {
			// 	"resourceId":"d1",
			// 	"title":"event 2",
			// 	"start":"2021-10-11",
			// 	"end":"2021-10-11"
			// }
			// ]
		});

		calendar.render();
	});

    </script>
	</head>
  	<body>
    <div id='calendar'></div>
	<script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.9.0/locales-all.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.9.0/main.min.js"></script>
  	</body>
</html>
