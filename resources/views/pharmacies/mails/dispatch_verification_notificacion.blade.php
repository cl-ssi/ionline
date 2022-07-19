@extends('layouts.mail')

@section('content')

<style>
    .confirmar {
        border: 1px solid black;
        color: #fff;
        background: green;
        padding: 10px 20px;
        border-radius: 3px;
    }

    .gestionar {
        border: 1px solid black;
        color: black;
        background: yellow;
        padding: 10px 20px;
        border-radius: 3px;
    }

    .anular {
        border: 1px solid black;
        color: black;
        background: red;
        padding: 10px 20px;
        border-radius: 3px;
    }
</style>

    <div style="text-align: justify;">
        <p>Se encuentra disponible una nueva solicitud confirmación de recepción</p>
        <p> <strong>Número Solicitud:</strong> {{ $dispatch->id??'' }}</p>     
        <br><hr>
        
        <table style="border: 1px;">
            <thead>
                <tr>
                    <td><b>Producto</b></td>
                    <td><b>Cantidad</b></td>
                </tr>
            </thead>
            <tbody>
                @foreach($dispatch->dispatchItems as $item)
                    <tr>
                        <td>{{$item->product->name}}</td>
                        <td>{{$item->amount}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br><hr>
        <div style="text-align: right;">
            <a href="{{env('APP_URL').'/external_pharmacy/confirmation_verification/'.$dispatch->base64encode}}">
                <input type="button" class="confirmar" value ="Recepción conforme">
            </a>
            <a href="{{env('APP_URL').'/external_pharmacy/confirmation_wobservations_verification/'.$dispatch->base64encode}}">
                <input type="button" class="gestionar" value ="Recepción con observaciones">
            </a>
            <a href="{{env('APP_URL').'/external_pharmacy/cancel_verification/'.$dispatch->base64encode}}">
                <input type="button" class="anular" value ="Anular recepción">
            </a>
        </div>

        <br><br>
        Saludos cordiales.
    </div>

@endsection

@section('firmante', 'Servicio de Salud Iquique')

@section('linea1', 'Anexo Minsal: 579502 - 579503')