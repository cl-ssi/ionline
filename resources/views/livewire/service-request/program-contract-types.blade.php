<ul class="nav nav-pills justify-content-end">
    <li class="nav-item">
        <span class="nav-link">
            <b>Tipo</b>
        </span>
    </li>
    @foreach ($programContractTypes as $wdtype => $hasContracts)
        @if ($hasContracts)
            <li class="nav-item">
                <a class="nav-link @if ($wdtype == $type) active @endif" 
                    href="{{ route('rrhh.service-request.show', ['user' => $user_id, 'year' => $year, 'type' => $wdtype]) }}">
                    {{ $wdtype }}
                </a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link disabled">{{ $wdtype }}</a>
            </li>
        @endif
    @endforeach
</ul>