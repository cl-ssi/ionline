@extends('layouts.app')

@section('title', 'Bandeja de entrada')

@section('content')

@include('documents.partes.partials.nav')

<h3 class="mb-3">Bandeja de entrada</h3>

<form method="GET" class="form-horizontal" action="{{ route('documents.partes.index') }}">

    <div class="row">
        <fieldset class="form-group col-1">
            <label for="for_id">Cód Int</label>
            <input type="text" class="form-control" id="for_id" name="id">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_type">Tipo</label>
            <select name="type" id="for_type" class="form-control">
                <option></option>
                <option value="Carta">Carta</option>
                <option value="Circular">Circular</option>
                <option value="Decreto">Decreto</option>
                <option value="Demanda">Demanda</option>
                <option value="Informe">Informe</option>
                <option value="Memo">Memo</option>
                <option value="Oficio">Oficio</option>
                <option value="Ordinario">Ordinario</option>
                <option value="Otro">Otro</option>
                <option value="Permiso Gremial">Permiso Gremial</option>
                <option value="Reservado">Reservado</option>
                <option value="Resolucion">Resolución</option>
            </select>
        </fieldset>


        <fieldset class="form-group col-1">
            <label for="for_number">Número</label>
            <input type="text" class="form-control" id="for_number" name="number">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_origin">Origen</label>
            <input type="text" class="form-control" id="for_origin" name="origin">
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_subject">Asunto</label>
            <input type="text" class="form-control" id="for_subject" name="subject">
        </fieldset>

        <button type="submit" class="btn btn-primary mt-4 mb-3">
            <i class="fas fa-search"></i>
        </button>

    </div>
</form>


<h3 class="mt-3">Todos los partes</h3>


<table class="table table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th>N°</th>
            <th>Ingreso</th>
            <th>Tipo</th>
            <th nowrap>Fecha Doc.</th>
            <th>Número</th>
            <th>Origen</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($partes as $parte)
        <tr>
            <td rowspan="2" class="text-center">{{ $parte->id }}</td>
            <td data-toggle="tooltip" data-placement="top"
                data-original-title="{{ $parte->created_at }}">
                <small>{{ $parte->entered_at }}</small>
            </td>
            <td>
                {{ $parte->type }}
                @if($parte->important)
                     <i class="fas fa-exclamation" style="color: red;"></i>
                @endif
            </td>
            <td nowrap>{{ $parte->CreationParteDate }}</td>
            <td class="text-center">{{ $parte->number }}</td>
            <td>{{ $parte->origin }}</td>
            <td nowrap class="text-right">
                @can('Partes: oficina')
                    @if($parte->created_at->diffInDays('now') <= 1)
                    <a class="btn btn-sm btn-primary" href="{{ route('documents.partes.edit', $parte) }}"
                        data-toggle="tooltip" data-placement="top"
                        data-original-title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    @endif
                @endcan

                @can('Partes: director')
                    <a class="btn btn-sm btn-{{ ($parte->requirements->count() >= 1)?'outline-':'' }}primary"
                        href="{{ route('requirements.create_requirement', $parte) }}"
                        data-toggle="tooltip" data-placement="top"
                        data-original-title="Crear Requerimiento (SGR)">
                        <i class="fas fa-rocket"></i>
                    </a>

                    @can('be god')
                    <a class="btn btn-sm btn-primary" href="{{ route('documents.partes.edit', $parte) }}"
                        disabled
                        data-toggle="tooltip" data-placement="top"
                        data-original-title="Informar">
                        <i class="fas fa-paper-plane"></i>
                    </a>
                    @endcan

                    @if($parte->viewed_at)
                        <button class="btn btn-sm btn-outline-dark"
                            data-toggle="tooltip" data-placement="top" readonly
                            data-original-title="{{ $parte->viewed_at }}">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    @else
                        <a class="btn btn-sm btn-primary" href="{{ route('documents.partes.view',$parte) }}"
                            data-toggle="tooltip" data-placement="top"
                            data-original-title="Visto">
                            <i class="fas fa-eye"></i></a>
                    @endif
                @endcan
            </td>

        </tr>
        <tr>
            <td colspan="5" class="pb-3">{{ $parte->subject }}</td>
            <td class="text-center" nowrap>

                @foreach( $parte->requirements as $req)
                    @if( Auth::user()->can('Partes: director'))
                    <a href="{{ route('requirements.show', $req) }}"
                        data-toggle="tooltip" data-placement="top"
                        data-original-title="N°: {{ $req->id }}">
                        <i class="fas fa-rocket"></i>
                    </a>

                    @elseif( Auth::user()->can('Partes: oficina'))
                        @if($req->events->count() > 0)
                            <span  data-toggle="tooltip" data-placement="top"
                            data-original-title="{{ optional($req->events->where('status', '<>', 'en copia')->first()->to_user)->fullName }}
                                                {{ optional($req->events->where('status', '<>', 'en copia')->first())->CreationDate }}">
                            <i class="fas fa-rocket"></i>
                            </span>
                        @endif
                    @endif
                @endforeach

                @if($parte->files->count()>0)
                    @foreach($parte->files as $file)
                        <a href="{{ route('documents.partes.download', $file->id) }}"
                            target="_blank"
                            data-toggle="tooltip" data-placement="top"
                            data-original-title="{{ $file->name }}">
                            <i class="fas fa-paperclip"></i>
                        </a>
                    @endforeach
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $partes->render() }}

@endsection

@section('custom_js')
<script type="text/javascript">
    $('[data-toggle="tooltip"]').tooltip()
</script>
@endsection
