@extends('layouts.bt4.app')

@section('title', 'Mis reservas')

@section('content')

@include('welfare.nav')

<div class="alert alert-warning" role="alert">
  <b>PARA DEPOSITAR O TRANSFERIR AL SERVICIO DE BIENESTAR</b><br><br>

  <li>Banco: BANCO ESTADO</li>
  <li>Cuenta corriente: 01309099679</li>
  <li>Rut: 61.606.100-3</li>
  <li>Nombre: Servicio de Salud Iquique</li>
  <li>Correo: contador.bienestar@redsalud.gob.cl</li>
</div>

<h3 class="inline">Mis reservas</h3>

<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
            <th>ID</th>
            <th>Recinto</th>
            <th>Hospedaje</th>
			<th>Entrada</th>
            <th>Salida</th>
            <th>Valor</th>
            <th>Estado</th>
            <th>T.Pago</th>
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
			<td nowrap>{{ $roomBooking->start_date->format('Y-m-d') }}</td>
            <td nowrap>{{ $roomBooking->end_date->format('Y-m-d') }}</td>
            <td nowrap>
                ${{ money((int) $roomBooking->start_date->diffInDays($roomBooking->end_date) * $roomBooking->room->price) }}</td>
            </td>
            <td nowrap>
                {{ $roomBooking->status == "Cancelado" ? 'Anulado' : $roomBooking->status }}  
            </td>
            <td nowrap style="display: flex; flex-direction: row; align-items: center; gap: 5px;">
                <!-- solo si está reservado se deja modificar el tipo de pago -->
                @if($roomBooking->status == "Reservado")
                    @livewire('hotel-booking.change-payment-type', ['roomBooking' => $roomBooking])
                @else
                    {{ $roomBooking->payment_type }}
                @endif

                @if($roomBooking->status == "Reservado" && $roomBooking->payment_type == "Transferencia")
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
                <!-- solo se puede anular si el estado es reservado -->
                @if($roomBooking->status == "Reservado") 
                <form method="POST" class="form-horizontal" action="{{ route('hotel_booking.booking_cancelation', $roomBooking) }}">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('¿Está seguro que desea anular la reserva?')">
                            Anular
                        </button>
                </form> 
                @else 
                     
                @endif
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

@endsection

@section('custom_js')

<script>

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

@foreach($roomBookings as $roomBooking)
    @if($roomBooking->payment_type == "Transferencia")
        @if($roomBooking->files)
            $("#buttonfile{{$roomBooking->id}}").click(function(){
                $("#fila{{$roomBooking->id}}").toggle();
            });
        @endif
    @endif
@endforeach


</script>

@endsection
