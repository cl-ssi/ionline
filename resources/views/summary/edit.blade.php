@extends('layouts.app')

@section('title', 'Editar Sumario')

@section('content')

    @include('summary.nav')

    <h3 class="mb-3">Sumario: {{ $summary->id }} - {{ $summary->subject ?? '' }}</h3>

    @include('summary.partials.header')

    @foreach ($summary->summaryEvents as $event)
        @include('summary.partials.event')
        <br>
    @endforeach

    @include('summary.partials.add_event')

@endsection
