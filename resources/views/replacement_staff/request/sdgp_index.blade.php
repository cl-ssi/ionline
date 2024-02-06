@extends('layouts.bt4.app')

@section('title', 'Listado de Solicitudes')

@section('content')

@include('replacement_staff.nav')

<div class="row">
    <div class="col-sm-9">
        <h4 class="mb-3"><i class="fas fa-inbox"></i> Todas las solcitudes: </h4>
    </div>
</div>

</div>

<div class="col-sm">
    @livewire('replacement-staff.search-requests', [
        'typeIndex' => 'sdgp'
    ])
</div>

@endsection

@section('custom_js')

@endsection
