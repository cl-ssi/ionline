<span>
@if(!$errorMsg)
    @if($forResolution)
        @if(!$fulfillment->serviceRequest->working_day_type == "HORA EXTRA")
            {{floor($totalHoursDay)}} Horas diurnas y {{floor($totalHoursNight)}} horas nocturnas en turno extras en el mes de {{$fulfillment->serviceRequest->start_date->monthName}},
            cuya suma alzada total es de ${{number_format($fulfillment->total_to_pay)}}.- ({{$fulfillment->total_to_pay_description}}) impuesto incluido, en conformidad a lo dispuesto en el inciso segundo del Art.
            2º del Decreto Nº 98 de 1991 del Ministerio de Hacienda y se cancelará en una cuota de ${{number_format($fulfillment->total_to_pay)}} el mes de {{$fulfillment->serviceRequest->start_date->monthName}}
        @else
        
            {{floor($totalHoursDayString)}} Horas diurnas y {{floor($totalHoursNightString)}} horas nocturnas
        @endif
    @else
    @if(!$forCertificate)
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
                        <td @if($fulfillment->serviceRequest->working_day_type === 'DIURNO PASADO A TURNO') @if($hourDetailArray['is_start_date_holiday']) style="color:#dc3545" @endif @endif >{{$hourDetailArray['start_date']}}</td>
                        <td @if($fulfillment->serviceRequest->working_day_type === 'DIURNO PASADO A TURNO') @if($hourDetailArray['is_end_date_holiday']) style="color:#dc3545" @endif @endif>{{$hourDetailArray['end_date']}}</td>
                        <td>{{$hourDetailArray['hours_day']}}</td>
                        <td>{{$hourDetailArray['hours_night']}}</td>
                        <td>{{$hourDetailArray['observation']}}</td>
                    </tr>
                @endforeach
                </body>
            </table>
        @endif
    @endif

    @if(!$forCertificate)
        <table class="table table-sm">
            <thead>
            <tr>
                <th>Horas Diurno</th>
                @if($fulfillment->serviceRequest->working_day_type === 'DIURNO PASADO A TURNO')
                    <th>Horas a devolver</th> @endif
                <th>Horas Nocturno</th>
                <th>Horas Total</th>
                <th>Horas a pagar</th>
                <th>Monto</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$totalHoursDay}}</td>
                @if($fulfillment->serviceRequest->working_day_type === 'DIURNO PASADO A TURNO')
                    <td>{{$refundHours}}</td> @endif
                <td>{{$totalHoursNight}}</td>
                <td>{{$totalHours}}</td>
                <td>{{$totalHoursContab}}</td>
                <td>{{ '$'.number_format($totalAmount, 0, ',', '.') }} <span
                        class="text-muted small">(Se debe comprobar)</span></td>
            </tr>
            </tbody>
        </table>
    @endif

    @if($forCertificate)
        <table class="siete">
            <thead>
            <tr>
                <th>Horas Diurno</th>
                @if($fulfillment->serviceRequest->working_day_type === 'DIURNO PASADO A TURNO')
                    <th>Horas a devolver</th> @endif
                <th>Horas Nocturno</th>
                <th>Horas Total</th>
                @if(!$forCertificate) <th>Monto</th> @endif
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$totalHoursDay}}</td>
                @if($fulfillment->serviceRequest->working_day_type === 'DIURNO PASADO A TURNO')
                    <td>{{$refundHours}}</td> @endif
                <td>{{$totalHoursNight}}</td>

                <td>{{$totalHours}}</td>
                @if(!$forCertificate) <td>{{ '$'.number_format($totalAmount, 0, ',', '.') }} <span
                        class="text-muted small">(Se debe comprobar)</span></td> @endif
            </tr>
            </tbody>
        </table>
    @endif
  @endif
@else
    <div>
        <div class="alert alert-warning" role="alert">
            {{$errorMsg}}
        </div>
    </div>
@endif
</span>
