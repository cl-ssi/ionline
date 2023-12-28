@extends('layouts.blank')

@section('title', 'Qrs')

@section('content')

    <style>
        .contenedor {
            position: relative;
        }

        .contenedor .qr-content {
            width: 150px;
            height: 140px;
            margin-right: 25px;
            display: inline-block;
            text-align: center; 
            line-height: 140px; 
            vertical-align: middle;
            position: relative;
        }

        .contenedor .qr-number {
            width: 100%;
            text-align: center;
            position: absolute;
            bottom: -40px; 
            font-size: 14px;
        }

        .contenedor .qr-code-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -30%);
        }

        .contenedor .logo {
            width: 50px;
            height: 50px;
            margin-top: -30px;
            position: absolute;
            left: 33%; 
        }

        .contenedor .circle-svg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        

        .contenedor .small-text {
            font-size: 6px; /* Ajusta el tamaño de la fuente según tus necesidades */
            text-align: center;
            margin-top: 50px; /* Ajusta el espacio entre el número y el texto */
            white-space: pre-line; /* Muestra el texto con saltos de línea */
        }

        .contenedor .whatsapp-number {
            font-size: 6px; 
            margin-top: -137px; 
            text-align: center;
        }

    </style>

    <div class="contenedor">
        @foreach($inventories as $inventory)
            <div class="qr-content">
                <div class="logo">
                    <img src="{{ asset('images/logo_pluma_' . auth()->user()->organizationalUnit->establishment->alias . '.png') }}" alt="Logo" style="width: 100%; height: 100%;">
                </div>
                <div class="qr-code-container">
                    {!! $inventory->qrSmall !!}
                </div>
                <div class="qr-number">{{ $inventory->number }}</div>
                <!-- SVG Circle -->
                <svg class="circle-svg" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50%" cy="50%" r="47%" stroke="black" fill="none" />
                </svg>
                <p class="small-text">En caso de extravío informar al</p>
                <div class="whatsapp-number">📞+56965887867</div>
            </div>

            @if($loop->iteration % 2 == 0)
                <br>
                <br>
            @endif
        @endforeach
    </div>

@endsection
