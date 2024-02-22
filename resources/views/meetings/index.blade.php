@extends('layouts.bt5.app')

@section('title', 'Reuniones')

@section('content')

@include('meetings.partials.nav')

<h5><i class="fas fa-file"></i> Mis reuniones</h5>
<p>Incluye Reuniones de mi Unidad Organizacional: <b>{{ auth()->user()->organizationalUnit->name }}</p>

</div>

<div class="col-sm">
    {{--
    @livewire('allowances.search-allowances', [
        'index' => 'own'
    ])
    --}}
</div>


@endsection

@section('custom_js')

@endsection