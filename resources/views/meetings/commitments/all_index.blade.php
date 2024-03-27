@extends('layouts.bt5.app')

@section('title', 'Reuniones')

@section('content')

@include('meetings.partials.nav')

<h5><i class="fas fa-users fa-fw"></i> Mis compromisos</h5>
<p>Incluye compromisos de mi Unidad Organizacional: <b>{{ auth()->user()->organizationalUnit->name }}</b></p>

</div>

<div class="col-sm">
    @livewire('meetings.search-commitment', [
        'index' => 'all'
    ])
</div>


@endsection

@section('custom_js')

@endsection