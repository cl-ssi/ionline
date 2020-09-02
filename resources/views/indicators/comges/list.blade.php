@extends('layouts.app')

@section('title', 'Compromiso de Gestión ' . $year)

@section('content')

@include('indicators.partials.nav')


<h3 class="mb-3">Compromisos de Gestión {{$year}} - Referentes. @canany(['Indicators: manager']) <a class="btn btn-primary btn-sm" href="{{route('indicators.comges.create', [$year])}}" role="button"><span class="fa fa-plus"></span></a>@endcanany</h3>
@forelse($comges as $item)
    <p><a href="#comges{{$item->number}}" class="dropdown-toggle" data-toggle="collapse">{{$item->number}}. {{$item->name}}</a>
    @canany(['Indicators: manager']) <a href="{{route('indicators.comges.edit', [$item])}}"><span class="fa fa-edit"></span></a> @endcanany
    @foreach($item->users as $referente)
        <span class="badge badge-pill badge-light">{{$referente->pivot->referrer_number}}. {{$referente->name}} {{$referente->fathers_family}}</span>
    @endforeach
    <!-- <span class="badge badge-success"><i class="fas fa-check"></i></span> -->
    @php ($romans = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV'])
    @for($i = 1 ; $i <= 4 ; $i++)
        <div class="collapse" id="comges{{$item->number}}">
            <ul>
                <a href="{{ route('indicators.comges.show', [$item->year, $item->number, $i]) }}">
                    <li>{{$romans[$i]}} Corte</li>
                </a>
            </ul>
        </div>
    @endfor
</p>
@empty
    <p>No existen compromisos de gestión para el presente año</p>
@endforelse
@endsection

@section('custom_js')

@endsection