@extends('layouts.app')

@section('title', 'Mi amiPASS')

@section('content')

<!-- Nav tabs -->
<ul class="nav nav-tabs d-print-none" id="myTab" role="tablist">
  <li class="nav-item" wire:ignore>
    <a class="nav-link active" data-toggle="tab" role="tab" 
            href="#mis-cargas">Mis cargas</a>
    <!-- <button class="nav-link active" id="cargas-tab" data-bs-toggle="tab" data-bs-target="#cargas" type="button" role="tab" aria-controls="cargas" aria-selected="true">Mis cargas</button> -->
  </li>
  <li class="nav-item" wire:ignore>
    <a class="nav-link" data-toggle="tab" role="tab" 
            href="#mis-ausentismos">Mis ausentismos</a>
    <!-- <button class="nav-link" id="ausentismos-tab" data-bs-toggle="tab" data-bs-target="#ausentismos" type="button" role="tab" aria-controls="ausentismos" aria-selected="true">Mis ausentismos</button> -->
  </li>
</ul>

<!-- Tab panes -->
<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="mis-cargas" role="tabpanel" wire:ignore.self>
        @livewire('welfare.amipass.charge-index')
    </div>
    <div class="tab-pane fade" id="mis-ausentismos" role="tabpanel" wire:ignore.self>
        @livewire('welfare.amipass.absences-index')
    </div>
</div>
@endsection

@section('custom_js')
<script type="text/javascript">
    $('#myTab a[href=#mis-cargas]').tab('show') // Select tab by name
</script>
@endsection