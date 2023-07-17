<ul class="nav mb-3">
    @php
        $previousEndDate = null;
    @endphp

    @foreach ($serviceRequests as $serviceRequest)
        @php
            $hasNotContinuity = $previousEndDate && $previousEndDate->addDay() != $serviceRequest->start_date;
            $previousEndDate = $serviceRequest->end_date;
            $isCurrentContract = $serviceRequest->start_date <= now() && now() <= $serviceRequest->end_date;
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
            <a class="nav-link @if ($serviceRequest->id == $service_request_id) font-weight-bold @endif"
                href="{{ route('rrhh.service-request.show', ['user' => $user_id, 'year' => $year, 'type' => $type, 'serviceRequest' => $serviceRequest]) }}">
                <span style="font-size: 19px;"><i>id: {{ $serviceRequest->id }}</i></span><br>
                {{ $serviceRequest->start_date->format('Y-m-d') }} <br>
                {{ $serviceRequest->end_date->format('Y-m-d') }}
            </a>
        </li>
    @endforeach
</ul>