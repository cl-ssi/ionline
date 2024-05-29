@extends('layouts.bt4.app')

@section('title', 'Agenda')

@section('content')

@include('prof_agenda.partials.nav')

@livewire('prof-agenda.booking-agenda')

@endsection