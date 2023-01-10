@extends('layouts.app')
@section('content')
@include('rem.nav')


<h3 class="mb-3">Carga de REMs</h3>

@php
$form_shown = false;
@endphp

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

                @if (request()->is('*/rem_correccion'))
                @if(!$form_shown)


                <form method="POST" action="{{ route('rem.files.autorizacion_store') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Aquí va el elemento de entrada para subir archivos -->                    
                    <input type="hidden" name="establishment_id" value="{{$remEstablishment->establishment->id}}">
                    <input type="hidden" name="period" value="{{ $period->period }}">
                    <input type="hidden" name="rem_period_series_id" value="{{ $serie->id }}">
                    

                    
                    
                    <div class="form-group">
                        <label for="fileInput"><strong>Subir autorización de corrección</strong> en formato <em>PDF</em></label>
                        <input type="file" class="form-control-file" id="fileInput" name="file" aria-describedby="fileHelp" accept=".pdf">
                        <small id="fileHelp" class="form-text text-muted">Por favor, asegúrate de subir la autorización de corrección en formato PDF.</small>

                    </div>
                    <button type="submit" class="btn btn-primary">Subir</button>
                </form>
                @php
                $form_shown = true;
                @endphp
                @endif
                @endif


                @if (request()->is('*/rem_original'))
                <ul>
                    Serie:{{$serie->serie->name??''}}
                    <br>
                    @livewire('rem.new-upload-rem',['period'=>$period,'serie'=>$serie, 'remEstablishment'=>$remEstablishment,'rem_period_series'=>$serie])
                </ul>
                @endif

                @endif
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