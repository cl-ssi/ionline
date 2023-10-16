@extends('layouts.bt4.app')

@section('title', 'Familias')

@section('content')

@livewire('unspsc.family.family-index', ['segment' => $segment])

@endsection
