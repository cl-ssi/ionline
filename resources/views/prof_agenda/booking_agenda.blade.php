@extends('layouts.bt4.app')

@section('title', 'Agenda')

@section('content')

@include('prof_agenda.partials.nav')

<h3>Agendar horas</h3>

<form method="GET" class="form-horizontal" action="{{ route('prof_agenda.agenda.booking') }}">
    @livewire('prof-agenda.select-user-profesion',['profession_id' => $request->profession_id, 'user_id' => $request->user_id, 'profesional_ust' => false])
</form>

<hr>

@if($proposals->count()>0)
    @livewire('prof-agenda.booking-agenda',['profession_id' => $request->profession_id, 'profesional_id' => $request->user_id])
    @stack('scripts')
@endif

@endsection

<!-- CSS Custom para el calendario -->
@section('custom_css')

@endsection

@section('custom_js')

@endsection