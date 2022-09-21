@extends('layouts.app')

@section('title', 'Listado de Solicitudes')

@section('content')

@include('replacement_staff.nav')

<!-- <div class="row">
    <div class="col-sm-3">
        <h4 class="mb-3">Listado de Solicitudes: </h4>
    </div>
    <div class="col-sm-3">
        <p>
            <a class="btn btn-primary disabled" data-toggle="collapse" href="#collapseSearch" role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="fas fa-filter"></i> Filtros
            </a>
        </p>
    </div>
</div> -->

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

@endsection
