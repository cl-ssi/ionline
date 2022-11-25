@extends('layouts.app')

@section('title', 'Requerimientos')

@section('content')

@include('requirements.partials.nav')

<div class="alert alert-info" role="alert">
	Recuerda siempre cerrar los requerimientos y archivarlos si ya están terminados.
</div>

@livewire('requirements.counters', [
    'user' => $user,
    'auth_user' => $auth_user,
])

@livewire('requirements.filter', [
    'user' => $user,
    'auth_user' => $auth_user,
    'allowed_users' => $allowed_users,
])

@endsection
