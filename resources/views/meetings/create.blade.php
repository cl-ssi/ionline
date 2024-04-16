@extends('layouts.bt5.app')

@section('title', 'Reuniones')

@section('content')

@include('meetings.partials.nav')

<h5><i class="fas fa-users fa-fw"></i> Nueva Reunión</h5>

<div class="col-sm">
    @livewire('meetings.meeting-create', [
        'meetingToEdit' => null,
        'form'          => 'create'
    ])
</div>


@endsection

@section('custom_js')

@endsection