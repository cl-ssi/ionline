<?php setlocale(LC_ALL, 'es'); ?>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Formulario de Requerimientos: Abastecimiento</title>
  <meta name="description" content="">
  <meta name="author" content="Servicio de Salud Tarapacá">
  <style media="screen">
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 0.75rem;
    }

    .content {
      margin: 0 auto;
      /*border: 1px solid #F2F2F2;*/
      width: 724px;
      /*height: 1100px;*/
    }

    .monospace {
      font-family: "Lucida Console", Monaco, monospace;
    }

    .pie_pagina {
      margin: 0 auto;
      /*border: 1px solid #F2F2F2;*/
      width: 724px;
      height: 26px;
      position: fixed;
      bottom: 0;
    }

    .seis {
      font-size: 0.6rem;
    }

    .siete {
      font-size: 0.7rem;
    }

    .ocho {
      font-size: 0.8rem;
    }

    .nueve {
      font-size: 0.9rem;
    }

    .plomo {
      background-color: F3F1F0;
    }

    .titulo {
      text-align: center;
      font-size: 1.2rem;
      font-weight: bold;
      padding: 4px 0 6px;
    }

    .center {
      text-align: center;
    }

    .left {
      text-align: left;
    }

    .right {
      text-align: right;
    }

    .justify {
      text-align: justify;
    }

    .indent {
      text-indent: 30px;
    }

    .uppercase {
      text-transform: uppercase;
    }

    #firmas {
      margin-top: 80px;
    }

    #firmas>div {
      display: inline-block;
    }

    .li_letras {
      list-style-type: lower-alpha;
    }

    table {
      border: 1px solid grey;
      border-collapse: collapse;
      padding: 0 4px 0 4px;
      width: 100%;
    }

    th,
    td {
      border: 1px solid grey;
      border-collapse: collapse;
      padding: 0 4px 0 4px;
    }

    .column {
      float: left;
      width: 50%;
    }

    /* Clear floats after the columns */
    .row:after {
      content: "";
      display: table;
      clear: both;
    }

    @media all {
      .page-break {
        display: none;
      }
    }

    @media print {
      .page-break {
        display: block;
        page-break-before: always;
      }
    }
  </style>
</head>

