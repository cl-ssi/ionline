@extends('layouts.app')

@section('title', 'Partes')

@section('content')

@include('documents.partes.partials.nav')

<h3>Documento N° {{ $parte->id }} <small>( N° origen: {{ $parte->number }} - Tipo:  {{ $parte->type }} ) </small></h3>
Materia: {{ $parte->subject }}
@if($parte->important)
     <span class="text-danger">Importante <i class="fas fa-exclamation"></i></span>
@endif
<br>


@if($parte->events()->count() == 1 AND $parte->events()->first()->user_id == Auth::user()->id)
    @include('documents.partes.partials.reply')
@endif

<br>
@if($files->count()>0)
<div class="card">
  <div class="card-header">
    documentos adjuntos
  </div>
  <ul class="list-group list-group-flush">
    @foreach($files as $file)
    <small><a href="{{ route('documents.partes.download', $file->id) }}"><i class="fas fa-paperclip"></i> {{ $file->name }} </a></small>
    @endforeach
  </ul>
</div>
@endif

@php /*
<br>
<ul>
    @foreach($leafs as $leaf)
    <li class="mb-3">
        <ul>
            @foreach($leaf->ancestor() as $event)
                @if($event->active)
                <li>
                    @include('documents.partes.partials.reply')
                </li>
                @endif
                <li>
                @switch($event->action)
                    @case('Ingresado')
                        <i class="fas fa-inbox"></i>
                        @break
                    @case('Recepcionado')
                        <i class="fas fa-check"></i>
                        @break
                    @case('Derivado')
                        <i class="fas fa-paper-plane"></i>
                        @break
                    @case('Respondido')
                        <i class="fas fa-reply"></i>
                        @break
                    @case('Comentado')
                        <i class="fas fa-comment"></i>
                        @break
                    @case('Archivado')
                        <i class="fas fa-archive"></i>
                        @break
                    @case('Anulado')
                        <i class="fas fa-ban"></i>
                        @break
                @endswitch

                    {{ $event->created_at }} - {{ $event->action }}
                    en <strong>{{ $event->organizationalUnit->name }}</strong>
                    por <span class="text-success">{{ $event->user->getFullNameAttribute() }}</span>
                    @if($event->comment)
                        <span class="text-primary">{{ $event->comment }} </span>
                    @endif

                </li>
            @endforeach
        </ul>
    </li>
    @endforeach
</ul>
*/
@endphp

@endsection
