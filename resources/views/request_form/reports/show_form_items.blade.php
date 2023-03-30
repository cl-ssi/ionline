@extends('layouts.app')

@section('title', 'Reportes')

@section('content')

@include('request_form.partials.nav')

<div class="row">
  <div class="col-sm">
      <h5 class="mb-3">Reporte:</h5>
      <h6 class="mb-3"><i class="fas fa-fw fa-list-ol"></i>Formularios - Items</h6>
  </div>
</div>

</div>

<div class="col-sm">
    @livewire('request-form.search-requests', [
      'inbox' => 'report: form-items'
    ])
</div>

@endsection

@section('custom_js')

@endsection