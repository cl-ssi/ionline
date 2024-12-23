@extends('layouts.document')

@section('title', 'Plan de Compra N°' . $purchasePlan->id)

@section('linea1', 'Depto. de Gestión Abastecimiento y Logística')

@section('content')

    <style>
        .tabla th,
        .tabla td {
            padding: 3px;
            /* Ajusta este valor a tus necesidades */
        }

        .totales {
            margin-left: auto;
            margin-right: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .nowrap {
            white-space: nowrap;
        }
        
        .signature-container {
            height: 10px; 
        }
        
    </style>

    <div style="float: right; width: 300px; padding-top: 66px;">

        <div class="left quince" style="padding-left: 2px; padding-bottom: 10px;">
            <strong style="text-transform: uppercase; padding-right: 30px;">
            Plan de compra N°:
            </strong> 
            <span class="catorce negrita">{{ $purchasePlan->id }}</span>
        </div>

        <div style="padding-top:5px; padding-left: 2px;">
            Iquique, {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
        </div>
    </div>

    <div style="clear: both; padding-bottom: 35px"></div>

    <table class="tabla">
        <tr>
			<td style="width: 30%; background-color: #EEEEEE;" colspan="2">1-. Descripción</td>
		</tr>
		<tr>
			<td style="width: 30%; background-color: #EEEEEE;">Asunto</td>
			<td>{{ $purchasePlan->subject }}</td>
		</tr>
		<tr>
			<td style="background-color: #EEEEEE;">Descripción general del proyecto o adquisición</td>
			<td>{{ $purchasePlan->description }}</td>
		</tr>
		<tr>
			<td style="background-color: #EEEEEE;">Propósito general del proyecto o adquisición</td>
			<td>{{ $purchasePlan->purpose }}</td>
		</tr>
		<tr>
			<td style="background-color: #EEEEEE;">Funcionario Responsable</td>
			<td>{{ $purchasePlan->userResponsible->fullName }}</td>
		</tr>
		<tr>
			<td style="background-color: #EEEEEE;">Cargo</td>
			<td>{{ $purchasePlan->position }}</td>
		</tr>
		<tr>
			<td style="background-color: #EEEEEE;">Teléfono</td>
			<td>{{ $purchasePlan->telephone }}</td>
		</tr>
		<tr>
			<td style="background-color: #EEEEEE;">Correo Electronico</td>
			<td>{{ $purchasePlan->email }}</td>
		</tr>
		<tr>
			<td style="background-color: #EEEEEE;">Depto./Unidad</td>
			<td>{{ $purchasePlan->organizationalUnit->name }} ({{$purchasePlan->organizationalUnit->establishment->name}})</td>
		</tr>
		<tr>
			<td style="background-color: #EEEEEE;">Nombre del Programa o Presupuesto Designado</td>
			<td>{{ $purchasePlan->program }}</td>
		</tr>
		<tr>
			<td style="background-color: #EEEEEE;">Monto Solicitado (Aproximado)</td>
			<td>${{ number_format($purchasePlan->estimated_expense, 0, ",", ".") }}</td>
		</tr>
		<tr>
			<td style="background-color: #EEEEEE;">Monto aprobado</td>
			<td></td>
		</tr>
    </table>

    <div style="clear: both; padding-bottom: 20px"></div>

    <table class="tabla">
        <thead>
            <tr class="text-center">
                <th colspan="9" style="background-color: #EEEEEE; text-align: left;">2-. Ítems a comprar</th>
            </tr>
            <tr class="text-center">
                <th rowspan="2" style="background-color: #EEEEEE;">#</th>
                <th rowspan="2" style="background-color: #EEEEEE;">Artículo</th>
                <th rowspan="2" style="background-color: #EEEEEE;">UM</th>
                <th rowspan="2" style="background-color: #EEEEEE;">Especificaciones Técnicas</th>
                <th colspan="2" style="background-color: #EEEEEE;">Cantidad</th>
                <th rowspan="2" style="background-color: #EEEEEE;">Valor U.</th>
                <th rowspan="2" style="background-color: #EEEEEE;">Impuestos</th>
                <th rowspan="2" style="background-color: #EEEEEE;">Total Item</th>
            </tr>
            <tr>
                <th style="background-color: #EEEEEE;">Solicitados</th>
                <th style="background-color: #EEEEEE;">Programados</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchasePlan->purchasePlanItems as $item)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->unspscProduct->name }}</td>
                <td>{{ $item->unit_of_measurement }}</td>
                <td>{{ $item->specification }}</td>
                <td>{{ $item->quantity }}</td>
                <td class="{{ $item->quantity > $item->scheduled_quantity ? 'text-danger' : 'text-success' }}">{{ $item->scheduled_quantity }}</td>
                <td class="text-end">${{ number_format($item->unit_value, 0, ",", ".") }}</td>
                <td>{{ $item->tax }}</td>
                <td class="text-end">${{ number_format($item->expense, 0, ",", ".") }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7"></td>
                <th class="text-end">Total</th>
                <th class="text-end">${{ number_format($purchasePlan->estimated_expense, 0, ",", ".") }}</th>
            </tr>
        </tfoot>
    </table>

    <div style="clear: both; padding-bottom: 20px"></div>

    <table class="tabla">
        <thead>
            <tr class="text-center">
                <th colspan="16" style="background-color: #EEEEEE; text-align: left;">3-. Articulos Programados</th>
            </tr>
            <tr class="text-center">
                <th style="background-color: #EEEEEE;"rowspan="2">#</th>
                <th style="background-color: #EEEEEE;"rowspan="2">Artículo</th>
                <th style="background-color: #EEEEEE;" rowspan="2">UM</th>
                <th style="background-color: #EEEEEE;" rowspan="2">Cantidad</th>
                <th style="background-color: #EEEEEE;" colspan="12">Cantidad programadas por meses</th>
            </tr>
            <tr class="text-center">
                <th style="background-color: #EEEEEE;">Ene</th>
                <th style="background-color: #EEEEEE;">Feb</th>
                <th style="background-color: #EEEEEE;">Mar</th>
                <th style="background-color: #EEEEEE;">Abr</th>
                <th style="background-color: #EEEEEE;">May</th>
                <th style="background-color: #EEEEEE;">Jun</th>
                <th style="background-color: #EEEEEE;">Jul</th>
                <th style="background-color: #EEEEEE;">Ago</th>
                <th style="background-color: #EEEEEE;">Sep</th>
                <th style="background-color: #EEEEEE;">Oct</th>
                <th style="background-color: #EEEEEE;">Nov</th>
                <th style="background-color: #EEEEEE;">Dic</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchasePlan->purchasePlanItems as $item)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->unspscProduct->name }}</td>
                    <td>{{ $item->unit_of_measurement }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->january ?? 0 }}</td>
                    <td>{{ $item->february ?? 0 }}</td>
                    <td>{{ $item->march ?? 0 }}</td>
                    <td>{{ $item->april ?? 0 }}</td>
                    <td>{{ $item->may ?? 0 }}</td>
                    <td>{{ $item->june ?? 0 }}</td>
                    <td>{{ $item->july ?? 0 }}</td>
                    <td>{{ $item->august ?? 0 }}</td>
                    <td>{{ $item->september ?? 0 }}</td>
                    <td>{{ $item->october ?? 0 }}</td>
                    <td>{{ $item->november ?? 0 }}</td>
                    <td>{{ $item->december ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="clear: both; padding-bottom: 60px;"></div>

    <!-- Sección de las aprobaciones -->
    <div class="signature-container">
        <div class="signature" style="padding-left: 32px; vertical-align: middle;">
            @foreach($purchasePlan->approvals as $approval)
                @if($approval->digital_signature == 0)
                    {{ $approval->approver->initials }} &nbsp;&nbsp;&nbsp;
                @endif
            @endforeach
        </div>
        
        <div class="signature" style="padding-left: 6px; padding-right: 6px;">
            
        </div>
        <div class="signature">
            @if($approvals = $purchasePlan->approvals->where('position', 'right'))
                @foreach($approvals as $approval)
                    @include('sign.approvation', [
                        'approval' => $approval,
                    ])
                @endforeach
            @endif
        </div>
    </div>
@endsection