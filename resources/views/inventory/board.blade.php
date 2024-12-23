@extends('layouts.document')

@section('title', 'Inventario ' . $place->id)

@section('linea3', 'id: ' . $place->id .' lugar: '.$place->name. ' - ' . $place->establishment->name)
<main>
@section('content')


<style>
    .tabla th,
    .tabla td {
        padding: 3px;
    }

    .nowrap {
        white-space: nowrap;
    }

    .qr {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .qr img {
        max-width: 100%;
        padding:35%; /* Ajusta el padding según sea necesario */
    }


</style>

<div style="float: right; width: 300px; padding-top: 66px;">
    <!-- Aquí puedes colocar el contenido del lado derecho si lo necesitas -->
</div>

<div style="clear: both; padding-bottom: 35px"></div>

<br>
<div class="center diez">
    <strong style="text-transform: uppercase;">
        <h3>PLANILLA MURAL DE INVENTARIO OFICINA CONTROL DE BIENES:</h3>
    </strong>
</div>


<p style="white-space: pre-wrap;"></p>

<table class="tabla" >
    <tr>
        <th>DEPENDENCIA:</th>
        <td>{{ $place->name }}</td>
        <th>ZONA:</th>
        <td>{{ $place->architectural_design_code }}</td>
    </tr>
    <tr>
        <th>RESPONSABLE(S):</th>
        <td colspan="3">
            <ul>
                @foreach($inventories->unique('lastConfirmedMovement.responsibleUser.id') as $inventory)
                    <li>{{ $inventory->lastConfirmedMovement->responsibleUser->shortName }}</li>
                @endforeach
            </ul>
        </td>
    </tr>
    <tr>
        <th>USUARIO(S):</th>
        <td colspan="3">
            <ul>
                @php
                    $uniqueUsers = collect();
                    foreach($inventories as $inventory) {
                        foreach($inventory->inventoryUsers as $inventoryUser) {
                            $uniqueUsers->push($inventoryUser->user);
                        }
                    }
                    $uniqueUsers = $uniqueUsers->unique('id');
                @endphp
                @foreach($uniqueUsers as $user)
                    <li>{{ $user->tinyName }}</li>
                @endforeach
            </ul>
        </td>
    </tr>
</table>

<br><br>

    <div class="qr text-center" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <img src="data:image/png;base64,{{ $qrcode }}" style="max-width: 100%;">
    </div>


<table class="tabla" style="page-break-inside: avoid;">
    <thead>
        <tr>
            <th>Nº</th>
            <th>CÓDIGO</th>
            <th>DESC.</th>
            <th>ESTADO</th>
            <th>OBS.</th>
            <th>RESPONSABLE</th>
            <th>RECEPCIÓN DIGITAL</th>
        </tr>
    </thead>
    <tbody>
                @foreach($inventories as $inventory)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $inventory->number }}</td>
                        <td>{{ $inventory->description }}</td>
                        <td>{{ $inventory->estado }}</td>
                        <td>{{ $inventory->observations }}</td>
                        <td>{{ $inventory->lastConfirmedMovement->responsibleUser->shortName }}</td>                        
                        <td>@include('sign.custom-clave-unica',['user'=>$inventory->lastConfirmedMovement->responsibleUser, 'date' => $inventory->lastConfirmedMovement->reception_date])</td>
                    </tr>
                @endforeach
    </tbody>

</table>

@endsection
</main>
