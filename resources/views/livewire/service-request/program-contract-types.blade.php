<ul class="nav nav-tabs card-header-tabs justify-content-end">
    @foreach ($programContractTypes as $wdtype => $hasContracts)
        <li class="nav-item">
            @if ($hasContracts)
                <a class="nav-link small @if ($wdtype == $type) active @endif"
                    href="{{ route('rrhh.service-request.show', ['user' => $user_id, 'year' => $year, 'type' => $wdtype]) }}">
                    {{ $wdtype }}</a>
            @else
                <span class="nav-link small">
                    {{ $wdtype }}
                </span>
            @endif
        </li>
    @endforeach
</ul>
