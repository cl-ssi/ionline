<div>
    <ul class="nav">
        <li class="nav-item">
            <b class="nav-link">Año</b>
        </li>
        @foreach ($yearsRange as $yearName => $hasContracts)
            <li class="nav-item">
                @if ($hasContracts)
                    <a class="nav-link @if ($yearName == $year) font-weight-bold @endif"
                        href="{{ route('rrhh.service-request.show', ['user' => $user_id, 'year' => $yearName]) }}">
                        {{ $yearName }}
                    </a>
                @else
                    <span class="nav-link">{{ $yearName }}</span>
                @endif
            </li>
        @endforeach
    </ul>
</div>
