@extends('layouts.app')
@section('content')
@include('rem.nav')


<h3 class="mb-3">Carga de REMs</h3>



<table class="table table-bordered table-sm small">
    <thead>
        <tr class="text-center">
            <th>Establecimiento/Período</th>
            @foreach($periods as $period)
            <th>{{ $period->year??'' }}-{{$period->month??''}}</th>
            @endforeach
        </tr>
        @foreach(auth()->user()->remEstablishments as $remEstablishment)
        <tr>
            <td class="text-center font-weight-bold">
                {{$remEstablishment->establishment->name}}
                ({{$remEstablishment->establishment->type}})
            </td>

            @foreach($periods as $period)
            <td>
                @forelse($period->series as $serie)                
                @if($serie->type == $remEstablishment->establishment->type)
                <ul>
                    Serie:{{$serie->serie->name??''}}
                    <br>
                    @livewire('rem.new-upload-rem',['period'=>$period,'serie'=>$serie, 'remEstablishment'=>$remEstablishment,'rem_period_series'=>$serie, 'type'=>'Original'])
                </ul>
                @endif()
                @empty
                <h6>No Existen Series asociado a este periodo, Favor asociar Serie al periodo</h6>
                @endforelse
            </td>
            @endforeach
        </tr>

        @endforeach

    </thead>
</table>

@endsection