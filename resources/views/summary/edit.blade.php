@extends('layouts.bt5.app')

@section('title', 'Editar Sumario')

@section('content')

    @include('summary.nav')

    <h3 class="mb-3">{{ $summary->type->name }}: {{ $summary->id }} - {{ $summary->subject ?? '' }}</h3>

    @include('summary.partials.header')

    @include('summary.partials.event', ['events' => $summary->events])

    @if ($summary->lastEvent?->end_date && !$summary->end_at)
        @include('summary.partials.add_event', [
            'links' => $summary->lastEvent->type->linksEvents,
            'event' => $summary->lastEvent,
            'childs' => false
        ])
    @endif
    
@endsection

@section('custom_js')
<script type="text/javascript">

    $('.custom-file input').change(function (e) {
        if (e.target.files.length) {
            $(this).next('.custom-file-label').html(e.target.files[0].name);
        }
    });

</script>
@endsection