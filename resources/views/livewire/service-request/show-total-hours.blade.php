@if(!$errorMsg)
    <span class="text-muted small">(valores de prueba)</span>
    <table class="table table-sm">
        <thead>
        <tr>
            <th>Horas Diurno</th>
            @if($serviceRequest->working_day_type === 'DIURNO PASADO A TURNO') <th>Horas a devolver</th> @endif
            <th>Horas Nocturno</th>
            <th>Horas Total</th>
            <th>Monto</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$totalHoursDay}}</td>
            @if($serviceRequest->working_day_type === 'DIURNO PASADO A TURNO')<td>{{$refundHours}}</td> @endif
            <td>{{$totalHoursNight}}</td>
            <td>{{$totalHours}}</td>
            <td>{{ '$'.number_format($totalAmount, 0, ',', '.') }} <span class="text-muted small">(valor de prueba)</span> </td>
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





