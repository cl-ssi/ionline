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
                    <option value="Acta" @if($signature->document_type == 'Acta') selected @endif>
                        Acta
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
                <a href="{{route('documents.signatures.showPdf', $signature->signaturesFileDocument)}}"
                   target="_blank" data-toggle="tooltip" data-placement="top"
                   data-original-title="">Documento <i
                        class="fas fa-paperclip"></i>&nbsp
                </a>
            </fieldset>

            <fieldset class="form-group col">
                <label for="for_annexed">Anexos</label>
                <input type="file" class="form-control" id="for_annexed" name="annexed[]" multiple>

                @foreach($signature->signaturesFiles->where('file_type', 'anexo') as $anexo)
                    <a href="{{route('documents.signatures.showPdfAnexo', $anexo)}}"
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


        @if($signature->hasSignedOrRejectedFlow)
            <button type="button" class="btn btn-primary" @if($signature->responsable_id != Auth::id()) disabled @endif
                data-toggle="modal"
                data-target="#editSignature"
            >Guardar
            </button>

            <div class="modal fade" id="editSignature" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Editar solicitud</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-12">
                                   <span>Esta solicitud ya tiene firmas o rechazo. Los usuarios que hayan firmado deberán firmar nuevamente.</span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar
                            </button>

                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-edit"></i> Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <button type="submit" class="btn btn-primary"
                    @if($signature->responsable_id != Auth::id()) disabled @endif >Guardar
            </button>
        @endif

        <button type="submit" class="btn btn-danger float-right" @if($signature->responsable_id != Auth::id()) disabled
                @endif form="delete_form">Eliminar
        </button>

    </form>

    <form method="POST" id="delete_form" action="{{route('documents.signatures.destroy', $signature)}}"
          enctype="multipart/form-data">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('custom_js')

@endsection
