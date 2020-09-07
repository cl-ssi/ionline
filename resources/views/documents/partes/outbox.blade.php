@extends('layouts.app')

@section('title', 'Bandeja de salida')

@section('content')

@include('documents.partes.partials.nav')

<h3 class="mb-3">Bandeja de salida</h3>

<form method="GET" class="form-horizontal" action="{{ route('documents.partes.outbox') }}">

    <div class="row">
        <fieldset class="form-group col-1">
            <label for="for_id">Cód Int</label>
            <input type="text" class="form-control" id="for_id" name="id">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_type">Tipo</label>
            <input type="text" class="form-control" id="for_type" name="type">
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_subject">Materia</label>
            <input type="text" class="form-control" id="for_subject" name="subject">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_number">Número</label>
            <input type="text" class="form-control" id="for_number" name="number">
        </fieldset>


        <fieldset class="form-group col-3">
            <label for="for_user_id">Usuario</label>
            <select name="user_id" id="for_user_id" class="form-control">
                <option value=""></option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->fullName }}</option>
                @endforeach
            </select>
        </fieldset>


        <button type="submit" class="btn btn-primary mt-4 mb-3"><i class="fas fa-search"></i></button>

    </div>



</form>


<h3 class="mt-3">Todos los partes</h3>


<table class="table table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th>NI</th>
            <th>N°</th>
            <th>Fecha</th>
            <th>Tipo</th>
            <th>Antec</th>
            <th>Responsable</th>
            <th></th>
            <!--<th>subject</th>
            <th>greater_hierarchy</th>
            <th>distribution</th>
            <th>content</th>
            <th>file</th>
            <th>user_id</th>
            <th>organizational_unit_id</th>
            <th>created_at</th>
            -->
        </tr>
    </thead>
    <tbody>
        @foreach($documents as $document)
        <tr>
            <td rowspan="2">{{ $document->id }}</td>
            <td>{{ $document->number }}</td>
            <td nowrap>{{ $document->date ? $document->date->format('d-m-Y'): '' }}</td>
            <td>{{ $document->type }}</td>
            <td>{{ $document->antecedent }}</td>
            <td>{{ $document->responsible }}</td>
            <!--<td>{{ $document->subject }}</td>
            <td>{{ $document->greater_hierarchy }}</td>
            <td>{{ $document->distribution }}</td>
            <td>{{ $document->content }}</td>
            <td>{{ $document->file }}</td>
            <td>{{ $document->user_id }}</td>
            <td>{{ $document->organizational_unit_id }}</td>
            <td>{{ $document->created_at }}</td>
            <td>{{ $document->updated_at }}</td>-->
            <td nowrap>
                @if($document->file)
                    <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="fas fa-file-pdf fa-lg"></i>
                    </a>
                @else
                    <form method="POST" action="{{ route('documents.find')}}">
                        @csrf
                        <button name="id" value="{{ $document->id }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-upload"></i>
                        </button>
                    </form>
                @endif
            </td>

        </tr>
        <tr>
            <td colspan="7" class="pb-2">{{ $document->subject }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $documents->render() }}

@endsection

@section('custom_js')
<script type="text/javascript">
    $('[data-toggle="tooltip"]').tooltip()
</script>
@endsection
