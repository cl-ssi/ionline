@extends('layouts.bt4.app')

@section('title', 'Ingreso de documentos')

@section('content')

@include('documents.partes.partials.nav')

<h3 class="mb-3">Ingreso Parte</h3>

<form method="POST" class="form" action="{{ route('documents.partes.store')}}" enctype="multipart/form-data">
    @csrf
    @method('POST')

    <div class="form-row">
        <fieldset class="form-group col-3">
            <label for="for_entered_at">Fecha Ingreso*</label>
            <input type="datetime-local" class="form-control" id="for_entered_at"
                name="entered_at" value="{{ date('Y-m-d\TH:i') }}" required>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_date">Fecha Documento*</label>
            <input type="date" class="form-control" id="for_date"name="date" required>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_type_id">Tipo*</label>
            <select name="type_id" id="for_type_id" class="form-control" required>
                <option value=""></option>
                @foreach($types as $id => $type)
                    <option value="{{ $id }}">{{ $type }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_number">Número</label>
            <input type="number" class="form-control" id="for_number" name="number">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_reserved">&nbsp;</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="reserved" id="for_reserved">
                    <label class="form-check-label" for="for_reserved">Reservado</label>
                </div>
            </div>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_important">&nbsp;</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="important" id="for_important">
                    <label class="form-check-label" for="for_important">Importante</label>
                </div>
            </div>
        </fieldset>
    </div>


    <fieldset class="form-group">
        <label for="for_orign">Origen*</label>
        <input type="text" class="form-control" id="for_orign" name="origin" required>
        <small id="emailHelp" class="form-text text-muted">Desde donde viene el documento.</small>
    </fieldset>

    <fieldset class="form-group">
        <label for="for_subject">Asunto*</label>
        <textarea name="subject" id="for_subject" class="form-control" rows="3" required></textarea>
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
                    <input class="form-check-input" type="checkbox" name="physical_format" id="for_physical_format" value="1">
                    <label class="form-check-label" for="for_physical_format">Requiere documento físico al derivar</label>
                </div>
            </div>
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_file">&nbsp;</label>
            <div>
                <button type="submit" class="btn btn-primary">Ingresar</button>
            </div>
        </fieldset>

        

    </div>

</form>


@endsection

@section('custom_js')

@endsection
