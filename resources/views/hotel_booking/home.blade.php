@extends('layouts.bt4.app')

@section('title', 'Reserva de Cabañas')

@section('content')

@include('welfare.nav')

<div class="jumbotron mt-3">

    <div class="d-flex justify-content-end mb-3">
        <a href="https://docs.google.com/document/d/1UzWY4S5DXlgnYAhbtNhgGiYmP3R9UyxJ/edit?usp=sharing&ouid=100875180090664492720&rtpof=true&sd=true" target="_blank" class="btn btn-info">Manual de Usuario</a>
    </div>

    <h1 class="display-6">Módulo de Reserva de Cabañas </h1>
    <p class="lead">En este módulo podrá realizar reservas de los espacios que tenemos para nuestros beneficiarios. </p>

    <form method="GET" class="form-horizontal" action="{{ route('hotel_booking.search_booking') }}">
        <div class="form-row">

            @cannot('welfare: hotel booking administrator')
                @php
                    $today = \Carbon\Carbon::now();
                    // Si es el día 15 o posterior, permite hasta el final del próximo mes
                    $maxDate = $today->day >= 15 
                        ? $today->copy()->endOfMonth()->addMonth()->endOfMonth()->toDateString() 
                        : $today->copy()->endOfMonth()->toDateString();
                @endphp
            @endcannot

            <fieldset class="form-group col-3">
                <label for="for_hotel_id">Entrando el</label>
                <input 
                    type="date" 
                    class="form-control" 
                    required 
                    name="start_date" 
                    @if($request->start_date) 
                        value="{{ $request->start_date }}" 
                    @endif
                    @cannot('welfare: hotel booking administrator')
                        min="{{ $today->toDateString() }}" 
                        max="{{ $maxDate }}"
                    @endcannot
                >
            </fieldset>

            <fieldset class="form-group col-3">
                <label for="for_hotel_id">Saliendo el</label>
                <input 
                    type="date" 
                    class="form-control" 
                    required 
                    name="end_date" 
                    @if($request->end_date) 
                        value="{{ $request->end_date }}" 
                    @endif
                    @cannot('welfare: hotel booking administrator')
                        min="{{ $today->toDateString() }}" 
                        max="{{ $maxDate }}"
                    @endcannot
                >
            </fieldset>


            <fieldset class="form-group col-1">
                <label for="for_hotel_id"><br></label>
                <button type="submit" class="btn btn-primary form-control"><i class="fas fa-search"></i></button>
            </fieldset>

        </div>
    </form>
</div>


