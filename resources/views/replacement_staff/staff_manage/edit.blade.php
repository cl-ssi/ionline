@extends('layouts.bt4.app')

@section('title', 'Mantenedor de Perfiles')

@section('content')

@include('replacement_staff.nav')

<!-- <h5><i class="fas fa-cog"></i> Staff de Reemplazos por Unidad Organizacional.</h5> -->

<div class="row">
    <div class="col-sm-6">
        <h5><i class="fas fa-cog"></i> Staff de Reemplazos por Unidad Organizacional.</h5>
        <h6>{{ $staffManageByOu->first()->organizationalUnit->name }}</h6>
    </div>
    <div class="col-sm-6">
        <a class="btn btn-primary" href="{{ route('replacement_staff.staff_manage.create') }}" role="button"><i class="fas fa-plus"></i> Nuevo</a>
    </div>
</div>

<br>

</div>

    <div class="col">
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
                <thead class="text-center small">
                    <tr>
                        <th style="width: 8%">Ingreso Antecedentes</th>
                        <th>Nombre Completo</th>
                        <th>Run</th>
                        <th>Estamento</th>
                        <th>Título</th>
                        <th>Experiencia</th>
                        <th>Estado</th>
                        <th style="width: 8%">Más...</th>
                    </tr>
                </thead>
                <tbody class="small">
                  @foreach($staffManageByOu as $staffManage)
                    <tr>
                        <td>{{ $staffManage->replacementStaff->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $staffManage->replacementStaff->fullName }}</td>
                        <td>{{ $staffManage->replacementStaff->Identifier }}</td>
                        <td>
                            @foreach($staffManage->replacementStaff->profiles as $title)
                                <h6><span class="badge rounded-pill bg-light">{{ $title->profile_manage->name }}</span></h6>
                            @endforeach
                        </td>
                        <td>
                            @foreach($staffManage->replacementStaff->profiles as $title)
                                <h6><span class="badge rounded-pill bg-light">{{ ($title->profession_manage) ? $title->profession_manage->name : '' }}</span></h6>
                            @endforeach
                        </td>
                        <td>
                            @foreach($staffManage->replacementStaff->profiles as $title)
                                <h6><span class="badge rounded-pill bg-light">{{ $title->ExperienceValue }}</span></h6>
                            @endforeach
                        </td>
                        <td>{{ $staffManage->replacementStaff->StatusValue }}</td>
                        <td>
                            <a href="{{ route('replacement_staff.show_replacement_staff', $staffManage->replacementStaff) }}"
                              class="btn btn-outline-secondary btn-sm"
                              title="Ir" target="_blank"> <i class="far fa-eye"></i></a>
                            <a href="{{ route('replacement_staff.staff_manage.destroy',
                                ['organizational_unit_id' => $staffManageByOu->first()->organizationalUnit->id,
                                 'replacement_staff_id' => $staffManage->replacementStaff->id ]) }}"
                              class="btn btn-outline-danger btn-sm"
                              onclick="return confirm('¿Está seguro que desea eliminar el Integrante del Staff?')"> <i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('custom_js')

@endsection
