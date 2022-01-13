@extends('layouts.app')

@section('title', 'Logs')

@section('content')

<style>
    pre {
    white-space: pre-wrap;
}
</style>

<h3 class="mb-3"> 
    <a href="{{ route('parameters.logs.destroy', $log) }}" class="ml-3 mr-3">
        <i class="fas fa-trash text-{{ $log->color }}"></i>
    </a>
    {{ $log->level_name }}  {{ $log->id }}
    <a href="{{ route('parameters.logs.index') }}" class="ml-3">
        <i class="fas fa-list"></i>
    </a>
</h3>

<a target="_blank" href="{{ $log->uri }}">[{{ $log->uri }}]</a>

<pre>
    {{ print_r($log->toArray()) }} {{ optional($log->user)->fullName }}
</pre>

@endsection

@section('custom_js')

@endsection
