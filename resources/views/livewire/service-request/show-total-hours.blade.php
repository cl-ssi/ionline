<span>
@if(!$errorMsg)
    @if($forResolution)
        @if(!$fulfillment->serviceRequest->working_day_type == "HORA EXTRA")
            {{ $this->formatHours($totalHoursDay) }} Horas diurnas y {{ $this->formatHours($totalHoursNight) }} horas nocturnas en turno extras en el mes de {{$fulfillment->serviceRequest->start_date->monthName}},
            cuya suma alzada total es de ${{number_format($fulfillment->total_to_pay)}}.- ({{$fulfillment->total_to_pay_description}}) impuesto incluido, en conformidad a lo dispuesto en el inciso segundo del Art.
            2º del Decreto Nº 98 de 1991 del Ministerio de Hacienda y se cancelará en una cuota de ${{number_format($fulfillment->total_to_pay)}} el mes de {{$fulfillment->serviceRequest->start_date->monthName}}
        @else
        
            {{ $this->formatHours($totalHoursDayString) }} Horas diurnas y {{ $this->formatHours($totalHoursNightString) }} horas nocturnas
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
                        <td>{{ $this->formatHours($hourDetailArray['hours_day']) }}</td>
                        <td>{{ $this->formatHours($hourDetailArray['hours_night']) }}</td>
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
                <td>{{ $this->formatHours($totalHoursDay) }}</td>
                @if($fulfillment->serviceRequest->working_day_type === 'DIURNO PASADO A TURNO')
                    <td>{{ $this->formatHours($refundHours) }}</td> @endif
                <td>{{ $this->formatHours($totalHoursNight) }}</td>
                <td>{{ $this->formatHours($totalHours) }}</td>
                <td>{{ $this->formatHours($totalHoursContab) }}</td>
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
                <td>{{ $this->formatHours($totalHoursDay) }}</td>
                @if($fulfillment->serviceRequest->working_day_type === 'DIURNO PASADO A TURNO')
                    <td>{{ $this->formatHours($refundHours) }}</td> @endif
                <td>{{ $this->formatHours($totalHoursNight) }}</td>

                <td>{{ $this->formatHours($totalHours) }}</td>
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
