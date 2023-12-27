@extends('layouts.blank')

@section('title', 'Qrs')

@section('content')

    <style>
        .contenedor {
            height: 150px;
            position: relative;
        }

        .contenedor div {
            display: inline-block;
            width: {{ $width }}px;
            height: {{ $height }}px;
            border: 1px solid gray;
            margin-right: {{ $margin }}px;
        }
    </style>

    <div class="contenedor">
        <div>QR 1</div>
        <div>QR 2</div>
    </div>


@endsection
