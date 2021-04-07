@extends('layouts.app')

@section('title', 'Verificar documento firmado')

@section('content')

    <h3 class="mb-3">Verificar documento firmado</h3>

    <form method="GET" action="{{route('documents.signatures.verify')}}">

        <div class="form-row">
            <div class="form-group col-4">
                <label for="for_name">ID:</label>
                <input type="text" class="form-control" id="for_id" placeholder="Ingresar id del documento" name="id" required>
            </div>
            <div class="form-group col-4">
                <label for="for_verification_code">Código de verificación:</label>
                <input type="text" class="form-control" id="for_verification_code" placeholder="Ingrese código de verificación del documento." name="verification_code" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" >Verificar</button>

    </form>

@endsection

@section('custom_js')

@endsection
