@extends('layouts.app')

@section('title', 'Ingreso de documentos')

@section('content')

@include('documents.partes.partials.nav')

<h3 class="mb-3">Editar Parte</h3>

<form method="POST" class="form" action="{{ route('documents.partes.update', $parte)}}"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-row">
        <fieldset class="form-group col-3">
            <label for="for_entered_at">Fecha Ingreso</label>
            <p class="form-static mt-2" id="for_entered_at" name="entered_at">
                <strong>{{ $parte->entered_at }}</strong>
            </p>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_date">Fecha Documento</label>
            <input type="date" class="form-control" id="for_date" name="date"
                value="{{ $parte->date }}">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_type">Tipo</label>
            <select name="type" id="for_type" class="form-control" required>
                <option {{ ($parte->type == 'Carta')?'selected':'' }} value="Carta">Carta</option>
                <option {{ ($parte->type == 'Circular')?'selected':'' }} value="Circular">Circular</option>
                <option {{ ($parte->type == 'Decreto')?'selected':'' }} value="Decreto">Decreto</option>
                <option {{ ($parte->type == 'Demanda')?'selected':'' }} value="Demanda">Demanda</option>
                <option {{ ($parte->type == 'Informe')?'selected':'' }} value="Informe">Informe</option>
                <option {{ ($parte->type == 'Memo')?'selected':'' }} value="Memo">Memo</option>
                <option {{ ($parte->type == 'Oficio')?'selected':'' }} value="Oficio">Oficio</option>
                <option {{ ($parte->type == 'Ordinario')?'selected':'' }} value="Ordinario">Ordinario</option>
                <option {{ ($parte->type == 'Otro')?'selected':'' }} value="Otro">Otro</option>
                <option {{ ($parte->type == 'Permiso gremial')?'selected':'' }} value="Permiso gremial">Permiso Gremial</option>
                <option {{ ($parte->type == 'Reservado')?'selected':'' }} value="Reservado">Reservado</option>
                <option {{ ($parte->type == 'Resolucion')?'selected':'' }} value="Resolucion">Resolución</option>
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_number">Número</label>
            <input type="text" class="form-control" id="for_number"
                name="number"
                value="{{ $parte->number }}">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_important">&nbsp;</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="important" id="for_important" value="1" @if ($parte->important) checked @endif > 
                    <label class="form-check-label" for="for_important">Importante</label>
                </div>
            </div>
        </fieldset>

    </div>


    <fieldset class="form-group">
        <label for="for_orign">Origen</label>
        <input type="text" class="form-control" id="for_orign" name="origin"
            value="{{ $parte->origin }}"
            required>
        <small id="emailHelp" class="form-text text-muted">Desde donde viene el documento.</small>
    </fieldset>

    <fieldset class="form-group">
        <label for="for_subject">Asunto</label>
        <input type="text" class="form-control" id="for_subject" name="subject"
            value="{{ $parte->subject }}">
    </fieldset>



    <div class="form-row">
        <fieldset class="form-group col-5">
            <!--<label for="for_file">Archivo</label>-->
            <div class="custom-file">
              <label for="forFile">Adjuntar</label>
              <input type="file" class="form-control-file" id="forfile" name="forfile[]" multiple>
            </div>
        </fieldset>


        <fieldset class="form-group col">
            <label for="for_physical_format">&nbsp;</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="physical_format" id="for_physical_format" value="1" @if ($parte->physical_format) checked @endif>
                    <label class="form-check-label" for="for_physical_format">Requiere documento físico al derivar</label>
                </div>
            </div>
        </fieldset>



        <fieldset class="form-group col-2">
            <label for="for_file">&nbsp;</label>
            <div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </fieldset>

        </form>

        <fieldset class="form-group col-10">
            <label for="for_file">Archivos</label>
            <div>
            @if($parte->files->count()>0)
                @foreach($parte->files as $file)
                    <a href="{{ route('documents.partes.download', $file->id) }}"
                        target="_blank"
                        data-toggle="tooltip" data-placement="top"
                        data-original-title="{{ $file->name }}">
                        <i class="fas fa-paperclip"></i>
                    </a>
                    @if($parte->created_at->diffInDays('now') <= 7)


                    <form method="POST" style="display:inline-block;"
                        action="{{ route('documents.partes.files.destroy', $file) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-link">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @endif
                    -
                @endforeach
            @endif
            </div>
        </fieldset>

        @can('Partes: delete')
            <fieldset class="form-group col-2">
                <label for="for_delete">&nbsp;</label>
                <div>
                    @if($parte->created_at->diffInDays('now') <= 5)
                    <form method="POST" style="display:inline-block;"
                        action="{{ route('documents.partes.destroy', $parte) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                    @else
                        <button type="button" class="btn btn-outline-secondary" title="Han pasado más de 5 días" disabled>
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    @endif
                </div>
            </fieldset>
            
            
        @endcan
        

    </div>

@endsection

@section('custom_js')

@endsection
