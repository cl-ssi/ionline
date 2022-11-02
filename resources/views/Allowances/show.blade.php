@extends('layouts.app')

@section('title', 'Viático')

@section('content')

@include('allowances.partials.nav')

<h5><i class="fas fa-file"></i>Viatico ID: {{ $allowance->id }}</h5>

<br />
</div>

{{--
<div class="col-sm">
    @livewire('allowances.search-allowances')
</div>
--}}

@endsection

@section('custom_js')

@endsection