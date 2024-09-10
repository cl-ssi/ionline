@extends('layouts.bt4.app')

@section('title', 'Integridad')

@section('content')

@include('integrity.partials.nav')

<h3>Administrador: Registro de ingresos</h3>

@livewire('parameters.parameter.single-manager',[
    'module' => 'integrity',
    'parameter' => 'email',
    'type' => 'value'
])

<table class="table">
    <thead>
        <tr>
            <th>N°</th>
            <th>Fecha de consulta</th>
            <th>Tipo de Consulta</th>
            <th>Valor/Principio</th>
            <th>Autor</th>

            <th>Contenido de la consulta</th>
        </tr>
    </thead>
    <tbody>
        @foreach($complaints as $complaint)
        <tr>
            <td><a href="{{ route('integrity.complaints.show',$complaint->id) }}" class="btn btn-primary btn-sm">{{ $complaint->id }}</a></td>
            <td nowrap>{{ $complaint->created_at }}</td>
            <td>{{ $complaint->type }}</td>
            <td>{{ $complaint->value->name }} {{ $complaint->other_value }} / {{ $complaint->principle->name }}</td>
            <td>{{ $complaint->user_id }}</td>
            <td>{{ $complaint->content }}
                @if($complaint->file)
                    <a href="{{ route('integrity.complaints.download', $complaint->id) }}"> <i class="fas fa-paperclip"></i></a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $complaints->links() }}

@endsection
