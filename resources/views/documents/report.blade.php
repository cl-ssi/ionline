@extends('layouts.bt5.app')

@section('title', 'Reporte de documentos')

@section('content')

@include('documents.partials.nav')

<h3 class="mb-3">Reporte de documentos
    <small>Creados: <strong>{{ $ct }}</strong></small>
</h3>

<div class="row">
    <div class="col-md-6 col-12">

        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            @foreach($users as $user)
            <tbody>
                <tr>
                    <td>{{ $user->fullName }}</td>
                    <td class="text-center">{{ $user->documents_count }}</td>
                    <td class="text-center"></td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
    
    <div class="col-md-6 col-12">
        
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Unidad Organizacional</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            @foreach($ous as $ou)
            <tbody>
                <tr>
                    <td>{{ $ou->name }}</td>
                    <td class="text-center">{{ $ou->documents_count }}</td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
</div>

@endsection

@section('custom_js')

@endsection
