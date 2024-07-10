@extends('layouts.bt5.app')

@section('title', 'Reuniones')

@section('content')

@include('meetings.partials.nav')

<h5><i class="fas fa-users fa-fw"></i> Todas las reuniones</h5>

<div class="col-sm">
    @livewire('meetings.search-meeting', [
        'index' => 'all'
    ])
</div>


@endsection

@section('custom_js')

@endsection