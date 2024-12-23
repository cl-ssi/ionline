@extends('layouts.bt5.app')

@section('title', 'Historial de documentos')

@section('content')

@include('documents.partials.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

<h3>Historial</h3>

<form method="GET" class="form-horizontal" action="{{ route('documents.index') }}">

    <div class="row g-2 mb-3">
        <fieldset class="form-group col-4 col-md-1">
            <label for="for_id">ID</label>
            <input type="text" class="form-control" id="for_id" name="id">
        </fieldset>

        <fieldset class="form-group col-8 col-md-2">
            <label for="for_type">Tipo</label>
            <select name="type_id" id="for_type_id" class="form-select">
                <option value=""></option>
                @foreach($types as $id => $type)
                <option value="{{ $id }}" {{ old('type_id') == $id ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_subject">Materia</label>
            <input type="text" class="form-control" id="for_subject" name="subject">
        </fieldset>

        <fieldset class="form-group col-4 col-md-1">
            <label for="for_number">Número</label>
            <input type="text" class="form-control" id="for_number" name="number">
        </fieldset>

        <fieldset class="form-group col-8 col-md-4">
            <label for="for_user_id">Usuario</label>
            @livewire('search-select-user')
        </fieldset>

        <fieldset class="form-group col-1 col-md-1">
            <label for="">&nbsp;</label>
            <button type="submit" class="btn btn-primary form-control">
                <i class="fas fa-search"></i>
            </button>
        </fieldset>

    </div>

    <fieldset class="form-check form-check-inline mb-3">
        <input class="form-check-input" name="file" type="checkbox" id="for_file">
        <label class="form-check-label" for="for_file">Pendiente</label>
    </fieldset>

</form>




<table class="table table-sm">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>N°</th>
            <th>Fecha</th>
            <th>Antec</th>
            <!--th>Resp</th-->
            <th>Materia</th>
            <th>De</th>
            <th>Para</th>
            <th class="small" width="70">Creador</th>
            <th nowrap></th>
            <th nowrap></th>
            <th nowrap></th>
            <th nowrap><i class="fas fa-signature"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach($ownDocuments as $doc)
        <tr class="small">
            <td>{{ $doc->id }}</td>
            <td>{{ optional($doc->type)->name }}</td>
            <td>
                @livewire('documents.enumerate',['document' => $doc])
            </td>
            <td nowrap>{{ $doc->date ? $doc->date->format('d-m-Y'): '' }}</td>
            <td>{{ $doc->antecedent }}</td>
            <!--td nowrap>{!! $doc->responsibleHtml !!}</td-->
            <td>
                @if($doc->reserved)
                    <i class="fas fa-user-secret"></i>
                @endif
                {{ $doc->subject }}
            </td>
            <td>{!! $doc->fromHtml !!}</td>
            <td>{!! $doc->forHtml !!}</td>
            <td class="small">
                @if($doc->user)
                    @if($doc->user->gravatar )
                        <img src="{{ $doc->user->gravatarUrl }}?s=40&d=mp&r=g" class="border rounded-circle" alt="{{ optional($doc->user)->tinyName }}" title="{{ optional($doc->user)->tinyName }}">
                    @else
                        {{ optional($doc->user)->tinyName }}
                    @endif
                @endif
                <br>
                {{ $doc->created_at }}
            </td>
            <td nowrap>
                @if(!$doc->file)
                    <a href="{{ route('documents.edit', $doc) }}" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-pen"></i></a>
                @endif

            </td>
            <td nowrap>
                <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-fw fa-file"></i></a>
            </td>
            <td nowrap>
                @if($doc->file)
                    <a href="{{ route('documents.download', $doc) }}" class="btn btn-sm btn-outline-danger" target="_blank">
                        <i class="fas fa-fw fa-file-pdf"></i>
                    </a>
                @else
                    <button class="btn btn-sm btn-outline-secondary" disabled>
                        <i class="fas fa-fw fa-file"></i>
                    </button>
                @endif
            </td>
            <td nowrap>
                @if($doc->file_to_sign_id === null)
                    <a href="{{ route('documents.sendForSignature', $doc) }}" class="btn btn-sm btn-outline-primary"  @if(!$doc->number) onclick="return confirm('Enviará a firmar un documento sin Numerar' ) @endif">
                        <span class="fas fa-fw fa-signature" aria-hidden="true" title="Enviar a firma"></span>
                    </a>
                @endif

                @if($doc->fileToSign)
                    @if($doc->fileToSign->hasSignedFlow)
                    <a href="{{ route('documents.signedDocumentPdf', $doc->id) }}" class="btn btn-sm @if($doc->fileToSign->hasAllFlowsSigned) btn-outline-success @else btn-outline-primary @endif" target="_blank">
                        <i class="fas fa-fw fa-file-contract"></i> </a>
                    @else
                        {{ $doc->fileToSign->signature_id }}
                    @endif
                @endif
            </td>
            @can('Documents: signatures and distribution v2')
            <td>
                @if(! isset($doc->signature))
                    <a href="{{ route('documents.sendForSign.v2', $doc) }}" class="btn btn-sm btn-outline-danger">
                        <span class="fas fa-fw fa-signature" aria-hidden="true" title="Enviar a firma al nuevo modulo"></span>
                    </a>
                @else
                    @if($doc->signature->isPending())
                        <a href="{{ route('v2.documents.show.file', $doc->signature) }}" class="btn btn-sm btn-outline-primary">
                            <span class="fas fa-fw fa-file" aria-hidden="true" title="Ver el documento solicitud #{{ $doc->signature->id }}"></span>
                        </a>
                    @endif

                    @if($doc->signature->isCompleted())
                        <a href="{{ route('v2.documents.show.signed.file', $doc->signature) }}" class="btn btn-sm btn-outline-success">
                            <span class="fas fa-fw fa-file" aria-hidden="true" title="Ver el documento firmado #{{ $doc->signature->id }}"></span>
                        </a>
                    @endif
                @endif
            </td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>


<hr>

<h3 class="mb-3">Documentos de la misma unidad organizacional</h3>

<table class="table table-sm">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>N°</th>
            <th>Fecha</th>
            <th>Antec</th>
            <!--th>Resp</th-->
            <th>Materia</th>
            <th>De</th>
            <th>Para</th>
            <th class="small" width="70">Creador</th>
            <th nowrap></th>
            <th nowrap></th>
            <th nowrap></th>
            <th nowrap></th>
        </tr>
    </thead>
    <tbody>
        @foreach($otherDocuments as $doc)
        <tr class="small">
            <td>{{ $doc->id }}</td>
            <td>{{ optional($doc->type)->name }}</td>
            <td>
               {{ $doc->number }}
            </td>
            <td nowrap>{{ $doc->date ? $doc->date->format('d-m-Y'): '' }}</td>
            <td>{{ $doc->antecedent }}</td>
            <!--td nowrap>{!! $doc->responsibleHtml !!}</td-->
            <td>{{ $doc->subject }}</td>
            <td>{!! $doc->fromHtml !!}</td>
            <td>{!! $doc->forHtml !!}</td>
            <td class="small">
                @if($doc->user)
                    @if($doc->user->gravatar )
                        <img src="{{ $doc->user->gravatarUrl }}?s=40&d=mp&r=g" class="border rounded-circle" alt="{{ optional($doc->user)->tinyName }}" title="{{ optional($doc->user)->tinyName }}">
                    @else
                        {{ optional($doc->user)->tinyName }}
                    @endif
                @endif
                <br>
                {{ $doc->created_at }}
            </td>
            <td nowrap>
                <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-file fa-lg"></i></a>
            </td>
            <td nowrap>
                @if($doc->file)
                <a href="{{ route('documents.download', $doc) }}" class="btn btn-sm btn-outline-danger" target="_blank">
                    <i class="fas fa-fw fa-file-pdf"></i>
                </a>
                @else
                <form method="POST" action="{{ route('documents.find')}}">
                    @csrf
                    <button name="id" value="{{ $doc->id }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-fw fa-upload"></i>
                    </button>
                </form>
                @endif
            </td>
            <td nowrap>
                @if($doc->file_to_sign_id === null)
                    <a href="{{ route('documents.sendForSignature', $doc) }}" class="btn btn-sm btn-outline-primary">
                        <span class="fas fa-fw fa-signature" aria-hidden="true" title="Enviar a firma"></span>
                    </a>
                @endif

                @if($doc->fileToSign && $doc->fileToSign->hasSignedFlow)
                    <a href="{{ route('documents.signedDocumentPdf', $doc->id) }}" class="btn btn-sm @if($doc->fileToSign->hasAllFlowsSigned) btn-outline-success @else btn-outline-primary @endif" target="_blank">
                    <span class="fas fa-fw fa-file-contract" aria-hidden="true"></span>
                </a>
                @endif
            </td>
            @can('Documents: signatures and distribution v2')
            <td>
                @if(! isset($doc->signature))
                    <a href="{{ route('documents.sendForSign.v2', $doc) }}" class="btn btn-sm btn-outline-danger">
                        <span class="fas fa-fw fa-signature" aria-hidden="true" title="Enviar a firma al nuevo modulo"></span>
                    </a>
                @else
                    @if($doc->signature->isPending())
                        <a href="{{ route('v2.documents.show.file', $doc->signature) }}" class="btn btn-sm btn-outline-primary">
                            <span class="fas fa-fw fa-file" aria-hidden="true" title="Ver el documento solicitud #{{ $doc->signature->id }}"></span>
                        </a>
                    @endif

                    @if($doc->signature->isCompleted())
                        <a href="{{ route('v2.documents.show.signed.file', $doc->signature) }}" class="btn btn-sm btn-outline-success">
                            <span class="fas fa-fw fa-file" aria-hidden="true" title="Ver el documento firmado #{{ $doc->signature->id }}"></span>
                        </a>
                    @endif
                @endif
            </td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>

{{ $otherDocuments->appends(request()->query())->links() }}

@endsection

@section('custom_js')

<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

@endsection
