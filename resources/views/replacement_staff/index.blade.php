@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<div class="row">
    <div class="col-sm-5">
        <h4 class="mb-3">Listado de RR.HH. para Reemplazo:</h4>
    </div>
    <div class="col">
        <p>
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseSearch" role="button" aria-expanded="false" aria-controls="collapseExample">
              <i class="fas fa-filter"></i> Filtros
            </a>
        </p>
    </div>
</div>


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
                      <option value="">Seleccione...</option>
                          @foreach($profileManage as $profile)
                              <option value="{{ $profile->id }}" {{ ($request->profile_search == $profile->id)?'selected':'' }}>{{ $profile->name }}</option>
                          @endforeach
                  </select>
              </fieldset>

              <fieldset class="form-group col-4">
                  <label for="for_profession_search">Profesión</label>
                  <select name="profession_search" class="form-control">
                      <option value="">Seleccione...</option>
                          @foreach($professionManage as $profession)
                              <option value="{{ $profession->id }}" {{ ($request->profession_search == $profession->id)?'selected':'' }}>{{ $profession->name }}</option>
                          @endforeach
                  </select>
              </fieldset>

              <button type="submit" class="btn btn-primary float-right"><i class="fas fa-search"></i> Buscar</button>
          </div>
      </form>
  </div>
</div>

</div>

<div class="col">
  <div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead class="text-center small">
            <tr>
                <th>Ingreso Antecedentes</th>
                <th>Nombre Completo</th>
                <th>Run</th>
                <th>Estamento</th>
                <th>Título</th>
                <th>Experiencia</th>
                <th>Fecha Titulación</th>
                <th>Años Exp.</th>
                <th>Estado</th>
                <!-- <th>Periodo Efectivo</th> -->
                <th style="width: 8%"></th>
            </tr>
        </thead>
        <tbody class="small">
            @foreach($replacementStaff as $staff)
            <tr>
                <td>{{ $staff->created_at->format('d-m-Y H:i:s') }}</td>
                <td>{{ $staff->FullName }}</td>
                <td>{{ $staff->Identifier }}</td>
                <td>
                    @foreach($staff->profiles as $title)
                        <h6><span class="badge rounded-pill bg-light">{{ $title->profile_manage->name }}</span></h6>
                    @endforeach
                </td>
                <td>
                    @foreach($staff->profiles as $title)
                        <h6><span class="badge rounded-pill bg-light">{{ ($title->profession_manage) ? $title->profession_manage->name : '' }}</span></h6>
                    @endforeach
                </td>
                <td>
                    @foreach($staff->profiles as $title)
                        <h6><span class="badge rounded-pill bg-light">{{ $title->ExperienceValue }}</span></h6>
                    @endforeach
                </td>
                <td class="text-center">
                    @foreach($staff->profiles as $title)
                        <h6><span class="badge rounded-pill bg-light">
                            {{ ($title->degree_date) ? $title->degree_date->format('d-m-Y') : ''}}
                        </span></h6>
                    @endforeach
                </td>
                <td class="text-center">
                    @foreach($staff->profiles as $title)
                        <h6><span class="badge rounded-pill bg-light">{{ $title->YearsOfDegree }}</span></h6>
                    @endforeach
                </td>
                <td>{{ $staff->StatusValue }}</td>
                <!-- <td>{{-- $staff->applicants->first()->start_date->format('d-m-Y') --}}</td> -->
                <td>
                    <a href="{{ route('replacement_staff.show_replacement_staff', $staff) }}"
                      class="btn btn-outline-secondary btn-sm"
                      title="Ir"> <i class="far fa-eye"></i></a>
                    <a href="{{ route('replacement_staff.view_file', $staff) }}"
                      class="btn btn-outline-secondary btn-sm"
                      title="Ir"
                      target="_blank"> <i class="far fa-file-pdf"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
  </div>
</div>

<div class="col">
  {{ $replacementStaff->appends(request()->input())->links() }}
</div>

@endsection

@section('custom_js')

@endsection
