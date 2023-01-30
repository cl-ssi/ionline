@extends('layouts.mobile')

@section('title', 'Crear requerimiento')

@section('content')


<h4 class="mb-3">Derivando parte <strong>{{ $parte->id }}</strong></h4>

@if($parte->files != null)
    @foreach($parte->files as $file)
        <embed src="https://drive.google.com/viewerng/viewer?embedded=true&url={{ Storage::disk('gcs')->url($file->file) }}" width="400" height="500">
    @endforeach
@endif

<br>

<embed src="https://drive.google.com/viewerng/viewer?embedded=true&url=https://storage.googleapis.com/saludiquique-storage/ionline/signatures/original/57260.pdf" width="400" height="500">

<div class="form-row">
    <div class="col-md-8 col-12 d-none d-sm-block">
        @if($parte->files->first() != null)
            @foreach($parte->files as $file)
                <object type="application/pdf"
                        data="https://docs.google.com/gview?embedded=true&url={{ Storage::disk('gcs')->url($file->file) }}"
                        width="100%"
                        height="850">
                </object>
            @endforeach
        @endif
    </div>
    <div class="col-md-4 col-12">
        <form method="POST" class="form-horizontal" action="{{ route('requirements.store') }}" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <input type="hidden" class="form-control" id="for_parte_id" name="parte_id" value="{{$parte->id}}" >

            <div class="form-row">
                <fieldset class="form-group col-12">
                    <label for="for_organizationalUnit">Establecimiento / Unidad Organizacional</label>
                    @livewire('select-organizational-unit', [
                        'establishment_id' => auth()->user()->organizationalUnit->establishment->id,

                    ])
                </fieldset>
            </div>

            {{-- @livewire('requirements.requirement-receivers',['parte_id' => $parte->id]) --}}


            <div class="form-row">
                <fieldset class="form-group col-12">
                    <label for="for_date">Asunto</label>
                    <textarea name="subject" id="for_subject" class="form-control" rows="2" required>{{ $parte->subject }}</textarea>
                </fieldset>
            </div>
            
            <div class="row">
                <fieldset class="form-group col-12">
                    <label for="for_date">Requerimiento</label>
                    <textarea class="form-control" id="for_body" name="body" rows="4" required></textarea>
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-6">
                    <label for="for_origin">Tipo</label>
                    <select class="form-control" name="priority" id="priority" >
                        <option>Normal</option>
                        <option>Urgente</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-6">
                    <label for="for_origin">Fecha límite</label>
                    <input type="datetime-local" class="form-control" id="for_limit_at"
                           name="limit_at">
                </fieldset>
            </div>

            <button type="submit" class="btn btn-primary form-control">Derivar y ver siguiente (4 pendientes)</button>

        </form>
    </div>
</div>



@endsection

@section('custom_css')
<link href="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.3.122/web/pdf_viewer.min.css" rel="stylesheet"></link>
@endsection

@section('custom_js')
<script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.3.122/build/pdf.min.js"></script>
@endsection
