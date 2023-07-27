@extends('layouts.app')

@section('title', 'Mis reservas')

@section('content')

@include('hotel_booking.partials.nav')

<h3 class="inline">Mis reservas</h3>

<br>
<br>

<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
            <th>Hotel</th>
            <th>Hospedaje</th>
            @canany(['HotelBooking: Administrador'])
                <th>Reservante</th>
            @endcanany
			<th>Entrada</th>
            <th>Salida</th>
            <th>Estado</th>
			<th></th>
            <th></th>
		</tr>
	</thead>
	<tbody>
	@foreach($roomBookings as $roomBooking)
        @if(!$roomBooking->status)
		<tr style="background-color:#E3B4B4" class="sub-container">
        @endif
            <td nowrap>{{ $roomBooking->room->hotel->name}}</td>
            <td nowrap>{{ $roomBooking->room->identifier}}</td>
            @canany(['HotelBooking: Administrador'])
                <td>{{ $roomBooking->user->getShortNameAttribute() }}</td>
            @endcanany
			<td nowrap>{{ $roomBooking->start_date->format('Y-m-d') }}</td>
            <td nowrap>{{ $roomBooking->end_date->format('Y-m-d') }}</td>
            <td nowrap>
                {{ $roomBooking->status }}</td>
            </td>
            <td nowrap>
                @if($roomBooking->status) 
                <form method="POST" class="form-horizontal" action="{{ route('hotel_booking.booking_cancelation', $roomBooking) }}">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('¿Está seguro que desea cancelar la reserva?')">
                            Cancelar
                        </button>
                </form> 
                @else 
                    Cancelada 
                @endif
            </td>
            <td><button type="button" class="btn btn-success exploder">
                <span class="glyphicon glyphicon-search"></span>
                </button>
            </td>
		</tr>
        <tr class="explode hide">
            <td colspan="4" style="display: none;">
                @include('partials.audit', ['audits' => $roomBooking->audits()] )
            </td>
        </tr>
	@endforeach
	</tbody>
</table>

{{$roomBookings->appends(Request::input())->links()}}

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
</script>

@endsection
