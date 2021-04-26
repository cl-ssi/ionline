@extends('layouts.app')

@section('title', 'Lista de firmantes')

@section('content')

@include('agreements/nav')

<h3 class="mb-3">Firmantes</h3>

<table class="table table-sm table-hover">
    <thead>
        <tr class="small">
            <th>Orden</th>
            <th>Cargo</th>
            <th>Nombre</th>
            <th>Decreto</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($signers as $signer)
        <tr class="small">
            <td>{{$loop->iteration}}</td>
            <td>{{ $signer->appellative }}</td>
            <td>{{ $signer->user->fullName }}</td>
            <td>{{ $signer->decree }}</td>
            <td><a href="{{route('agreements.signers.edit', $signer)}}"><span class="fa fa-edit"></span></a></td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
