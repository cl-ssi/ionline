@extends('layouts.mobile')

@section('title', 'Crear requerimiento')

@section('content')


<h4 class="mb-3">Derivando 
    @if($parte->id <> 0)
        parte <strong>{{ $parte->id }}</strong>
        @if($parte->files != null)
            @foreach($parte->files as $file)
                <a href="{{ route('documents.partes.download', $file->id) }}"
                    target="_blank" data-toggle="tooltip" data-placement="top"
                    data-original-title="{{ $file->name }}">
                    <i class="fas fa-paperclip"></i>
                </a>
            @endforeach
        @endif

    @endif
</h4>


<div class="form-row">
    <div class="col-md-8 col-12">
        @if($parte->files->first() != null)
            @foreach($parte->files as $file)
                <object type="application/pdf"
                        data="https://docs.google.com/gview?embedded=true&url={{ Storage::disk('gcs')->url($file->file) }}"
                        width="100%"
                        height="700">
                </object>
            @endforeach
        @endif
    </div>
    <div class="col-md-4 col-12">
        <form method="POST" class="form-horizontal" action="{{ route('requirements.store') }}" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <input type="hidden" class="form-control" id="for_parte_id" name="parte_id" value="{{$parte->id}}" >


            @livewire('requirements.requirement-receivers',['parte_id' => $parte->id])


            <div class="form-row">
                <fieldset class="form-group @if($parte->id <> 0) col-12 @else col @endif">
                    <label for="for_date">Asunto</label>
                    <textarea name="subject" id="for_subject" class="form-control" rows="2" required>{{ $parte->subject }}</textarea>
                </fieldset>
            </div>
            
            <div class="row">
                <fieldset class="form-group @if($parte->id <> 0) col-12 @else col @endif">
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

@section('custom_js')
  <script>

  </script>
@endsection