<body>
  <div class="content">

    <div class="content">
      @if($requestForm->contractManager->organizationalUnit->establishment_id == App\Models\Parameters\Parameter::get('establishment', 'HETG'))
      <img style="padding-bottom: 4px;" src="images/Logo Hospital Ernesto Torres - Pluma.png" width="120" alt="Logo Hospital Ernesto Torres de Iquique">
      @else
      <img style="padding-bottom: 4px;" src="images/Logo Servicio de Salud Tarapacá - Pluma.png" width="120" alt="Logo Servicio de Salud">
      @endif
      <br>

      <!-- <div class="siete" style="padding-top: 3px;">

        SUBDIRECCIÓN DE GESTIÓN Y DESARROLLO DE LAS PERSONAS
      </div>
      <div class="seis" style="padding-top: 4px;">
        N.I.PHUQHAÑA.
      </div> -->


      <div class="right" style="float: right; width: 340px;">
        <div class="left" style="padding-bottom: 6px;">
          <strong>N° DE FORMULARIO DE REQUERIMIENTO: {{ $requestForm->folio }}</strong>
        </div>
        <div class="left" style="padding-bottom: 2px;">
          <strong>Iquique, {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</strong>
        </div>
      </div>


      <div style="clear: both; padding-bottom: 35px">&nbsp;</div>

      <table class="siete">
          <tr>
              <th align="left" style="width: 50%">Gasto Estimado</th>
              <td colspan="2">{{$requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
          </tr>
          @if($requestForm->has_increased_expense)
          <tr>
              <th align="left" style="width: 50%">Nuevo presupuesto</th>
              <td colspan="2">{{$requestForm->symbol_currency}}{{ number_format($requestForm->new_estimated_expense,$requestForm->precision_currency,",",".") }}</td>
          </tr>
          @endif
          <tr>
              <th align="left">Solicitante</th>
              <td colspan="2">{{ $requestForm->user ? $requestForm->user->fullName : 'Usuario eliminado' }}</td>
          </tr>
          <tr>
              <th align="left">Nombre Administrador de Contrato</th>
              <td colspan="2">{{ $requestForm->contractManager ? $requestForm->contractManager->fullName : 'Usuario eliminado' }}</td>
          </tr>
          <tr>
              <th align="left">Teléfono del Administrador de Contrato</th>
              <td colspan="2">
                {{ $requestForm->contractManager->telephones->first() ? $requestForm->contractManager->telephones->first()->number : 'Sin teléfono asignado' }} -
                {{ $requestForm->contractManager->telephones->first() ? $requestForm->contractManager->telephones->first()->minsal : 'Sin teléfono asignado' }}
              </td>
          </tr>
          <tr>
              <th align="left">Correo del Administrador de Contrato</th>
              <td colspan="2">{{ $requestForm->contractManager ? $requestForm->contractManager->email : 'Usuario eliminado' }}</td>
          </tr>
          <tr>
              <th align="left">Departamento y/o Unidad</th>
              <td colspan="2">{{ $requestForm->contractManager ? $requestForm->contractManager->organizationalUnit->name : 'Usuario eliminado' }}</td>
          </tr>
          <tr>
              <th align="left">Subdirección</th>
              <td colspan="2">
                @if($requestForm->contractManager->organizationalUnit->father && $requestForm->contractManager->organizationalUnit->father->level == 2)
                    {{ $requestForm->contractManager ? $requestForm->contractManager->organizationalUnit->father->name : 'Usuario eliminado' }}
                @else
                    -
                @endif
              </td>
          </tr>
          <tr>
              <th align="left">Programa Asociado</th>
              <td colspan="2">{{ $requestForm->associateProgram ? $requestForm->associateProgram->alias_finance.' '.$requestForm->associateProgram->period : $requestForm->program }}</td>
          </tr>
          <tr>
              <th align="left">Justificación</th>
              <td colspan="2">{{ $requestForm->justification }}</td>
          </tr>
          {{--
          <tr>
              <th align="left" rowspan="5">Mecanismo de adquisición</th>
              <td>Menores a 3 UTM</td>
              <td align="center">@if($requestForm->purchase_mechanism_id == 1)
                      X
                  @endif
              </td>
          </tr>
          <tr>
              <td>Convenio Marco</td>
              <td align="center">@if($requestForm->purchase_mechanism_id == 2)
                      X
                  @endif
              </td>
          </tr>
          <tr>
              <td>Trato Directo</td>
              <td align="center">@if($requestForm->purchase_mechanism_id == 3)
                      X
                  @endif
              </td>
          </tr>
          <tr>
              <td>Licitación Pública</td>
              <td align="center">@if($requestForm->purchase_mechanism_id == 4)
                      X
                  @endif
              </td>
          </tr>
          <tr>
              <td>Compra Ágil</td>
              <td align="center">@if($requestForm->purchase_mechanism_id == 5)
                      X
                  @endif
              </td>
          </tr>
          --}}
      </table>

      <div style="clear: both; padding-bottom: 20px">&nbsp;</div>

      @if($requestForm->type_form == 'bienes y/o servicios')
      <table class="siete">
          <thead>
              <tr>
                  <th>#</th>
                  <th>Ítem Pres.</th>
                  <th>Articulo</th>
                  <th>Especificaciones Técnicas</th>
                  <th>Cantidad</th>
                  <th>Valor Unitario Neto</th>
                  <th>Valor Total *</th>
              </tr>
          </thead>
          <tbody>
              @foreach($requestForm->itemRequestForms as $key => $item)
              <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $item->budgetItem->code }}</td>
                  <td>{{ $item->product ? $item->product->code.' '.$item->product->name : $item->article }}</td>
                  <td>{!! $item->latestPendingItemChangedRequestForms->specification ?? $item->specification !!}</td>
                  <td align="right">{{ $item->latestPendingItemChangedRequestForms->quantity ?? $item->quantity }}</td>
                  <td align="right">{{$requestForm->symbol_currency}}{{ str_replace(',00', '', number_format($item->latestPendingItemChangedRequestForms->unit_value ?? $item->unit_value, 2,",",".")) }}</td>
                  <td align="right">{{$requestForm->symbol_currency}}{{ number_format($item->latestPendingItemChangedRequestForms->expense ?? $item->expense,$requestForm->precision_currency,",",".") }}</td>
              </tr>
              @endforeach
          </tbody>
          <tfoot>
              <tr align="right">
                  <th colspan="6">Total</th>
                  <th>{{$requestForm->symbol_currency}}{{ number_format($requestForm->new_estimated_expense ?? $requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}</th>
              </tr>
          </tfoot>
      </table>
      @else
      <!-- Pasajeros -->
      @php($round_trips = ['round trip' => 'Ida y Vuelta', 'one-way only' => 'Solo Ida'])
      @php($baggages = ['handbag' => 'Bolso de Mano', 'hand luggage' => 'Equipaje de Cabina', 'baggage' => 'Equipaje de Bodega', 'oversized baggage' => 'Equipaje Sobredimensionado'])
      
      <table class="siete">
          <thead>
          <tr>
              <th>#</th>
              <!-- <th style="width:70px">RUT</th> -->
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Item Pres.</th>
              <th>Tipo viaje</th>
              <th>Origen</th>
              <th>Destino</th>
              <th>Fecha ida</th>
              <th>Fecha vuelta</th>
              <th>Equipaje</th>
              <th>Total pasaje *</th>
          </tr>
          </thead>
          <tbody>
          @foreach($requestForm->passengers as $key => $passenger)
              <tr>
                  <td>{{ $key+1 }}</td>
                  {{--<td>{{ number_format($passenger->run, 0, ",", ".") }}-{{ $passenger->dv }}</td>--}}
                  <td>{{ strtok($passenger->name, ' ') }}</td>
                  <td>{{ $passenger->fathers_family }}</td>
                  <td>{{ $passenger->budgetItem ? $passenger->budgetItem->fullName() : '' }}</td>
                  <td>{{ isset($round_trips[$passenger->round_trip]) ? $round_trips[$passenger->round_trip] : '' }}</td>
                  <td>{{ $passenger->origin }}</td>
                  <td>{{ $passenger->destination }}</td>
                  <td>{{ $passenger->departure_date->format('d-m-Y') }}</td>
                  <td>{{ $passenger->return_date ? $passenger->return_date->format('d-m-Y') : '' }}</td>
                  <td>{{ isset($baggages[$passenger->baggage]) ? $baggages[$passenger->baggage] : '' }}</td>
                  <td align="right">{{ number_format($passenger->latestPendingPassengerChanged->unit_value ?? $passenger->unit_value, $requestForm->precision_currency, ",", ".") }}</td>
              </tr>
          @endforeach
          </tbody>
          <tfoot>
          <tr align="right">
              <th colspan="10">
                  Valor Total
              </th>
              <th>{{$requestForm->symbol_currency}}{{ number_format($requestForm->new_estimated_expense ?? $requestForm->estimated_expense, $requestForm->precision_currency,",",".") }}</th>
          </tr>
          </tfoot>
      </table>
      @endif
      <div>
          <p align="right">* El valor total presenta impuestos incluidos.</p>
      </div>

      <div style="clear: both; padding-bottom: 20px">&nbsp;</div>

      <table class="siete">
          <thead>
              <tr>
                  <th colspan="2">AUTORIZACIÓN FORMULARIO DE REQUERIMIENTO JEFATURA DIRECTA</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <th align="left" style="width: 50%">Nombre</th>
                  <td>{{ $requestForm->eventSigner('leader_ship_event', 'approved')->signerUser->fullName }}</td>
              </tr>
              <tr>
                  <th align="left" style="width: 50%">Cargo</th>
                  <td>{{ $requestForm->eventSigner('leader_ship_event', 'approved')->position_signer_user }}
                      {{ $requestForm->eventSigner('leader_ship_event', 'approved')->signerOrganizationalUnit->name }}</td>
              </tr>
              <tr>
                  <th align="left" style="width: 50%">Fecha</th>
                  <td>{{ $requestForm->eventSigner('leader_ship_event', 'approved')->signature_date->format('d-m-Y H:i') }}</td>
              </tr>
              <tr>
                  <th align="left" style="width: 50%">Estado</th>
                  <td>{{ $requestForm->eventSigner('leader_ship_event', 'approved')->StatusValue }}</td>
              </tr>
          </tbody>
      </table>

      <div style="clear: both; padding-bottom: 20px">&nbsp;</div>

      <table class="siete">
          <thead>
              <tr>
                  <th colspan="2">CERTIFICADO DE REFRENDACIÓN PRESUPUESTARIA</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <th align="left" style="width: 50%">PROGRAMA ASOCIADO</th>
                  <td>{{ $requestForm->associateProgram->alias_finance ?? $requestForm->program }}</td>
              </tr>
              <tr>
                  <th align="left" style="width: 50%">Folio Requerimiento - SIGFE</th>
                  <td>{{ $requestForm->associateProgram->folio ?? $requestForm->sigfe }}</td>
              </tr>
              <tr>
                  <th align="left" style="width: 50%">Financiamiento</th>
                  <td>{{ $requestForm->associateProgram->financing ?? '' }}</td>
              </tr>
              <tr>
                  <th align="left" style="width: 50%">Monto $</th>
                  <td>{{$requestForm->symbol_currency}}{{ number_format($requestForm->has_increased_expense ? $requestForm->new_estimated_expense : $requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
              </tr>
              <tr>
                  <th align="left" style="width: 50%">Fecha</th>
                  <td>{{ $requestForm->eventSigner('pre_finance_event', 'approved')->signature_date->format('d-m-Y H:i') }}</td>
              </tr>
          </tbody>
      </table>

      <div style="clear: both; padding-bottom: 20px">&nbsp;</div>

      <table class="siete">
          <thead>
              <tr>
                  <th colspan="2">AUTORIZACIÓN FINANCIERA</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <th align="left" style="width: 50%">Nombre</th>
                  @if(request()->has_increased_expense == 11)
                  @php($currentFinanceManager = App\Models\Rrhh\OrganizationalUnit::find($requestForm->eventSigner('finance_event', 'pending')->ou_signer_user)->currentManager)
                  <td>{{ $currentFinanceManager->user->fullName }}</td>
                  @else
                  <td>{{ auth()->user()->fullName }}</td>
                  @endif
              </tr>
              <tr>
                  <th align="left" style="width: 50%">Cargo</th>
                  @if(request()->has_increased_expense == 11)
                  <td>{{ $currentFinanceManager->position }}
                      {{ $currentFinanceManager->organizationalUnit->name }}
                  </td>
                  @else
                  <td>{{ App\Models\Rrhh\Authority::getAmIAuthorityFromOu(Carbon\Carbon::now(), 'manager', auth()->id())[0]->position }}
                      {{ App\Models\Rrhh\Authority::getAmIAuthorityFromOu(Carbon\Carbon::now(), 'manager', auth()->id())[0]->organizationalUnit->name }}
                  </td>
                  @endif
              </tr>
              <tr>
                  <th align="left" style="width: 50%">Fecha</th>
                  <td>{{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</td>
              </tr>
              <tr>
                  <th align="left" style="width: 50%">Estado</th>
                  <td>Aprobado</td>
              </tr>
          </tbody>
      </table>

      <div style="clear: both; padding-bottom: 50px;">&nbsp;</div>

      {{-- <table class="siete">
          <thead>
              <tr>
                  <th colspan="2">AUTORIZACIÓN ASIGNACIÓN DEL FORMULARIO DE REQUERIMIENTO </th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <th align="left" style="width: 50%">Nombre</th>
                  <td>{{ $requestForm->eventSigner('supply_event', 'approved')->signerUser->fullName }}</td>
              </tr>
              <tr>
                  <th align="left" style="width: 50%">Cargo</th>
                  <td>{{ $requestForm->eventSigner('supply_event', 'approved')->position_signer_user }}</td>
              </tr>
              <tr>
                  <th align="left" style="width: 50%">Fecha</th>
                  <td>{{ $requestForm->eventSigner('supply_event', 'approved')->signature_date->format('d-m-Y H:i') }}</td>
              </tr>
              <tr>
                  <th align="left" style="width: 50%">Estado</th>
                  <td>{{ $requestForm->eventSigner('supply_event', 'approved')->StatusValue }}</td>
              </tr>
              <tr>
                  <th align="left" style="width: 50%">COMPRADOR(ES) ASIGNADO(S): </th>
                  @foreach($requestForm->purchasers as $purchaser)
                  <td>{{ $purchaser->fullName }}</td>
                  @endforeach
              </tr>
          </tbody>
      </table> --}}

    </div>
</body>

</html>
