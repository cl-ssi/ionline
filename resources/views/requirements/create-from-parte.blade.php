@extends('layouts.bt4.mobile')

@section('title', 'Crear requerimiento')

@section('content')

@include('documents.partes.partials.nav')

<h4 class="mb-3">
    @if($parte) Derivando parte <strong>{{ $parte->correlative }}</strong>
    <span class="badge badge-success">
        Pendientes por derivar: {{ $totalPending }}
    </span><br>
    <small>Origen: {{$parte->origin}}</small><br>
    <small>F.Ingreso: {{$parte->entered_at}}</small><br>
    @endif
</h4>

<br>

@if($parte)
<div class="form-row">
    <div class="col-12 col-md-8">
    @if($parte->files != null)
        @foreach($parte->files as $file)
            <embed src="https://drive.google.com/viewerng/viewer?embedded=true&url={{ Storage::url($file->storage_path) }}" width="100%" height="700">
        @endforeach
    @endif
    </div>
    <div class="col-md-4 col-12">
        <form method="POST" class="form-horizontal" action="{{ route('requirements.directorStore') }}" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <input type="hidden" class="form-control" id="for_parte_id" name="parte_id" value="{{$parte->id}}" >

            <div class="form-row">
                <fieldset class="form-group col-12">
                    <label for="for_organizationalUnit">Establecimiento / Unidad Organizacional</label>
                    {{-- // FIXME: el emitToListener apunt a un metodo selectUser ? --}}
                    @livewire('select-organizational-unit', [
                        'establishment_id' => auth()->user()->organizationalUnit->establishment->id,
                        'mobile' => true,
                        'selectpicker' => false,
                        'emitToListener' => 'selectUser',
                        'selected_id' => 'to_ou_id',
                    ])
                </fieldset>
            </div>

            @livewire('select-user')

            <div class="form-row">
                <fieldset class="form-group col-12">
                    <label for="for_date">Asunto</label>
                    <textarea name="subject" id="for_subject" class="form-control" rows="3" required>{{ $parte->subject }}</textarea>
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
                    <label for="for_priority">Prioridad</label>
                    <select class="form-control" name="priority" id="priority" >
                        <option>Normal</option>
                        <option>Urgente</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-6">
                    <label for="for_limit_at">Fecha límite</label>
                    <input type="datetime-local" class="form-control" id="for_limit_at"
                           name="limit_at">
                </fieldset>
            </div>

            <div class="form-row">
                <div class="col-2">
                    <a @if($previous) href="{{ route('requirements.createFromParte', $previous) }}" @endif>
                        <button type="button" class="btn btn-primary form-control" @if(!$previous) disabled @endif>
                            <i class="fas fa-arrow-circle-left"></i>
                        </button>
                    </a>
                </div>
                <div class="col-8">
                    <button type="submit" id="submit" class="btn btn-success form-control">Derivar ({{ $totalPending }} pendientes)</button>
                </div>
                <div class="col-2">
                    <a @if($next) href="{{ route('requirements.createFromParte', $next) }}" @endif>
                        <button type="button" class="btn btn-primary form-control" @if(!$next) disabled @endif>
                            <i class="fas fa-arrow-circle-right"></i>
                        </button>
                    </a>
                </div>
            </div>

        </form>
    </div>
</div>
@endif

@endsection

@section('custom_css')

@endsection

@section('custom_js')
<script>

    $(document).ready(function(){
        
        $("#submit").click(function(){
            // //Attempt to get the element using document.getElementById
            // const name = form.querySelector("input[name='users']");
            // console.log(name);

            // var element = document.getElementsByName("users");
            // console.log(element);

            // //If it isn't "undefined" and it isn't "null", then it exists.
            // if(typeof(element) != 'undefined' && element != null){
            //     // alert('Element exists!');
            // } else{
            //     alert("Debe ingresar por lo menos un usuario a quien crear el requerimiento.");
            //     return false;
            // }

            if($('.users').val() == undefined){
                alert("Debe ingresar por lo menos un usuario a quien crear el requerimiento.");
                return false;
            }

        });
        
    });

</script>

@endsection
