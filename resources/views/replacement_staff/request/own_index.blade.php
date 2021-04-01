@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<h4 class="mb-3">Mis Solicitudes</h4>

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
  <table class="table small table-striped">
      <thead>
          <tr>
              <th>#</th>
              <th>Cargo</th>
              <th>Grado</th>
              <th>Calidad Jurídica</th>
              <th>Desde</th>
              <th>Hasta</th>
              <th>Fundamento</th>
              <th>Solicitante</th>
              <th></th>
          </tr>
      </thead>
      <tbody>
          @foreach($my_request as $request)
          <tr>
              <td>{{ $request->id }}</td>
              <td>{{ $request->name }}</td>
              <td>{{ $request->degree }}</td>
              <td>{{ $request->LegalQualityValue }}</td>
              <td>{{ Carbon\Carbon::parse($request->start_date)->format('d-m-Y') }}</td>
              <td>{{ Carbon\Carbon::parse($request->end_date)->format('d-m-Y') }}</td>
              <td>{{ $request->FundamentValue }}</td>
              <td>{{ $request->user->FullName }}<br>
                  {{ $request->organizationalUnit->name }}
              </td>
              <td>
                  <button type="submit" class="btn btn-sm btn-outline-secondary">
                      <i class="fas fa-edit"></i>
                  </button>
              </td>
          </tr>
          @endforeach
      </tbody>
  </table>

  {{ $my_request->links() }}

</div>
@endsection

@section('custom_js')

@endsection
