@extends('layouts.app')

@section('title', 'Home')

@section('content')
@php
$today = \Carbon\Carbon::now();
$firstDay = $today->firstOfMonth();
$lastDayofMonth = \Carbon\Carbon::parse($today)->endOfMonth()->toDateString();
$period = \Carbon\CarbonPeriod::create($firstDay, $lastDayofMonth);
@endphp
{{ $today }}
<br>
<br>
{{$firstDay}}
<br>
<br>
{{$lastDayofMonth}}
<br>
<br>
<table class="center">

    <tr>
        <th></th>
        @foreach($period as $date)
        <th class="border text-nowrap">{{$date->format('d-m-Y')}}</th>
        @endforeach
    </tr>
    @for ($i = 0; $i < 10; $i++)
    <tr><td>Persona {{ $i }}</td></tr>    
    @endfor
    
</table>
@endsection