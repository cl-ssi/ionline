@extends('layouts.app')

@section('title', 'Solicitud de firma y distribución')

@section('content')

    <h3>Edición Solicitud de Firma</h3>

    <form method="POST" action="{{ route('documents.signatures.update', $signature) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-row">

            <fieldset class="form-group col-3">
                <label for="for_request_date">Fecha Documento</label>
                <input type="date" class="form-control" id="for_request_date" name="request_date" required
                       value="{{\Carbon\Carbon::parse($signature->request_date)->format('Y-m-d')}}">
            </fieldset>
        </div>

        <div class="form-row">

            <fieldset class="form-group col-3">
                <label for="for_document_type">Tipo de Documento</label>
                <select class="form-control selectpicker" data-live-search="true" name="document_type" required=""
                        data-size="5">
                    <option value="Carta" @if($signature->document_type == 'Carta') selected @endif >Carta</option>
                    <option value="Circular" @if($signature->document_type == 'Circular') selected @endif>Circular
                    </option>
                    <option value="Convenios" @if($signature->document_type == 'Convenios') selected @endif>Convenios
                    </option>
                    <option value="Memorando" @if($signature->document_type == 'Memorando') selected @endif>Memorando
                    </option>
                    <option value="Oficio" @if($signature->document_type == 'Oficio') selected @endif>Oficio</option>
                    <option value="Resoluciones" @if($signature->document_type == 'Resoluciones') selected @endif>
                        Resoluciones
                    </option>
                </select>
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_subject">Materia o tema del documento</label>
                <input type="text" class="form-control" id="for_subject" name="subject" required
                       value="{{$signature->subject}}">
            </fieldset>

        </div>

        <div class="form-row">
            <fieldset class="form-group col">
                <label for="for_description">Descripción del documento</label>
                <input type="text" class="form-control" id="for_description" name="description"
                       value="{{$signature->description}}">
            </fieldset>
        </div>

        <div class="form-row">
            <fieldset class="form-group col">
                <label for="for_document">Documento a distribuir</label>
                <input type="file" class="form-control" id="for_document" name="document">

                {{--                <a href="{{ route('lab.suspect_cases.download', $suspectCase->id) }}"--}}
                <a href="{{route('documents.showPdfDocumento', $signature)}}"
                   target="_blank" data-toggle="tooltip" data-placement="top"
                   data-original-title="">Documento <i
                        {{--                        data-original-title="{{ $suspectCase->id . 'pdf' }}">Resultado <i--}}
                        class="fas fa-paperclip"></i>&nbsp
                </a>
            </fieldset>


            <fieldset class="form-group col">
                <label for="for_annexed">Anexos</label>
                <input type="file" class="form-control" id="for_annexed" name="annexed[]" multiple>

                @foreach($signature->signaturesFiles->where('file_type', 'anexo') as $anexo)
                    <a href="{{route('documents.showPdfAnexo', $anexo)}}"
                       target="_blank" data-toggle="tooltip" data-placement="top"
                       data-original-title="">Anexo <i
                            {{--                        data-original-title="{{ $suspectCase->id . 'pdf' }}">Resultado <i--}}
                            class="fas fa-paperclip"></i>&nbsp
                    </a>
                @endforeach

            </fieldset>
        </div>

        <hr>
        @livewire('signatures.visators', ['signature' => $signature])
        <hr>
        @livewire('signatures.signer', ['signaturesFlowSigner' => $signature->signaturesFlowSigner])

        <div class="form-row">

            <fieldset class="form-group col">
                <label for="for_recipients">Destinatarios del documento (separados por coma)</label>
                <input type="text" class="form-control" id="for_recipients" name="recipients"
                       value="{{$signature->recipients}}">
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_distribution">Distribución del documento (separados por coma)</label>
                <input type="text" class="form-control" id="for_distribution" name="distribution"
                       value="{{$signature->distribution}}">
            </fieldset>

        </div>

        <button type="submit" class="btn btn-primary" @if($signature->signaturesFlows->where('status', 1)->count() > 0) disabled @endif >Guardar</button>
        <button type="submit" class="btn btn-danger float-right" form="delete_form">Eliminar</button>

    </form>

    <form method="POST" id="delete_form" action="{{route('documents.signatures.destroy', $signature)}}" enctype="multipart/form-data">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('custom_js')

@endsection
