@if ($dte->requestForm)
    @if ($dte->requestForm->father)
        @foreach ($dte->requestForm->father->requestFormFiles as $requestFormFile)
            <a href="{{ route('request_forms.show_file', $requestFormFile) }}"
                class="list-group-item list-group-item-action py-2 small" target="_blank">
                <i class="fas fa-file"></i> {{ $requestFormFile->name }} -
                <i class="fas fa-calendar-day"></i>
                {{ $requestFormFile->created_at->format('d-m-Y H:i') }}</a>
        @endforeach
    @endif

    @foreach ($dte->requestForm->requestFormFiles as $requestFormFile)
        <a href="{{ route('request_forms.show_file', $requestFormFile) }}"
            class="list-group-item list-group-item-action py-2 small" target="_blank">
            <i class="fas fa-file"></i> {{ $requestFormFile->name }} -
            <i class="fas fa-calendar-day"></i>
            {{ $requestFormFile->created_at->format('d-m-Y H:i') }}</a>
    @endforeach
@endif