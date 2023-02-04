@extends('layouts.app')
@section('content')
@include('rem.nav')

<h3 class="mb-3">Carga de REMs Corrección</h3>

<table class="table table-bordered table-sm small">
    <thead>
        <tr class="text-center">
            <th>Establecimiento/Período</th>
            @foreach($periods as $period)
            <th>{{ $period->year??'' }}-{{$period->month??''}}</th>
            @endforeach

        </tr>
    </thead>
    <tbody>
        @foreach(auth()->user()->remEstablishments as $remEstablishment)
        <tr>
            <td class="text-center font-weight-bold">
                {{$remEstablishment->establishment->name}}
                ({{$remEstablishment->establishment->type}})
                ({{$remEstablishment->establishment->new_deis_without_first_character}})
            </td>
            @foreach($periods as $key=>$period)
            <td>
                @if($filesExist[$key] && $filesExist[$key]->type == 'Original')
                @if($filesAutorizacion[$key])
                <span class="text-success">Existe archivo de Autorización por lo que puede Descargar la autorizacion o proceder a subir modificaciones a REM</span><br>
                <a href="{{ route('rem.files.download', $filesAutorizacion[$key]->id) }}" class="btn btn-primary">Descargar</a>
                <br><br>
                <ul>
                    Serie:{{$filesExist[$key]->periodSerie->serie->name??''}} <strong style="color: red;">Corrección</strong>
                    <br>
                    @livewire('rem.new-upload-rem',['period'=>$period,'serie'=>$filesExist[$key]->periodSerie->serie, 'remEstablishment'=>$remEstablishment,'rem_period_series'=>$filesExist[$key]->periodSerie, 'type'=>'Correccion'])
                </ul>
                @else
                <form method="POST" action="{{ route('rem.files.autorizacion_store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="establishment_id" value="{{$remEstablishment->establishment->id}}">
                    <input type="hidden" name="period" value="{{ $period->period }}">
                    <input type="hidden" name="rem_period_series_id" value="{{ $filesExist[$key]->periodSerie->id }}">
                    <div class="form-group">
                        <label for="fileInput"><strong>Subir autorización de corrección</strong> en formato <em>PDF</em></label>
                        <input type="file" class="form-control-file" id="fileInput" name="file" aria-describedby="fileHelp" accept=".pdf">
                        <small id="fileHelp" class="form-text text-muted">Por favor, asegúrate de subir la autorización de corrección en formato PDF.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Subir</button>
                </form>
                @endif
                @else
                <span class="text-danger">No existe archivo de REM por lo que no se puede subir Autorización</span>
                @endif
            </td>
            @endforeach

        </tr>
        @endforeach
    </tbody>
</table>


@endsection