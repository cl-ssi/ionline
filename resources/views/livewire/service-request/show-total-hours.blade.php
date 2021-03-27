@if(!$errorMsg)
    @if(!count($hoursDetailArray) == 0)
        <table class="table table-sm">
            <thead>
            <tr>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Hrs. Diurnas</th>
                <th>Hrs. Nocturnas</th>
                <th>Observación</th>
            </tr>
            </thead>
            <body>
            @foreach($hoursDetailArray as $hourDetailArray)
                <tr>
                    <td @if($serviceRequest->working_day_type === 'DIURNO PASADO A TURNO') @if($hourDetailArray['is_start_date_holiday']) style="color:#dc3545" @endif @endif >{{$hourDetailArray['start_date']}}</td>
                    <td @if($serviceRequest->working_day_type === 'DIURNO PASADO A TURNO') @if($hourDetailArray['is_end_date_holiday']) style="color:#dc3545" @endif @endif>{{$hourDetailArray['end_date']}}</td>
                    <td>{{$hourDetailArray['hours_day']}}</td>
                    <td>{{$hourDetailArray['hours_night']}}</td>
                    <td>{{$hourDetailArray['observation']}}</td>
                </tr>
            @endforeach
            </body>
        </table>
    @endif

    <table class="table table-sm">
        <thead>
        <tr>
            <th>Horas Diurno</th>
            @if($serviceRequest->working_day_type === 'DIURNO PASADO A TURNO')
                <th>Horas a devolver</th> @endif
            <th>Horas Nocturno</th>
            <th>Horas Total</th>
            <th>Monto</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$totalHoursDay}}</td>
            @if($serviceRequest->working_day_type === 'DIURNO PASADO A TURNO')
                <td>{{$refundHours}}</td> @endif
            <td>{{$totalHoursNight}}</td>
            <td>{{$totalHours}}</td>
            <td>{{ '$'.number_format($totalAmount, 0, ',', '.') }} <span
                    class="text-muted small">(valor de prueba)</span></td>
        </tr>
        </tbody>
    </table>

@else
    <div>
        <div class="alert alert-warning" role="alert">
            {{$errorMsg}}
        </div>
    </div>
@endif





