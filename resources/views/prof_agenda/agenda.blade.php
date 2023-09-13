@extends('layouts.app')

@section('title', 'Agenda')

@section('content')

@include('prof_agenda.partials.nav')

<h3>Gestor de la agenda</h3>

<form method="GET" class="form-horizontal" action="{{ route('prof_agenda.agenda.index') }}">

@livewire('prof-agenda.select-user-profesion',['profession_id' => $request->profession_id, 'user_id' => $request->user_id])

</form>

<hr>

@if($proposals->count()>0)
    @livewire('prof-agenda.agenda',['proposals' => $proposals])
    @stack('scripts')
@endif

@endsection

<!-- CSS Custom para el calendario -->
@section('custom_css')

@endsection

@section('custom_js')

@endsection