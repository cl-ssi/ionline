@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<h4 class="mb-3">Solicitudes de mi Unidad Organizacional: <small>{{ Auth::user()->organizationalUnit->name }}</small></h4>

<p>
    <a class="btn btn-primary" href="{{ route('replacement_staff.request.create') }}">
        <i class="fas fa-plus"></i> Agregar nuevo</a>
    <a class="btn btn-primary" data-toggle="collapse" href="#collapseSearch" role="button" aria-expanded="false" aria-controls="collapseExample">
        <i class="fas fa-filter"></i> Filtros
    </a>
</p>

<div class="collapse" id="collapseSearch">
  <br>
  <div class="card card-body">
      <form method="GET" class="form-horizontal" action="{{ route('replacement_staff.index') }}">
          <div class="form-row">
              En Desarrollo
          </div>
      </form>
  </div>
</div>

</div>

<br>

<div class="col">
  <table class="table small table-striped table-bordered">
      <thead class="text-center">
          <tr>
              <th>#</th>
              <th>Cargo</th>
              <th>Grado</th>
              <th>Calidad Jurídica</th>
              <th>Periodo</th>
              <th>Fundamento</th>
              <th>Solicitante</th>
              <th>Estado</th>
              <th></th>
          </tr>
      </thead>
      <tbody>
          @foreach($ou_request as $request)
          <tr>
              <td>{{ $request->id }}</td>
              <td>{{ $request->name }}</td>
              <td class="text-center">{{ $request->degree }}</td>
              <td class="text-center">{{ $request->LegalQualityValue }}</td>
              <td>{{ Carbon\Carbon::parse($request->start_date)->format('d-m-Y') }} <br>
                  {{ Carbon\Carbon::parse($request->end_date)->format('d-m-Y') }}
              </td>
              <td>{{ $request->FundamentValue }}</td>
              <td>{{ $request->user->FullName }}<br>
                  {{ $request->organizationalUnit->name }}
              </td>
              <td class="text-center">
                  @foreach($request->RequestSign as $sign)
                      @if($sign->request_status == 'pending' || $sign->request_status == NULL)
                          <i class="fas fa-clock fa-2x" title="{{ $sign->organizationalUnit->name }}"></i>
                      @endif
                      @if($sign->request_status == 'accepted')
                          <i class="fas fa-check-circle fa-2x" title="{{ $sign->organizationalUnit->name }}"></i>
                      @endif
                      @if($sign->request_status == 'rejected')
                          <i class="fas fa-times-circle fa-2x" title="{{ $sign->organizationalUnit->name }}"></i>
                      @endif
                  @endforeach
              </td>
              <td>
                  @if($request->RequestSign->first()->request_status != 'pending')
                  <a href="{{ route('replacement_staff.request.edit', $request) }}"
                      class="btn btn-outline-secondary btn-sm disabled" title="Selección"><i class="fas fa-edit"></i></a>
                  @else
                  <a href="{{ route('replacement_staff.request.edit', $request) }}"
                      class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-edit"></i></a>
                  @endif
              </td>
          </tr>
          @endforeach
      </tbody>
  </table>

  {{ $ou_request->links() }}

</div>

@endsection

@section('custom_js')

@endsection
