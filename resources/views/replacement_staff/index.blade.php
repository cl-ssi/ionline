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
<<<<<<< HEAD
            <th>Título</th>
            <th>Estamento</th>
            <th>Fecha Titulación</th>
            <th>Años Exp.</th>
=======
            <th>Título(s)</th>
            <th>Título(s)</th>
>>>>>>> a314611949986f8893932bbaf23d1bd68b00be16
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($replacementStaff as $staff)
        <tr>
            <td>{{ $staff->FullName }}</td>
            <td>{{ $staff->Identifier }}</td>
<<<<<<< HEAD
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
=======
            <td>
                @foreach($staff->profiles as $title)
                    <span class="badge rounded-pill bg-secondary">{{ $title->profession }}</span>
                @endforeach
            </td>
            <td>{{ $staff->StatusValue }}</td>
>>>>>>> a314611949986f8893932bbaf23d1bd68b00be16
            <td>
                <a href="{{ route('replacement_staff.edit', $staff) }}"
                  class="btn btn-outline-secondary btn-sm"
                  title="Ir"> <i class="far fa-eye"></i></a>
                <a href=""
                  class="btn btn-outline-secondary btn-sm"
                  title="Ir"
                  target="_blank"> <i class="far fa-file-pdf"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

{{ $replacementStaff->links() }}

@endsection

@section('custom_js')

@endsection
