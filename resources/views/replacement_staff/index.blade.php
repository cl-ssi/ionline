@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<h5>Staff</h5>

<br>


<!-- <table class="table table-sm table-bordered small text-uppercase" style="width:50%;">
    <tbody>
        <tr>
            <td>Filtro Profesiones:</td>
            <td>
              <form method="GET" id="form" class="form-horizontal" action="#">
                <select name="filter" onchange="this.form.submit()">
                  <option value="0">Todos</option>
                  <option value="1">Enfermera</option>
                  <option value="2">Informático</option>
                </select>
              </form>
            </td>
        </tr>
        <tr>
            <td>Filtro Estado:</td>
            <td>
              <form method="GET" id="form" class="form-horizontal" action="#">
                <select name="filter" onchange="this.form.submit()">
                  <option value="0" >Todos</option>
                  <option value="1" >Disponible</option>
                </select>
              </form>
            </td>
        </tr>
    </tbody>
</table> -->


<table class="table small">
    <thead>
        <tr>
            <th>Nombre Completo</th>
            <th>Run</th>
            <th>Título(s)</th>
            <th>Título(s)</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($replacementStaff as $staff)
        <tr>
            <td>{{ $staff->FullName }}</td>
            <td>{{ $staff->Identifier }}</td>
            <td>
                @foreach($staff->profiles as $title)
                    <span class="badge rounded-pill bg-secondary">{{ $title->profession }}</span>
                @endforeach
            </td>
            <td>{{ $staff->StatusValue }}</td>
            <td>
                <a href="{{ route('replacement_staff.edit', $staff) }}" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

{{ $replacementStaff->links() }}

@endsection

@section('custom_js')

@endsection
