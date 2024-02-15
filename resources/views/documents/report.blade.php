@extends('layouts.bt5.app')

@section('title', 'Reporte de documentos')

@section('content')

@include('documents.partials.nav')

<h3 class="mb-3">
    Ranking de documentos creados en iOnline
</h3>
<h4>
    {{ auth()->user()->organizationalUnit->establishment->name }}
    :  {{ number_format($ct,0,',','.') }} documentos
</h4>

<div class="row">
    <div class="col-md-7 col-12">
        
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Por Unidad Organizacional</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            @foreach($ous as $ou)
            <tbody>
                <tr>
                    <td>{{ $ou->name }}</td>
                    <td class="text-center">{{ number_format($ou->documents_count,0,',','.') }}</td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>

    <div class="col-md-5 col-12">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Por Funcionario</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            @foreach($users as $user)
            <tbody>
                <tr>
                    <td>{{ $user->shortName }}</td>
                    <td class="text-center">{{ number_format($user->documents_count,0,',','.') }}</td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
</div>

@endsection

@section('custom_js')

@endsection
