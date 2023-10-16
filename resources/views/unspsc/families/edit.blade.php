@extends('layouts.bt4.app')

@section('title', 'Editar Familia')

@section('content')

@livewire('unspsc.family.family-edit', [
    'segment' => $segment,
    'family' => $family
])

@endsection
