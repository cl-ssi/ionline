@extends('layouts.bt4.app')

@section('title', 'Mantenedor de Perfiles')

@section('content')

@include('replacement_staff.nav')

<!-- <h5><i class="fas fa-cog"></i> Staff de Reemplazos por Unidad Organizacional.</h5> -->

<div class="row">
    <div class="col-sm-6">
        <h5><i class="fas fa-cog"></i> Staff de Reemplazos por Unidad Organizacional.</h5>
    </div>
    <div class="col-sm-6">
        <a class="btn btn-primary" href="{{ route('replacement_staff.staff_manage.create') }}" role="button"><i class="fas fa-plus"></i> Nuevo</a>
    </div>
</div>

<br>



<div class="row">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
                <thead class="text-center small">
                    <tr>
                        <th>Unidad Organizacional del Staff</th>
                        <th>Nº Integrantes</th>
                        <th style="width: 2%"></th>
                    </tr>
                </thead>
                <tbody class="small">
                  @foreach($staffManages as $staffManage)
                    <tr>
                        <td>{{ $staffManage->organizationalUnit->name }}</td>
                        <td class="text-center">{{ $staffManage->people }}</td>
                        <td>
                            <a href="{{ route('replacement_staff.staff_manage.edit',['id' => $staffManage->organizationalUnit]  ) }}"
                              class="btn btn-outline-secondary btn-sm"
                              title="Ir"> <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('custom_js')

@endsection
