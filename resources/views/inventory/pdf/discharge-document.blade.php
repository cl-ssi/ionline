@extends('inventory.pdf.layouts')

@section('title', "Acta de Baja " . $inventory->number)

@section('css')
<style>
    .content-sign {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .border-hidden {
        border: hidden;
    }

    .content-date {
        width: 50%;
        display: inline-block;
        padding-bottom: 10px;
    }

    .text-bold {
        font-weight: bold;
        font-size: 11px;
        text-align: center;
        padding-bottom: 10px;
    }
</style>
@endsection

@section('content')

<div style="width: 49%; display: inline-block;">
    <div class="siete">
        {{ env('APP_SS') }}
    </div>
</div>


<div class="right content-date">
    Iquique, {{ $inventory->format_date }}<br>
</div>

<div class="titulo" style="padding-top: 70px">
    ACTA DE BAJA #{{ $inventory->act_number }}
</div>

<div style="padding-top: 40px">
    La siguiente acta deja constancia que da de baja el siguiente item de inventario
</div>

<div style="padding-top: 20px;">
    <table class="ocho">
        <tbody>
            <tr>
                <td>
                    <strong>Nro Inventario</strong>
                </td>
                <td>
                    {{ $inventory->number }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Producto</strong>
                </td>
                <td>
                    {{ optional($inventory->unspscProduct)->name }}
                    <br>
                    @if($inventory->product)
                        {{ $inventory->product->name }}
                    @else
                        {{ $inventory->description }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Ubicación</strong>
                </td>
                <td>
                    {{ $inventory->lastMovement->place->location->name }},
                    {{ $inventory->lastMovement->place->name }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Usuario</strong>
                </td>
                <td>
                    {{ optional($inventory->using)->tinyName }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Responsable</strong>
                </td>
                <td>
                    {{ optional($inventory->responsible)->tinyName }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Fecha de Instalación</strong>
                </td>
                <td>
                    {{ ($inventory->lastMovement->installation_date)
                    ? $inventory->lastMovement->installation_date->format('d/m/Y')
                    : 'No Instalado' }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div style="padding-top: 16px">
    <p>Para constancia firman:</p>
</div>

<div style="padding-top: 80px">
    <table>
        <tbody class="border-hidden">
            <tr>
                <td class="border-hidden">
                    <span class="text-bold content-sign">
                        RESPONSABLE DE INVENTARIO
                    </span>
                    <div class="content-sign">
                        {{-- @include('sign.approvation', [
                            'approval' => $approvalSender,
                        ]) --}}
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
