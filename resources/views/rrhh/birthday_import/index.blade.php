@extends('layouts.bt4.app')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

@livewire('rrhh.import-birthdays-file')

<hr>

@livewire('rrhh.birthday-email-configuration')

@endsection