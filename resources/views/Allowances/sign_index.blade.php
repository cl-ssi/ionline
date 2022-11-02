@extends('layouts.app')

@section('title', 'Gestión de Viáticos')

@section('content')

@include('allowances.partials.nav')

<h5><i class="fas fa-check-circle"></i> Gestión de viaticos</h5>

<br />
</div>

<!-- <div class="row"> -->
    <div class="col-sm">
        @livewire('allowances.search-allowances', [
            'index' => 'sign'
        ])
    </div>
<!-- </div> -->

@endsection

@section('custom_js')

@endsection