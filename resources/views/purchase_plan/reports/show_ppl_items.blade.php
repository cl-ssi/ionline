@extends('layouts.bt5.app')

@section('title', 'Plan de Compras - Reportes')

@section('content')

@include('purchase_plan.partials.nav')

<div class="row">
  <div class="col-sm">
      <h5 class="mb-3">Reporte:</h5>
      <h6 class="mb-3"><i class="fas fa-fw fa-list-ol"></i>Plan de Compras - Items</h6>
  </div>
</div>

</div>

@livewire('purchase-plan.search-purchase-plan', [
    'index' => 'report: ppl-items'
])

@endsection

@section('custom_js')

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

@endsection