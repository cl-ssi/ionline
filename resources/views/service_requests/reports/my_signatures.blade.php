@extends('layouts.bt4.app')

@section('title', 'Reporte de contrato')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Mis Visaciones</h3>

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.report.my-signatures') }}">
    <div class="form-row">

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_users">Funcionario</label>
            <div>
                @livewire('search-select-user', ['selected_id' => 'user_id', 'user' => $user])
            </div>
        </fieldset>

        <fieldset class="form-group col-4 col-md-3">
            <label for="for_type">Tipo</label>
            <select name="type" class="form-control" required>
                <option value="Pendientes" @selected($request->type == "Pendientes")>Pendientes</option>
                <option value="Visadas" @selected($request->type == "Visadas")>Visadas</option>
                <option value="Todas" @selected($request->type == "Todas")>Todas</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-4 col-md-3">
            <label for="for_year">Año</label>
            <select name="year" class="form-control" required>
                <option value=""></option>
                <option value="2020" @selected($request->year == 2020)>2020</option>
                <option value="2021" @selected($request->year == 2021)>2021</option>
                <option value="2022" @selected($request->year == 2022)>2022</option>
                <option value="2023" @selected($request->year == 2023)>2023</option>
                <option value="2024" @selected($request->year == 2024)>2024</option>
                <option value="2025" @selected($request->year == 2025)>2025</option>
            </select>
        </fieldset>

         <fieldset class="form-group col-5 col-md-2">
            <label for="">&nbsp;</label>
            <button type="submit" class="form-control btn btn-primary"><i class="fas fa-search"></i></button>
        </fieldset>

    </div>

</form>

<hr>

@if($serviceRequests)
    <table class="table table-sm table-bordered table-stripped" id="table_overlapping">
        <tr>
            <th>Id</th>    
            <th>Fecha Solicitud</th>
            <th>Fecha Inicio</th>
            <th>Fecha de Término</th>
            <th>Funcionario</th>
        </tr>
        @foreach($serviceRequests as $key => $serviceRequest)
        <tr>
            <td>
            <a href="{{ route('rrhh.service-request.edit', $serviceRequest) }}" target="blank">
                {{$serviceRequest->id?? ''}}
            <a>
            </td>
            <td nowrap>{{$serviceRequest->request_date->format('d-m-Y')}}</td>
            <td nowrap>{{$serviceRequest->start_date->format('d-m-Y')}}</td>
            <td nowrap>{{$serviceRequest->end_date->format('d-m-Y')}}</td>
            <td>{{$serviceRequest->employee->shortName}}</td>
        </tr>
        @endforeach
    </table>

    {{ $serviceRequests->appends(request()->query())->links() }}
@endif

@endsection

@section('custom_js')

@endsection
