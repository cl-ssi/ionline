@extends('layouts.bt4.app')

@section('title', 'Ley 18834')

@section('content')

@include('indicators.partials.nav')

<div class="col-5">
  <div class="card">
      <div class="card-header">
          <strong>Metas Sanitarias Ley N° 18.834</strong>
      </div>
      <ul class="list-group list-group-flush">
          <li class="list-group-item">
              <a href="{{ route('indicators.health_goals.list', [18834, 2024]) }}">2024</a>
          </li>
          <li class="list-group-item">
              <a href="{{ route('indicators.health_goals.list', [18834, 2023]) }}">2023</a>
          </li>
          <li class="list-group-item">
              <a href="{{ route('indicators.health_goals.list', [18834, 2022]) }}">2022</a>
          </li>
          <li class="list-group-item">
              <a href="{{ route('indicators.health_goals.list', [18834, 2021]) }}">2021</a>
          </li>
          <li class="list-group-item">
              <a href="{{ route('indicators.18834.2020.index') }}">2020</a>
          </li>
          <li class="list-group-item">
              <a href="{{ route('indicators.18834.2019.index') }}">2019</a>
          </li>
          <li class="list-group-item">
              <a href="{{ route('indicators.18834.2018.index') }}">2018</a>
          </li>
      </ul>
  </div>
</div>

@endsection

@section('custom_js')

@endsection
