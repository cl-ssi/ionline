@extends('layouts.bt5.app')

@section('title', 'Usuarios con acceso al módulo')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Usuarios con acceso al módulo de drogas</h3>

<div class="row">

    <div class="col">

        <ul>
            @foreach($users as $user)
            <li>
                {{ $user->fullName }} <br>
                {!! $user->hasRole('Drogas: Jefe de unidad') ? '- Drogas: Jefe de unidad<br>': '' !!}
                {!! $user->hasRole('Drogas: Recepcionista') ? '- Drogas: Recepcionista<br>': '' !!}
                {!! $user->hasRole('Drogas: Usuario administrativo') ? '- Drogas: Usuario administrativo<br>': '' !!}
            </li>
            @endforeach
        </ul>
    </div>
    <div class="col">
        <h3 class="mb-3">Ultimos accesos {{--( $daysAgo días)--}} </h3>

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Fecha de acceso</th>
                    <th>Usuario</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($lastLogs as $log )
                <tr>
                    <td>{{ $log->created_at }}</td>
                    <td>{{ $log->user->shortName }} @if($log->user->deleted_at) <b>Eliminado</b> @endif</td>
                    <td>{{ $log->switch_id }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



@endsection

@section('custom_js')

@endsection
