@extends('layouts.bt5.app')

@section('title', 'Reuniones')

@section('content')

@include('meetings.partials.nav')

<h5><i class="fas fa-users fa-fw"></i> Mi Reunión ID: {{ $meeting->id }}</h5>

<div class="col-sm">
    @livewire('meetings.meeting-create', [
        'meetingToEdit' => $meeting,
        'form'          => 'edit'
    ])
</div>


@endsection

@section('custom_js')

@endsection