@extends('layouts.bt4.app')

@section('title', 'Nuevo documento')

@section('content')

@include('documents.partials.nav')

@livewire('sign.request-signature', [
    'document' => $document
])

@endsection