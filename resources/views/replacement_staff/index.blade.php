@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<p>
    <a class="btn btn-primary" data-toggle="collapse" href="#collapseSearch" role="button" aria-expanded="false" aria-controls="collapseExample">
      <i class="fas fa-search"></i> Busqueda
    </a>
</p>
<div class="collapse" id="collapseSearch">
  <div class="card card-body">
      <form method="GET" class="form-horizontal" action="{{ route('replacement_staff.index') }}">
          <div class="form-row">
              <fieldset class="form-group col-4">
                  <label for="for_name">Nombres</label>
                  <input class="form-control" type="text" name="search" autocomplete="off" style="text-transform: uppercase;" placeholder="RUN (sin dígito verificador) / NOMBRE" value="{{$request->search}}">
              </fieldset>

              <fieldset class="form-group col-4">
                  <label for="for_profile_search">Estamento</label>
                  <select name="profile_search" class="form-control">
                      <option value="0">Seleccione...</option>
                          @foreach($profileManage as $profile)

                              <option value="{{ $profile->id }}" {{ ($request->profile_search == $profile->id)?'selected':'' }}>{{ $profile->Name }}</option>
                          @endforeach
                  </select>
              </fieldset>

              <fieldset class="form-group col-4">
                  <label for="for_profession_search">Profesión</label>
                  <select name="profession_search" class="form-control">
                      <option value="0">Seleccione...</option>
                          @foreach($professionManage as $profession)
                              <option value="{{ $profession->id }}" {{ ($request->profession_search == $profession->id)?'selected':'' }}>{{ $profession->Name }}</option>
                          @endforeach
                  </select>
              </fieldset>

              <button type="submit" class="btn btn-primary float-right">Guardar</button>
          </div>
      </form>
  </div>
</div>



<!-- <div class="col">
    <form method="GET" class="form-horizontal" action="{{ route('replacement_staff.index') }}">
        <div class="input-group">
            <input class="form-control" type="text" name="search" autocomplete="off" style="text-transform: uppercase;" placeholder="RUN (sin dígito verificador) / NOMBRE" value="{{$request->search}}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
            </div>
        </div>

        <fieldset class="form-group col mt">
            <label for="for_profile_search">Estamento</label>
            <select name="profile_search" class="form-control">
                <option value="0">Seleccione...</option>
                @foreach($profileManage as $profile)
                    <option value="{{ $profile->id }}" {{ ($request->profile_manage_id == $profile->id)?'selected':'' }}>{{ $profile->Name }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col mt">
            <label for="for_profession_search">Profesión</label>
            <select name="profession_search" class="form-control">
                <option value="0">Seleccione...</option>
                @foreach($professionManage as $profession)
                    <option value="{{ $profile->id }}">{{ $profession->Name }}</option>
                @endforeach
            </select>
        </fieldset>
    </form>
</div> -->

<br>

<table class="table small">
    <thead>
        <tr>
            <th>Nombre Completo</th>
            <th>Run</th>
<<<<<<< HEAD
            <th>Estamento</th>
            <th>Título</th>
            <th>Fecha Titulación</th>
            <th>Años Exp.</th>
=======
            <th>Título(s)</th>
            <th>Título(s)</th>
>>>>>>> 539da8e8e542e1d290d46553965be9205565d2f6
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
                    <h6><span class="badge rounded-pill bg-light">{{ $title->profile_manage->name }}</span></h6>
                @endforeach
            </td>
            <td>
                @foreach($staff->profiles as $title)
                    <h6><span class="badge rounded-pill bg-light">{{ $title->profession_manage->name }}</span></h6>
                @endforeach
            </td>
            <td>
                @foreach($staff->profiles as $title)
                    <h6><span class="badge rounded-pill bg-light">{{ Carbon\Carbon::parse($title->degree_date)->format('d-m-Y') }}</span></h6>
                @endforeach
            </td>
            <td>@foreach($staff->profiles as $title)
                <h6><span class="badge rounded-pill bg-light">{{ $title->YearsOfDegree }}</span></h6>
            @endforeach</td>
            <td>{{ $staff->StatusValue }}</td>
            <td>
<<<<<<< HEAD
                <a href="{{ route('replacement_staff.edit', $staff) }}"
                  class="btn btn-outline-secondary btn-sm"
                  title="Ir"> <i class="far fa-eye"></i></a>
                <a href="{{ route('replacement_staff.show_file', $staff) }}"
                  class="btn btn-outline-secondary btn-sm"
                  title="Ir"
                  target="_blank"> <i class="far fa-file-pdf"></i></a>
=======
                <a href="{{ route('replacement_staff.edit', $staff) }}" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a>
>>>>>>> 539da8e8e542e1d290d46553965be9205565d2f6
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

{{ $replacementStaff->links() }}

@endsection

@section('custom_js')

@endsection
