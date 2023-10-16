@extends('layouts.bt4.app')
@section('custom_css')
<style>
	.sticky-left {
    position: sticky;
    left: 0;
    z-index: 1;
    background-color: #fff; /* Cambia esto al color de fondo deseado */
}
</style>
@endsection

@section('content')
@include('rem.nav')

<h3 class="mb-3">Carga de REMs Corrección</h3>

<table class="table table-bordered table-sm small">
    <thead>
        <tr class="text-center">
            <th class="sticky-left">Establecimiento/Período</th>
            @foreach($periods as $period)
            <th>{{ $period->year??'' }}-{{$period->month??''}}</th>
            @endforeach

        </tr>
    </thead>
    <tbody>
        @foreach(auth()->user()->remEstablishments as $remEstablishment)
        <tr>
            <td class="text-center font-weight-bold sticky-left">
                {{$remEstablishment->establishment->official_name ?? ''}}
                ({{$remEstablishment->establishment->establishmentType->name ?? ''}})
                ({{$remEstablishment->establishment->new_deis_without_first_character ?? ''}})
            </td>
            @foreach($periods as $key=>$period)
            <td>
                @if($filesAutorizacion[$key])
                <span class="text-success">Existe archivo de Autorización por lo que puede Descargar la autorizacion o proceder a subir modificaciones a REM</span>
                <br>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('rem.files.download', $filesAutorizacion[$key]->id) }}" class="btn btn-primary">Descargar</a>
                    <form method="POST" class="form-horizontal" action="{{ route('rem.files.destroy', $filesAutorizacion[$key]->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="form-horizontal btn btn-danger" onclick="return confirm('¿Está seguro que desea eliminar la autorización, recordar que no podrá  modificar los REM hasta que no tenga una autorización?' )"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
                <br><br>
                @foreach($period->series as $serie)
                @if($serie->type == $remEstablishment->establishment->type)
                <ul>
                    Serie:{{$serie->serie->name??''}}<strong style="color: red;"> Corrección</strong>
                    <br>
                    @livewire('rem.new-upload-rem',['period'=>$period,'serie'=>$serie, 'remEstablishment'=>$remEstablishment,'rem_period_series'=>$serie, 'type'=>'Correccion'])
                </ul>
                @endif
                @endforeach

                @else
                <form method="POST" action="{{ route('rem.files.autorizacion_store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="establishment_id" value="{{$remEstablishment->establishment->id}}">
                    <input type="hidden" name="period" value="{{ $period->period }}">
                    <div class="form-group">
                        <label for="fileInput"><strong>Subir autorización de corrección</strong> en formato <em>PDF</em></label>
                        <input type="file" class="form-control-file" id="fileInput" name="file" aria-describedby="fileHelp" accept=".pdf">
                        <small id="fileHelp" class="form-text text-muted">Por favor, asegúrate de subir la autorización de corrección en formato PDF.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Subir</button>
                </form>
                @endif
            </td>
            @endforeach

        </tr>
        @endforeach
    </tbody>
</table>


@endsection