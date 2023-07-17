<ul class="nav nav-tabs card-header-tabs">
    @foreach ($workingDayTypes as $wdtype => $hasContracts)
        <li class="nav-item">
            @if ($hasContracts)
                <a class="nav-link small @if ($wdtype == $type) active @endif"
                    href="{{ route('rrhh.service-request.show', ['user' => $user_id, 'year' => $year, 'type' => $wdtype]) }}">
                    {{ ucfirst(mb_strtolower($wdtype, 'UTF-8')) }}</a>
            @else
                <span class="nav-link small">
                    {{ ucfirst(mb_strtolower($wdtype, 'UTF-8')) }}
                </span>
            @endif
        </li>
    @endforeach
</ul>
