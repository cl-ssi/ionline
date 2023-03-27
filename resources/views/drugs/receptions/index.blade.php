@extends('layouts.app')

@section('title', 'Actas de recepción')

@section('content')

@include('drugs.nav')

@livewire('drugs.receptions.reception-index')

@endsection

@section('custom_js')

@endsection
