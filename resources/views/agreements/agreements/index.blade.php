@extends('layouts.app')

@section('title', 'Listado de Convenios')

@section('content')

@include('agreements/nav')

<h3 class="mb-3">Listado de Convenios</h3>

<table class="table">
    <thead>
        <tr class="small">
            <th>Id</th>
            <th>Comuna</th>
            <th nowrap>N°. Res.</th>
            <th nowrap>Fecha Res.</th>
            <th>Convenio</th>
            <th>Componentes</th>
            <th>Monto</th>
            <th>Ingresado</th>
            <th></th>
            <!--<th></th>-->
        </tr>
    </thead>

        <tbody>
            @foreach($agreements as $agreement)
            <tr class="small">
                <td>{{ $agreement->id }}</td>
                <td>{{ $agreement->commune->name }}</td>
                <td>{{ $agreement->number }} <a href="#"><i class="fas fa-paperclip"></i></a></td>
                <td nowrap>{{ $agreement->resolution_date ? \Carbon\Carbon::parse($agreement->resolution_date)->format('d-m-Y') : null }}</td>
                <td>{{ $agreement->program->name }}</td>
                <td class="small">
                    <ul>
                    @foreach($agreement->agreement_amounts as $amount)
                        <li>{{ $amount->program_component->name }}</li>
                    @endforeach
                    </ul>
                </td>
                <td nowrap>@numero($agreement->agreement_amounts->sum('amount'))</td>
                <td nowrap>{{ \Carbon\Carbon::parse($agreement->created_at)->format('d-m-Y') }}</td>
                <td><a href="{{ route('agreements.show', $agreement->id) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit"></i></a></td>
                <!--<td> <a href="{{-- route('agreements.accountability.index', $agreement) --}}">Comuna</a></td>-->
            </tr>
            @endforeach
        </tbody>

</table>


@endsection

@section('custom_js')

@endsection
