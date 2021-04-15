@extends('layouts.app')

@section('title', 'Selección')

@section('content')

@include('replacement_staff.nav')

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
                @foreach($technicalEvaluation->requestReplacementStaff->RequestSign as $sing)
                    @if($sing->ou_alias == 'sub')
                        {{ $sing->organizationalUnit->name }}
                    @endif
                @endforeach
            </td>
        </tr>
        <tr>
            <th class="table-active">En el grado</th>
            <td colspan="2">{{ $technicalEvaluation->requestReplacementStaff->degree }}</td>
        </tr>
        <tr>
            <th class="table-active">Calidad Jurídica</th>
            <td colspan="2">{{ $technicalEvaluation->requestReplacementStaff->LegalQualityValue }}</td>
        </tr>
        <tr>
            <th class="table-active">La Persona cumplirá labores en Jornada</th>
            <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->WorkDayValue }}</td>
            <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->other_work_day }}</td>
        </tr>
        <tr>
            <th class="table-active">Justificación o fundamento de la Contratación</th>
            <td style="width: 33%">{{ $technicalEvaluation->requestReplacementStaff->FundamentValue }}</td>
            <td style="width: 33%">De funcionario: {{ $technicalEvaluation->requestReplacementStaff->name_to_replace }}</td>
        </tr>
        <tr>
            <th class="table-active">Otros (especifique)</th>
            <td colspan="2">{{ $technicalEvaluation->requestReplacementStaff->other_fundament }}</td>
        </tr>
        <tr>
            <td colspan="3">El documento debe contener las firmas y timbres de las personas que dan autorización para que la Unidad Selección inicie el proceso de Llamado de presentación de antecedentes.</td>
        </tr>
        <tr>
            @foreach($technicalEvaluation->requestReplacementStaff->RequestSign as $sign)
              <td class="table-active">
                  {{ $sign->organizationalUnit->name }}<br>
              </td>
            @endforeach
        </tr>
        <tr>
            @foreach($technicalEvaluation->requestReplacementStaff->RequestSign as $requestSign)
              <td align="center">
                  @if($requestSign->request_status == 'pending' && $requestSign->organizational_unit_id == Auth::user()->organizationalUnit->id)
                      Estado: {{ $requestSign->StatusValue }} <br><br>
                      <div class="row">
                          <div class="col-sm">
                              <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.sign.update', [$requestSign, 'status' => 'accepted']) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm"
                                        onclick="return confirm('¿Está seguro que desea Aceptar la solicitud?')"
                                        title="Aceptar">
                                        <i class="fas fa-check-circle"></i></a>
                                    </button>
                              </form>
                        </div>
                        <div class="col-sm">
                            <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.sign.update', [$requestSign, 'status' => 'rejected']) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Está seguro que desea Reachazar la solicitud?')"
                                    title="Rechazar">
                                    <i class="fas fa-times-circle"></i></a>
                                </button>
                            </form>
                        </div>
                      </div>
                  @elseif($requestSign->request_status == 'accepted' || $requestSign->request_status == 'rejected')
                      <i class="fas fa-check-circle"></i> {{ $requestSign->StatusValue }} <br>
                      <i class="fas fa-user"></i> {{ $requestSign->user->FullName }}<br>
                      <i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($requestSign->date_sign)->format('d-m-Y H:i:s') }}<br>
                  @else
                      @if($requestSign->request_status == NULL)
                          <i class="fas fa-ban"></i> No disponible para Aprobación.<br>
                      @else
                          <i class="fas fa-clock"></i> {{ $requestSign->StatusValue }}<br>
                      @endif
                  @endif
              </td>
            @endforeach
        </tr>
    </tbody>
</table>

<br>

<table class="table table-sm table-bordered">
    <thead>
        <tr class="table-active">
          <th colspan="6">Evaluación Técnica</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th rowspan="2" class="table-active text-center"><i class="fas fa-user"></i></th>
            <td>{{ $technicalEvaluation->user->FullName }}</td>
            <th rowspan="2" class="table-active text-center"><i class="fas fa-calendar-alt"></i></th>
            <td>{{ $technicalEvaluation->created_at->format('d-m-Y H:i:s') }}</td>
            <th rowspan="2" class="table-active text-center">Estado</th>
            <td rowspan="2">{{ $technicalEvaluation->StatusValue }}</td>
        </tr>
        <tr>
            <td>{{ $technicalEvaluation->user->organizationalUnit->name }}</td>
            <td></td>
        </tr>
    </tbody>
</table>

<br>

<div class="card">
    <div class="card-header">
        <h6>Integrantes Comisión</h6>
    </div>
    <div class="card-body">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Unidad Organizacional</th>
                  <th>Cargo</th>
                  <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($technicalEvaluation->commission as $commission)
                <tr>
                    <td>{{ $commission->user->FullName }}</td>
                    <td>{{ $commission->user->organizationalUnit->name }}</td>
                    <td>{{ $commission->job_title }}</td>
                    <td>
                        <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.commission.destroy', $commission) }}">
                            @csrf
                            @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('¿Está seguro que desea eliminar el Integrante de Comisión?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @livewire('replacement-staff.commission', ['users' => $users,
                                                   'technicalEvaluation' => $technicalEvaluation])
    </div>

    <br>

</div>

@endsection

@section('custom_js')

@endsection
