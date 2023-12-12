@extends('layouts.bt4.app')

@section('title', 'Cambiar Password')

@section('content')

    <div class="row justify-content-md-center">

        <div class="col-md-auto">

            <h3>Cambiar clave actual</h3>

            <form method="POST"
                action="{{ route('rrhh.users.password.update') }}">
                {{ method_field('PUT') }} {{ csrf_field() }}

                <div class="form-group">
                    <label for="forClave">Clave Actual</label>
                    <input type="password"
                        name="password"
                        id="forClave"
                        placeholder="Clave Actual"
                        required="required"
                        autofocus
                        autocomplete="off"
                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
                    @if ($errors->has('password'))
                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="forClave">Nueva Clave</label>
                    <input type="password"
                        name="newpassword"
                        id="forNuevaClave"
                        placeholder="Nueva Clave"
                        required="required"
                        class="form-control {{ $errors->has('newpassword') ? 'is-invalid' : '' }}">
                    @if ($errors->has('newpassword'))
                        <div class="invalid-feedback">{{ $errors->first('newpassword') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="forNuevaClaveConfirm">Confirmar Nueva Clave</label>
                    <input type="password"
                        name="newpassword_confirm"
                        id="forNuevaClaveConfirm"
                        placeholder="Confirmar Nueva Clave"
                        required="required"
                        class="form-control {{ $errors->has('newpassword_confirm') ? 'is-invalid' : '' }}">
                    @if ($errors->has('newpassword_confirm'))
                        <div class="invalid-feedback">{{ $errors->first('newpassword_confirm') }}</div>
                    @endif
                </div>

                <input type="submit"
                    name=""
                    class="btn btn-primary"
                    value="Cambiar Clave Actual">

            </form>

            <br>
            <br>
            <hr class="m-0">
            <br>
            <br>
            <h3>Crear una nueva clave aleatoria</h3>

            <div class="alert alert-info">
                Importante: No comparta su clave y utilice una clave segura.
            </div>

            @livewire('rrhh.create-new-password')

        </div>

    </div>
@endsection
