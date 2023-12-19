@extends('layouts.bt4.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<div class="row">
    <div class="col-sm-3">
        <h4 class="mb-3"><i class="fas fa-inbox"></i> Mis Solicitudes: </h4>
    </div>
</div>

</div>

<div class="col-sm">
    @livewire('replacement-staff.search-requests', [
        'typeIndex' => 'own'
        ])
</div>

@endsection

@section('custom_js')

<script>
    // $('[data-toggle="tooltip"]').tooltip()

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

@endsection
