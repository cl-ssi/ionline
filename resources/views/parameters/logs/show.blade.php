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

<table class="table table-sm">
    <tr><td><b>[user_id] = </b>{{ $log->user_id }} - {{ optional($log->user)->fullName }}</td></tr>
    <tr><td><b>[uri] = </b> <a target="_blank" href="{{ $log->uri }}">{{ $log->uri }}</a></td></tr>
    <tr><td><b>[message] = </b>{{ $log->message }}</td></tr>
    <tr><td><b>[formatted] = </b><pre>{{ $log->formatted }}</pre></td></tr>
    <tr><td><b>[context] = </b><pre>{{ $log->context }}</pre></td></tr>
    <tr><td><b>[level] = </b>{{ $log->level }}</td></tr>
    <tr><td><b>[level_name] = </b>{{ $log->level_name }}</td></tr>
    <tr><td><b>[channel] = </b>{{ $log->channel }}</td></tr>
    <tr><td><b>[extra] = </b>{{ $log->extra }}</td></tr>
    <tr><td><b>[remote_addr] = </b>{{ $log->remote_addr }}</td></tr>
    <tr><td><b>[user_agent] = </b>{{ $log->user_agent }}</td></tr>
    <tr><td><b>[record_datetime] = </b>{{ $log->record_datetime }}</td></tr>
    <tr><td><b>[created_at] = </b>{{ $log->created_at }}</td></tr>
</table>

@endsection

@section('custom_js')

@endsection
