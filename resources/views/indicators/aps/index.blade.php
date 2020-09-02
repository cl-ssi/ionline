@extends('layouts.app')

@section('title', 'APS')

@section('content')

@include('indicators.partials.nav')

<div class="col-5">
  <div class="card">
      <div class="card-header">
          <strong>Indicadores APS.</strong>
      </div>
      <ul class="list-group list-group-flush">
          <li class="list-group-item">
              <a href="{{ route('indicators.aps.2020.index') }}">2020</a> <span class="badge badge-warning">En Desarrollo</span>
          </li>
      </ul>
  </div>

</div>

@endsection

@section('custom_js')

@endsection
