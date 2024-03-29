<html>
  <head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <!-- <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['Element', 'Density', { role: 'style' }],
        ['Copper', 8.94, '#b87333', ],
        ['Silver', 10.49, 'silver'],
        ['Gold', 19.30, 'gold'],
        ['Platinum', 21.45, 'color: #e5e4e2' ]
      ]);

      var options = {
        title: "Density of Precious Metals, in g/cm^3",
        bar: {groupWidth: '95%'},
        legend: 'none',
      };

      var chart_div = document.getElementById('chart_div');
      var chart = new google.visualization.ColumnChart(chart_div);

      // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
        console.log(chart_div.innerHTML);
      });

      chart.draw(data, options);

  }
  </script> -->

  <script type="text/javascript">
        
        google.charts.load('current', {packages:["orgchart"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Name');
            data.addColumn('string', 'Manager');
            data.addColumn('string', 'ToolTip');

            // For each orgchart box, provide the name, manager, and tooltip to show.
            data.addRows({!! $tree !!});

            // Create the chart.
            var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
            // Draw the chart, setting the allowHtml option to true for the tooltips.
            //chart.draw(data, {'allowHtml':true});

            /*
            google.visualization.events.addListener(chart, 'ready', function () {
                var imgUri = chart.getImageURI();
                alert(imgUri);
                // do something with the image URI, like:
                document.getElementById('chartImg').src = imgUri;
            });
            */

            var chart_div = document.getElementById('chart_div');
            var chart = new google.visualization.ColumnChart(chart_div);

            // Wait for the chart to finish drawing before calling the getImageURI() method.
            google.visualization.events.addListener(chart, 'ready', function () {
              chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
              console.log(chart_div.innerHTML);
            });

            chart.draw(data, options);
        }
    </script>
  </head>
  <body>
    <div id="chart_div"></div>
  </body>
</html>
