@extends('layouts.app')

@section('title', 'Metas Sanitarias Ley N° ' . $law . '/'. $year)

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('indicators.index') }}">Indicadores</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.health_goals.index', $law) }}">Ley {{number_format($law,0,',','.')}}</a></li>
        <li class="breadcrumb-item">{{$year}}</li>
    </ol>
</nav>


<h3 class="mb-3">Metas Sanitarias Ley N° {{number_format($law,0,',','.')}} / {{$year}}. {{--@canany(['Indicators: manager']) <a class="btn btn-primary btn-sm" href="{{route('indicators.comges.create', [$year])}}" role="button"><span class="fa fa-plus"></span></a>@endcanany--}}</h3>
@if($healthGoals->isEmpty())
    <p>No existen o no se han definido aún metas sanitarias ley N° {{number_format($law,0,',','.')}} para el presente año</p>
@else
    @if($law == '19813')
    @foreach($healthGoals as $item)
    <p>{{$item->name}}</p>
        <ul style="list-style-type: none;">
        @foreach($item->indicators as $indicator)
        
            <li><a href="{{ route('indicators.health_goals.show', [$law, $year, $indicator->id]) }}">{{$item->number}}. {{$indicator->name}}</a></li>
        @endforeach
        </ul>
    @endforeach
    @else
    @foreach($healthGoals as $item)
    <p>
        <a href="{{ route('indicators.health_goals.show', [$law, $year, $item->number]) }}">{{$item->number}}. {{$item->name}}</a>
    </p>
    @endforeach
    @endif
@endif
@endsection

@section('custom_js')

@endsection