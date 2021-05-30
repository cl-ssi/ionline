@extends('layouts.app')

@section('title', 'Lista de firmantes')

@section('content')

@include('agreements/nav')

<h3 class="mb-3">Firmantes</h3>

<div class="card small">
    <div class="card-body">
        <h5>Crear nuevo firmante</h5>
        <hr>
        <form method="POST" class="form-horizontal" action="{{ route('agreements.signers.store') }}">
            @csrf
            <div class="form-row">
                <fieldset class="form-group col-2">
                    <label for="for_rut">Cargo</label>
                    <select name="appellative" class="form-control selectpicker" data-live-search="true" title="Seleccione..." required>
                        @php($appellativeOptions = array('Director', 'Directora', 'Director (S)', 'Directora (S)'))
                        @foreach($appellativeOptions as $option)
                        <option value="{{$option}}">{{$option}}</option>
                        @endforeach
                    </select>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="for_name">Nombre</label>
                    <select name="user_id" class="form-control selectpicker" data-live-search="true" title="Seleccione..." required>
                        @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->fullName}}</option>
                        @endforeach
                    </select>
                </fieldset>

                <fieldset class="form-group col-6">
                    <label for="for_address">Decreto</label>
                    <input type="text" class="form-control" id="decree" name="decree" required>
                </fieldset>

                <fieldset class="form-group col-1">
                    <label for="for_submit">&nbsp;</label>
                    <button type="submit" class="form-control btn btn-primary">Crear</button>
                </fieldset>

            </div>
        </form>
    </div>
</div>
<br>
<table class="table table-sm table-hover">
    <thead>
        <tr class="small">
            <!-- <th>Id</th> -->
            <th>Nombre</th>
            <th>Cargo</th>
            <th>Decreto</th>
            <th>Creado el</th>
        </tr>
    </thead>
    <tbody>
        @foreach($signers as $signer)
        <tr class="small">
            <!-- <td>{{$signer->id}}</td> -->
            <td>{{ $signer->user->fullName }}</td>
            <td>{{ $signer->appellative }}</td>
            <td>{{ $signer->decree }}</td>
            {{--<td><a href="{{route('agreements.signers.edit', $signer)}}"><span class="fa fa-edit"></span></a></td>--}}
            <td>{{ $signer->created_at->format('d-m-Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection