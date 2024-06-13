@extends('layouts.bt4.app')

@section('title', 'Configuración de hospedajes')

@section('content')

@include('welfare.nav')

    <h3>Configuración de hospedajes</h3>

    @livewire('hotel-booking.hotel-room-selecting')

@endsection

<!-- CSS Custom para el calendario -->
@section('custom_css')
<style media="screen">
    .dia_calendario {
        display: inline-block;
        border: solid 1px rgb(0, 0, 0, 0.125);
        border-radius: 0.25rem;
        width: 13.9%;
        /* width: 154px; */
        text-align: center;
        margin-bottom: 5px;
    }
</style>
@endsection

@section('custom_js')

@endsection
