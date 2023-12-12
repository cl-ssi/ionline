@extends('layouts.bt5.app')

@section('title', 'DNC')

@section('content')

@include('identify_needs.partials.nav')

<h4 class="mt-3"><i class="far fa-newspaper"></i> Mis DNC</h4>
<p>Incluye los DNC de mi Unidad Organizacional: <b>{{ Auth()->user()->organizationalUnit->name }}</b></p>

@livewire('identify-needs.search-identify-need', [
    'index'    => 'own',
])

@endsection

@section('custom_js')

<script type='text/javascript'>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>

@endsection