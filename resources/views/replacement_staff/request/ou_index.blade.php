@extends('layouts.bt4.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<div class="row">
    <div class="col-sm-9">
        <h4 class="mb-3">Solicitudes de: <small>{{ auth()->user()->organizationalUnit->name }}</small></h4>
    </div>
</div>

</div>

<div class="col-sm">
    @livewire('replacement-staff.search-requests', [
        'typeIndex' => 'ou'
        ])
</div>

@endsection

@section('custom_js')

@endsection
