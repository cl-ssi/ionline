@extends('layouts.bt5.app')

@section('title', 'Reuniones')

@section('content')

@include('meetings.partials.nav')

<h5><i class="fas fa-users fa-fw"></i> Mis reuniones</h5>
<p>Incluye Reuniones de mi Unidad Organizacional: <b>{{ auth()->user()->organizationalUnit->name }}</b></p>

<div class="col-sm">
    @livewire('meetings.search-meeting', [
        'index' => 'own'
    ])
</div>


@endsection

@section('custom_js')

@endsection