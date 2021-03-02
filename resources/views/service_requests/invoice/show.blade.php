@extends('layouts.guest')

@section('title', 'Boleta de Honorario')

@section('content')

@if(empty($sr))

<div class="alert alert-danger">
        <h4 class="alert-heading">No Posee Solicitudes de Pago de Honorario con este RUT.</h4>
</div>

@else
Si Existe Boleta de Honorario


@endif


@endsection

@section('custom_js')

@endsection