@extends('layouts.bt4.app')
@section('title', 'DTEs pendientes de Asignar DTE')
@section('content')
    @include('dte.pendingnav')
    <h4>
        @if ($tray == 'bienes')
            Bienes
        @elseif($tray == 'servicios')
            Servicios
        @else
            Todos Los
        @endif
        DTE Pendiente de Acta

    </h4>
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th width="55px">Estb.</th>
                <th>Documento</th>
                <th>OC</th>
                <th>FR</th>
                <th>Tipo de FR</th>
                <th>Cargar Acta</th>
                @if(!$tray or $tray == 'bienes')
                <th>Firma Jefe Bodega <small class="form-text text-muted">(Solo Bienes)</small></th>
                <th>Firma Jefe <small class="form-text text-muted">(Solo Bienes)</small></th>
                @endif
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dtes as $dte)
                <tr>
                    <td>{{ $dte->id }}</td>
                    <td>
                        {{ $dte->establishment?->alias }}
                    </td>
                    <td>
                        @include('finance.payments.partials.dte-info')
                    </td>
                    <td class="small">
                        @livewire('finance.get-purchase-order', ['dte' => $dte], key($dte->id))
                    </td>
                    <td>
                        @include('finance.payments.partials.fr-info')
                    </td>
                    <td>
                        {{ $dte->requestForm->subtype ?? '' }}
                    </td>
                    <td width="300">
                        @if (
                            $tray == 'servicios' or
                                $dte->requestForm->subtype == 'servicios ejecución tiempo' or
                                $dte->requestForm->subtype == 'servicios ejecución inmediata')
                            <form action="{{ route('finance.dtes.saveFile', ['dte' => $dte->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="tray" id="tray" value="servicios">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="acta_{{ $dte->id }}" class="custom-file-input"
                                            id="for-file-{{ $dte->id }}" accept=".pdf">
                                        <label class="custom-file-label" for="for-file"
                                            wire:model="formFile.{{ $dte->id }}" data-browse="Examinar"></label>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit" id="for-upload-button">
                                            <i class="fas fa-upload"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                    </td>
                    <td></td>
            @endif
            </tr>
            @endforeach
        </tbody>
    </table>


@endsection
