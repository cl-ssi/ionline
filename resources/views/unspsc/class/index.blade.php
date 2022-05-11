@extends('layouts.app')

@section('title', 'Clases')

@section('content')

@livewire('unspsc.clase.clase-index', [
    'segment' => $segment,
    'family' => $family
])

@endsection
