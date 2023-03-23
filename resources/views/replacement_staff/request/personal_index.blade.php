@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<div class="row">
    <div class="col-sm-9">
        <h4 class="mb-3"><i class="fas fa-inbox"></i> Todas las solicitudes: </h4>
    </div>
</div>

</div>

<div class="col-sm">
    @livewire('replacement-staff.search-requests', [
        'typeIndex' => 'personal'
    ])
</div>

@endsection

@section('custom_js')

@endsection
