@extends('layouts.app')

@section('title', 'Listado de destrucciones')

@section('content')
<h3 class="mb-3">Listado de destrucciones</h3>

<ul>
    @foreach($destructions as $key => $destruction)
        <li>{{ $key }}</li>
    @endforeach
</ul>

@endsection

@section('custom_js')

@endsection
