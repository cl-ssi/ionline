@extends('layouts.app')

@section('title', 'Editar Sumario')

@section('content')

    @include('summary.nav')

    <h3 class="mb-3">Sumario: {{ $summary->id }} - {{ $summary->subject ?? '' }}</h3>

    @include('summary.partials.header')

    @include('summary.partials.event', ['events' => $summary->events])

    @if ($summary->lastEvent->end_date && !$summary->end_at)
        @include('summary.partials.add_event', ['links' => $summary->lastEvent->type->linksEvents,'event' => $summary->lastEvent])
    @endif
    
@endsection
