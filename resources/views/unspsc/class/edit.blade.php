@extends('layouts.bt4.app')

@section('title', 'Editar Clase')

@section('content')

@livewire('unspsc.clase.clase-edit', [
    'segment' => $segment,
    'family' => $family,
    'class' => $class
])

@endsection
