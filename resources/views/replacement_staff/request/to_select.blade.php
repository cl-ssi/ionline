@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<h4 class="mb-3">Selección de Postulantes</h4>

<table class="table table-sm table-bordered">
    <thead>
        <tr class="table-active">
          <th colspan="3">Formulario Solicitud Contratación de Personal</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th class="table-active">Por medio del presente, la Subdirección</th>
            <td colspan="2">
                @foreach($requestReplacementStaff->RequestSign as $sing)
                    @if($sing->ou_alias == 'sub')
                        {{ $sing->organizationalUnit->name }}
                    @endif
                @endforeach
            </td>
        </tr>
        <tr>
            <th class="table-active">En el grado</th>
            <td colspan="2">{{ $requestReplacementStaff->degree }}</td>
        </tr>
        <tr>
            <th class="table-active">Calidad Jurídica</th>
            <td colspan="2">{{ $requestReplacementStaff->LegalQualityValue }}</td>
        </tr>
        <tr>
            <th class="table-active">La Persona cumplirá labores en Jornada</th>
            <td style="width: 33%">{{ $requestReplacementStaff->WorkDayValue }}</td>
            <td style="width: 33%">{{ $requestReplacementStaff->other_work_day }}</td>
        </tr>
        <tr>
            <th class="table-active">Justificación o fundamento de la Contratación</th>
            <td style="width: 33%">{{ $requestReplacementStaff->FundamentValue }}</td>
            <td style="width: 33%">De funcionario: {{ $requestReplacementStaff->name_to_replace }}</td>
        </tr>
        <tr>
            <th class="table-active">Otros (especifique)</th>
            <td colspan="2">{{ $requestReplacementStaff->other_fundament }}</td>
        </tr>
        <tr>
            <td colspan="3">El documento debe contener las firmas y timbres de las personas que dan autorización para que la Unidad Selección inicie el proceso de Llamado de presentación de antecedentes.</td>
        </tr>
        <tr>
            @foreach($requestReplacementStaff->RequestSign as $sign)
              <td class="table-active">
                  {{ $sign->organizationalUnit->name }}<br>
              </td>
            @endforeach
        </tr>
        <tr>
            @foreach($requestReplacementStaff->RequestSign as $sign)
              <td align="center">
                  @if($sign->request_status == 'pending')
                      Estado: {{ $sign->StatusValue }} <br><br>
                      <a href=""
                          class="btn btn-success btn-sm" title="Aceptar">
                          <i class="fas fa-check-circle"></i> Aceptar</a>
                      <a href=""
                          class="btn btn-danger btn-sm" title="Aceptar">
                          <i class="fas fa-times-circle"></i> Rechazar</a>
                  @else
                      Estado: No disponible para aprobación.<br>
                  @endif
              </td>
            @endforeach
        </tr>
    </tbody>
</table>

<div class="card">
    <div class="card-header">

    </div>
    <div class="card-body">

    </div>
</div>

@endsection

@section('custom_js')

@endsection
