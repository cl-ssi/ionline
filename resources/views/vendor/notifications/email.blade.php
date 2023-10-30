<x-mail::message>
<span style="background-color: #0168B3; width: 87px; display: inline-block; padding: 0;">&nbsp;</span><span style="background-color: #EE3A43; width: 123px; display: inline-block; padding: 0;">&nbsp;</span>
<div style="font-size:10.5pt;
            font-family: Arial, Helvetica, sans-serif;
            color: #505050;
            font-weight: 800;
            width: 280px;">{{ env('APP_SS') }}</div>
<div style="font-size:9.0pt;
            font-family: Arial, Helvetica, sans-serif;
            padding-top: 6px;
            font-weight: 600;
            color: #808080;">Ministerio de Salud</div>
<div style="font-size:8.4pt;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 800;
            padding-top: 3px;
            color: #808080;">Gobierno de Chile</div>

<div class="subcopy"></div>

{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif


{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "Si tiene problemas para hace click en el botón \":actionText\",\n".
    'copie y pegue la siguiente URL en su navegador web:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset



</x-mail::message>
