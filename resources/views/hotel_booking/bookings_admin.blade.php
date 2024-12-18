@extends('layouts.bt4.app')

@section('title', 'Gestor de reservas')

@section('content')

@include('welfare.nav')

<h3 class="inline">Gestor de reservas</h3>

<form method="GET" class="form-horizontal" action="{{ route('hotel_booking.booking_admin') }}">

    @livewire('hotel-booking.hotel-room-selecting-simple',['room' => $room])

</form>

@if($roomBookings)

<form method="GET" class="form-horizontal" action="{{ route('hotel_booking.booking_admin') }}" id="filter-form">
    @foreach(request()->except('status', 'funcionario') as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="status">Estado de la Reserva</label>
            <select id="status" name="status" class="form-control">
                <option value="Todos" {{ request('status', 'Reservado') == 'Todos' ? 'selected' : '' }}>Todos</option>
                <option value="Reservado" {{ request('status', 'Reservado') == 'Reservado' ? 'selected' : '' }}>Reservado</option>
                <option value="Confirmado" {{ request('status', 'Reservado') == 'Confirmado' ? 'selected' : '' }}>Confirmado</option>
                <option value="Cancelado" {{ request('status', 'Reservado') == 'Cancelado' ? 'selected' : '' }}>Anulado</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="funcionario">Funcionario</label>
            <input type="text" id="funcionario" name="funcionario" value="{{ request('funcionario', '') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <label for="funcionario"><br></label>
            <button type="submit" class="btn btn-primary form-control">Filtrar</button>
        </div>
    </div>
</form>

@endif

<hr>

@if($roomBookings)

    <table class="table table-striped table-sm table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Recinto</th>
                <th>Hospedaje</th>
                <th>Reservante</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Estado</th>
                <th>T.Pago</th>
                <th style="width: 10%"></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($roomBookings as $roomBooking)
                @if(!$roomBooking->status)
                <tr style="background-color:#E3B4B4" class="sub-container">
                @endif
                    <td nowrap>{{ $roomBooking->id}}</td>
                    <td nowrap>{{ $roomBooking->room->hotel->name}}</td>
                    <td nowrap>{{ $roomBooking->room->identifier}}</td>
                    <td nowrap>@if($roomBooking->user) {{ $roomBooking->user->shortName }} @endif</td>
                    <td nowrap>{{ $roomBooking->start_date->format('Y-m-d') }}</td>
                    <td nowrap>{{ $roomBooking->end_date->format('Y-m-d') }}</td>
                    <td nowrap>
                        {{ $roomBooking->status != "Cancelado" ? $roomBooking->status : "Anulado" }}
                    </td>
                    <td nowrap style="display: flex; flex-direction: row; align-items: center; gap: 5px;">
                        <!-- {{ $roomBooking->payment_type }} -->
                        @if($roomBooking->status == "Reservado")
                            @livewire('hotel-booking.change-payment-type', ['roomBooking' => $roomBooking])
                        @else
                            {{ $roomBooking->payment_type }}
                        @endif

                        @if($roomBooking->payment_type == "Transferencia")
                            @if($roomBooking->files->count() != 0)
                                @foreach($roomBooking->files as $key => $file) 
                                    <a href="{{ route('hotel_booking.download', $file->id) }}" target="_blank">
                                        <i class="fas fa-paperclip"></i>
                                    </a>
                                @endforeach
                            @endif
                            <button name="id" class="btn btn-sm btn-outline-secondary" id="buttonfile{{$roomBooking->id}}">
                                <span class="fas fa-upload" aria-hidden="true"></span>
                            </button>
                        @endif
                    </td>
                    <td nowrap>
                        @if($roomBooking->status == "Reservado")
                            <div class="d-inline-flex">
                                <form method="POST" class="form-horizontal" action="{{ route('hotel_booking.booking_confirmation', $roomBooking) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                        <button class="btn btn-outline-success" type="submit"><i class="fa fa-check" aria-hidden="true"></i></button>
                                </form>
                                @livewire('hotel-booking.booking-cancelation',['roomBooking' => $roomBooking])
                            </div>
                        @endif
                        @if($roomBooking->status == "Confirmado")
                            <div class="d-inline-flex">
                                <button class="btn btn-success" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                                @livewire('hotel-booking.booking-cancelation',['roomBooking' => $roomBooking])
                            </div>
                        @endif
                        @if($roomBooking->status == "Cancelado")
                            <form method="POST" class="form-horizontal" action="{{ route('hotel_booking.booking_confirmation', $roomBooking) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                    <button class="btn btn-outline-success" type="submit"><i class="fa fa-check" aria-hidden="true"></i></button>
                            </form>
                            <button class="btn btn-danger" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                        @endif
                    </td>
                    <td>
                        <a href="#" class="exploder">
                            <span class="fa fa-info-circle exploder" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
                @if($roomBooking->status == "Cancelado" && $roomBooking->cancelation_observation)
                    <tr>
                        <td colspan="10" style="text-align: right;">
                            Motivo anulación: <b>{{$roomBooking->cancelation_observation}}</b>
                        </td>
                    </tr>       
                @endif
                <tr class="explode hide">
                    <td colspan="4" style="display: none;">
                        @include('partials.audit', ['audits' => $roomBooking->audits()] )
                    </td>
                </tr>
                <tr style="display: none;" id="fila{{$roomBooking->id}}">
                    <td colspan="9" style="background-color:white" >
                        @livewire('hotel-booking.upload-file',['roomBooking' => $roomBooking])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

{{$roomBookings->appends(Request::input())->links()}}

@endif

@if($room && in_array('Confirmado', request('status', [])))
    <hr><br>
    <h3>Reservas confirmadas</h3>
    @livewire('hotel-booking.calendar', ['room' => $room])
@endif

@endsection

@section('custom_js')

<script>
$(".exploder").click(function(){
  $(this).toggleClass("btn-success btn-danger");
  
  $(this).children("span").toggleClass("glyphicon-search glyphicon-zoom-out");  
  
  $(this).closest("tr").next("tr").toggleClass("hide");
  
  if($(this).closest("tr").next("tr").hasClass("hide")){
    $(this).closest("tr").next("tr").children("td").slideUp();
  }
  else{
    $(this).closest("tr").next("tr").children("td").slideDown(350);
  }
});

$(".uploadfilebutton").click(function(){
  $(this).toggleClass("btn-success btn-danger");
  
  $(this).children("span").toggleClass("glyphicon-search glyphicon-zoom-out");  
  
  $(this).closest("tr").next("tr").toggleClass("hide");
  
  if($(this).closest("tr").next("tr").hasClass("hide")){
    $(this).closest("tr").next("tr").children("td").slideUp();
  }
  else{
    $(this).closest("tr").next("tr").children("td").slideDown(350);
  }
});

@if($roomBookings)
    @foreach($roomBookings as $roomBooking)
        @if($roomBooking->payment_type == "Transferencia")
            @if($roomBooking->files)
                $("#buttonfile{{$roomBooking->id}}").click(function(){
                    $("#fila{{$roomBooking->id}}").toggle();
                });
            @endif
        @endif
    @endforeach
@endif

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


</script>

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
