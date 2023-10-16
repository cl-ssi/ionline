@extends('layouts.bt4.app')

@section('title', 'Listado de Solicitudes')

@section('content')

@include('replacement_staff.nav')

<div class="row">
  <div class="col-sm">
      <h4 class="mb-3"><i class="fas fa-inbox"></i> Listado de Solicitudes: </h4>
  </div>
</div>

</div>

<br>

<div class="col-sm">
    @livewire('replacement-staff.search-requests', [
        'typeIndex' => 'assign'
    ])
</div>

@endsection

@section('custom_js')

<script>
    $('[data-toggle="tooltip"]').tooltip()
</script>

@endsection
