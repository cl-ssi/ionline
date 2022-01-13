@extends('layouts.app')

@section('title', 'Logs')

@section('content')

@include('parameters.nav')

<style>
    pre {
    white-space: pre-wrap;
}
</style>

<h3 class="mb-3">Logs</h3>

<table class="table table-sm">
    <tbody>
        @foreach($logs as $log)
        <tr>
            <th class="table-{{ $log->color }}">
                <!-- <a href="{{ route('parameters.logs.edit', $log) }}">
                    <i class="fas fa-edit"></i>
                </a> -->
                <a href="{{ route('parameters.logs.destroy', $log) }}" class="ml-3">
                    <i class="fas fa-trash text-{{ $log->color }}"></i>
                </a>
                <span class="ml-3"> {{ $log->level_name }} </span>
            </th>
        </tr>
        <tr>
            <td>
                <pre>
                    {{ print_r($log->toArray()) }} {{ optional($log->user)->fullName }}
                </pre>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $logs->links() }}

@endsection

@section('custom_js')

@endsection
