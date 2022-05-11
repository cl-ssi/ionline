@extends('layouts.app')

@section('title', 'Familias')

@section('content')

@livewire('unspsc.family.family-index', ['segment' => $segment])

@endsection
