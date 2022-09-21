@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<div class="row">
  <div class="col-sm-3">
      <h4 class="mb-3"><i class="fas fa-inbox"></i> Mis Solicitudes: </h4>
  </div>

  <div class="col-sm-3">
    <p>
        <a class="btn btn-primary btn-sm" href="{{ route('replacement_staff.request.create') }}">
            <i class="fas fa-plus"></i> Nueva</a>
    </p>
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

@endsection
