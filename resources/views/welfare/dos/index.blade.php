@extends('layouts.app')

@section('title', 'Carga de archivos TXT')

@section('content')

@include('welfare.nav')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Carga de archivos TXT') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('welfare.dosfile.import') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="file">{{ __('Archivo TXT') }}</label>
                            <input type="file" name="file" id="file" accept=".txt" class="form-control-file" required>


                        </div>

                        <div class="form-row">
                            <fieldset class="form-group col-md-6">
                                <label for="for_month">{{ __('Mes') }}</label>
                                <select name="month" class="form-control selectpicker @error('month') is-invalid @enderror" required>
                                    <option value=""></option>
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </fieldset>

                            <fieldset class="form-group col-md-6">
                                <label for="for_year">{{ __('Año') }}</label>
                                <select name="year" class="form-control selectpicker required>
                                    <option value=""></option>
                                    @foreach(range((now()->year)-1, now()->year) as $year)
                                    <option value=" {{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Importar datos de TXT') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection