@extends('layouts.app')

@section('title', 'Usuarios con acceso al módulo')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Usuarios con acceso al módulo de drogas</h3>

<ul>
    @foreach($users as $user)
        <li>{{ $user->fullName }}</li>
    @endforeach
</ul>

@endsection

@section('custom_js')

@endsection
