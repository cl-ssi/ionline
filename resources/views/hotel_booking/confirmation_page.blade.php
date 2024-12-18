@extends('layouts.bt4.app')

@section('title', 'Confirmación de Reserva')

@section('content')

@include('welfare.nav')

<?php $roomBooking = Session::get('roomBooking'); ?>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
    <tr>
        <td align="center" valign="top" ><h1>Confirmación</h1></td>
    </tr>
    <tr>
        <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
            <h4 >
                Reserva de hospedaje completa
            </h4>
        </td>
    </tr>
    <tr>
        <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
            <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
                Haz realizado una reserva con @if($roomBooking) <b>{{$roomBooking->room->hotel->name}}</b> @endif
            </p>
        </td>
    </tr>
    <tr>
        <td align="left" style="padding-top: 20px;">
            <table cellspacing="0" cellpadding="0" border="1" width="100%">
                <tr>
                    <td width="50%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                        Folio de Confirmación #
                    </td>
                    <td width="50%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                        @if($roomBooking) <b>{{$roomBooking->id}}</b> @endif
                    </td>
                </tr>
                <tr>
                    <td width="30%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                        Huésped: 
                    </td>
                    <td width="70%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                        @if($roomBooking) <b>{{$roomBooking->user->shortName }}</b> @endif
                    </td>
                </tr>
                <tr>
                    <td width="30%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                        Ingreso: 
                    </td>
                    <td width="70%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                        @if($roomBooking) <b>{{$roomBooking->start_date->format('Y-m-d')}}</b> @endif a las <b>18:00.</b>
                    </td>
                </tr>
                <tr>
                    <td width="30%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                        Salida:
                    </td>
                    <td width="70%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                        @if($roomBooking) <b>{{$roomBooking->end_date->format('Y-m-d')}}</b> @endif a las <b>17:00.</b>
                    </td>
                </tr>
                <tr>
                    <td width="30%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                        Valor:
                    </td>
                    <td width="70%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                        $@if($roomBooking) <b>{{ money((int) $roomBooking->start_date->diffInDays($roomBooking->end_date) * $roomBooking->room->price)}}</b> @endif
                    </td>
                </tr>
                <tr>
                    <td width="30%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                        Tipo:
                    </td>
                    <td width="70%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                        @if($roomBooking) <b>{{$roomBooking->room->type->name}}</b> @endif
                    </td>
                </tr>
                <tr>
                    <td width="30%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                        Hospedaje:
                    </td>
                    <td width="70%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                        @if($roomBooking) <b>{{$roomBooking->room->identifier}}</b> @endif
                    </td>
                </tr>
                <tr>
                    <td width="30%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                        Tipo de pago:
                    </td>
                    <td width="70%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                        @if($roomBooking) <b>{{$roomBooking->payment_type}}</b> @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <br>
            <h4 style="color:red">Su reserva se encuentra pendiente de confirmación del área de bienestar.</h4>
        </td>
    </tr>
</table>

@endsection

@section('custom_js')

@endsection
