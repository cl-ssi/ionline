@extends('layouts.bt4.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<div class="row">
    <div class="col-sm-5">
        <h4 class="mb-3">Listado de RR.HH. para Reemplazo:</h4>
    </div>
</div>

<br />
</div>

<div class="col-sm">
    @livewire('replacement-staff.search-replacement-staff')
</div>

@endsection

@section('custom_js')

@endsection
