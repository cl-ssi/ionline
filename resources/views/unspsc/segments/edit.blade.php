@extends('layouts.app')

@section('title', 'Editar Segmento')

@section('content')

@livewire('unspsc.segment.segment-edit', ['segment' => $segment])

@endsection
