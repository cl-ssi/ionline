@extends('layouts.bt4.external')


@section('content')
@livewire('suitability.school-requests', ['school' => $school])

@endsection