@if(!$request->start_date)
    @foreach($hotels as $hotel)

    <div class="card text-center">
        <div class="card-header">
            {{$hotel->commune->name}}
        </div>
        <div class="card-body">
            <h5 class="card-title">{{$hotel->name}}</h5>
            <p class="card-text">{{$hotel->description}}</p>
            <div class="grid-container">
                @foreach($hotel->images as $key => $image) 
                    <div class="item{{$key}}">
                        <img src="data:image/png;base64, {{ $image->base64image() }}" class="img-thumbnail">
                    </div>    
                @endforeach
            </div>
            <br>
            
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><h5>Hospadajes disponibles.</h5></li>
                @foreach($hotel->rooms as $key => $room) 
                    
                        <li class="list-group-item">
                            {{$room->identifier}} - <b>{{$room->max_days_avaliable}}</b> días como máximo - Capacidad <b>{{$room->single_bed + ($room->double_bed * 2)}}</b> huespedes.
                            
                            @if($room->bookingConfigurations->count() > 0)
                            <a href="#" data-toggle="modal" data-target="#exampleModal{{$room->id}}">
                                <span class='badge badge-warning' >
                                    Ver disponibilidad
                                </span>
                            </a>
                            @else
                                <span class='badge badge-danger' >
                                    No disponible
                                </span>
                            @endif
                                
                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg" data-backdrop="true" id="exampleModal{{$room->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @livewire('hotel-booking.calendar',['room' => $room])
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                            </div>
                            
                        </li>
                   
                @endforeach
            </ul>
        </div>
        <div class="card-footer text-muted">
            @foreach($hotel->rooms as $room)
                @foreach($room->services as $service)
                    <span class='badge badge-primary'>
                        <i class="fas fa-tag"></i> {{ $service->name }}
                    </span>
                @endforeach
            @endforeach
        </div>
    </div>
    <br>

    @endforeach
@else
    <div class="alert alert-info" role="alert">
        Hemos encontrado <b>{{count($found_rooms)}}</b> hospedajes para tu búsqueda!
    </div>

    @foreach($found_rooms as $room)

        <div class="card text-left">
            <div class="card-header">
                <small>Ingresando el</small> <b>{{$request->start_date}}</b>, <small>saliendo el </small> <b>{{$request->end_date}}</b>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{$room->hotel->commune->name}} - <b>{{$room->hotel->name}}</b></h5>
                <p class="card-text">
                    {{$room->description}}<br>
                </p>
                <p><small>
                Capacidad <b>{{$room->single_bed + ($room->double_bed * 2)}}</b> huespedes <i>@if($room->single_bed!=0) [<b>{{$room->single_bed}}</b> cama(s) de una plaza] @endif</i>
                                                                                            <i>@if($room->double_bed!=0) [<b>{{$room->double_bed}}</b> cama(s) de dos plazas] @endif</i>
                </small>

                <div class="grid-container">
                    @foreach($room->images as $key => $image) 
                        <div class="item{{$key}}">
                            <img src="data:image/png;base64, {{ $image->base64image() }}" class="img-thumbnail">
                        </div>    
                    @endforeach
                </div>

                </p>
                <!-- <a href="#" class="btn btn-primary">Reservar</a> -->
                @livewire('hotel-booking.book-room',['room' => $room, 'start_date' => $request->start_date, 'end_date' => $request->end_date])
            </div>
            <div class="card-footer text-muted">
                <small>Servicios disponibles en el hospedaje: </small>
                @foreach($room->services as $service)
                    <span class='badge badge-primary'>
                        <i class="fas fa-tag"></i> {{ $service->name }}
                    </span>
                @endforeach
            </div>
        </div>
        <br>

    @endforeach
@endif

<div class="tooltip">Hover over me
    <span class="tooltiptext">Tooltip text</span>
</div>

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

    /* .start_style {
        background: linear-gradient(
            to right,
            white 0%,
            white 50%,
            LightSkyBlue 50%,
            LightSkyBlue 100%
        );
    } */

    /* ok */
    .middle_style {
        background: LightSkyBlue;
    }

    .end_style {
        background: linear-gradient(
            to right,
            LightSkyBlue 0%,
            LightSkyBlue 50%,
            white 50%,
            white 100%
        );
    }

    .red_start_style {
        background: linear-gradient(
            to right,
            #A3E4D7 0%,
            #A3E4D7 50%,
            #F1948A 50%,
            #F1948A 100%
        );
    }

    /* ok */
    .red_middle_style {
        background: #F1948A;
    }

    .red_end_style {
        background: linear-gradient(
            to right,
            #F1948A 0%,
            #F1948A 50%,
            #A3E4D7 50%,
            #A3E4D7 100%
        );
    }

    /* ok */
    .not_available_style {
        background: linear-gradient(
            to right,
            #FADBD8  0%,
            #FADBD8  50%,
            #FADBD8  50%,
            #FADBD8  100%
        );
    }

    /* .red_blue_style {
        background: linear-gradient(
            to right,
            #F1948A 0%,
            #F1948A 50%,
            LightSkyBlue 50%,
            LightSkyBlue 100%
        );
    } */

    /* ok */
    .active_style {
        background: linear-gradient(
            to right,
            #A3E4D7 0%,
            #A3E4D7 50%,
            #A3E4D7 50%,
            #A3E4D7 100%
        );
    }


    /* mosaico */

    .item1 {
    grid-area: area1;
    }

    .item4 {
    height: 100px;
    }


    .item5 {
    grid-area: area5;
    }


    .grid-container {
    display: grid;
    grid-template-areas:
        'area1 . .'
        'area1 area4 area5'
        'area1 . area5'
        '. . area5';
    grid-gap: 2px;
    }

    .grid-container > div {
    background-color: #f7f7f7;
    text-align: center;
    padding: 10px;
    }

</style>
@endsection

@section('custom_js')

<script>

// al presionar boton pone scroll de forma automática en div de calendario
$(document).ready(function() {
    $('.reservar').on('click', function (e) {
        var value = $(this).data("value");
        var text1 = "#";
        var div = text1.concat(String(value));
        setTimeout(function(){
            $('html, body').animate({   
                scrollTop: $(div).offset().top 
            }, 150);
        }, 1000);
        console.log(div);
    });

    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })
});    

// permite el funcionamiento de los tooltip cuando se cambie el mes de busqueda
document.addEventListener("DOMContentLoaded", () => {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    Livewire.hook('message.processed', (message, component) => {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    })
});

document.getElementById('payment_type_select').addEventListener('change', function() {
    var selectedOption = this.value;
    if (selectedOption == 'Descuento por planilla - 1 cuota' || selectedOption == 'Descuento por planilla - 2 cuotas' || selectedOption == 'Descuento por planilla - 3 cuotas') {
        var confirmation = confirm('La confirmación de su reserva estará sujeta a disponibilidad de alcance del 15% de su liquidación de sueldo.');
        if (!confirmation) {
            this.value = '';
        }
    }
});

</script>

@endsection
