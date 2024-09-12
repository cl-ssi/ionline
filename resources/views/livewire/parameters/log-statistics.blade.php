<div>
    @section('custom_js_head')
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Fecha');
        data.addColumn('number', 'Errores');
        data.addRows([{!! $logsChart !!}]);

        // Set chart options
        var options = {'title':'Errores diaros',
                       'width':1200,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    @endsection

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Módulo</th>
                <th>Errores</th>
            </tr>
        </thead>
        <tbody>
            @foreach($group['labels'] as $index => $module)
            <tr>
                <td>
                    @if($module !== 'Sin módulo')
                        <a href="{{ route('parameters.logs.index', ['module' => $module]) }}">
                            {{ $module }}
                        </a>
                    @else
                        <a href="{{ route('parameters.logs.index', ['module' => 'unknown']) }}">
                            [ Módulo desconocido ]
                        </a>
                    @endif
                </td>
                <td>{{ $group['datasets'][0]['data'][$index] }}</td>
            </tr>
            @endforeach
            <tr>
                <td>
                    <a href="{{ route('parameters.logs.index') }}">
                        Todos
                    </a>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>
    

 <!--Div that will hold the pie chart-->
 <div id="chart_div"></div>
</div>
