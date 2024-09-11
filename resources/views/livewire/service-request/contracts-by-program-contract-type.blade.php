<ul class="nav mb-3">
    @php
        $dates = []; // Creamos un array para almacenar las fechas de inicio y fin de los contratos
    @endphp

    @foreach ($serviceRequests as $index => $serviceRequest)
        @php
            $hasNotContinuity = $index > 0 && (int) $serviceRequest->start_date->diffInDays($serviceRequests[$index - 1]->end_date) > 1;
            $isCurrentContract = $serviceRequest->start_date <= now() && now() <= $serviceRequest->end_date;
            
            $dates[] = $serviceRequest->start_date->format('Y-m-d');
            $dates[] = $serviceRequest->end_date->format('Y-m-d');

            // Verificar si el contrato actual se solapa con los contratos anteriores
            $isOverlapping = false;
            for ($i = 0; $i < $index; $i++) {
                if (fechasSeSolapan($serviceRequest->start_date, $serviceRequest->end_date, $serviceRequests[$i]->start_date, $serviceRequests[$i]->end_date)) {
                    $isOverlapping = true;
                    break;
                }
            }

            // Verificar si el contrato actual se solapa con los contratos posteriores
            if (!$isOverlapping) {
                for ($j = $index + 1; $j < count($serviceRequests); $j++) {
                    if (fechasSeSolapan($serviceRequest->start_date, $serviceRequest->end_date, $serviceRequests[$j]->start_date, $serviceRequests[$j]->end_date)) {
                        $isOverlapping = true;
                        break;
                    }
                }
            }
        @endphp
        @if ($hasNotContinuity)
            <li>
                |<br>
                |<br>
                |<br>
                |
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link @if ($serviceRequest->id == $service_request_id) font-weight-bold @endif @if($isOverlapping) text-danger @endif" 
                href="{{ route('rrhh.service-request.show', ['user' => $user_id, 'year' => $year, 'type' => $type, 'serviceRequest' => $serviceRequest]) }}">
                <span style="font-size: 19px;"><i>id: {{ $serviceRequest->id }}</i></span><br>
                {{ $serviceRequest->start_date->format('Y-m-d') }} <br>
                {{ $serviceRequest->end_date->format('Y-m-d') }}
            </a>
        </li>
    @endforeach
</ul>
