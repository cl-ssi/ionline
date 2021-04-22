@extends('layouts.app')

@section('title', 'Nuevo convenio')

@section('content')

@include('agreements/nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

<h3 class="mb-3">Nuevo convenio</h3>

<form method="POST" class="form-horizontal small" action="{{ route('agreements.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="forcommune">Communa</label>
            <select name="commune_id" id="formcommune" class="form-control" required>
                <option value="">Seleccione comuna</option>
                @foreach($communes as $commune)
                    <option value="{{ $commune->id }}">{{ $commune->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-9">
            <label for="forprogram">Programa</label>
            <select name="program_id" id="formprogram" class="form-control" required>
                <option value="">Seleccione programa</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-row">

        <fieldset class="form-group col-3">
            <label for="fordate">Fecha</label>
            <input type="date" class="form-control" id="fordate" name="date" required="">
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="forquotas">Cuotas</label>
            <!-- <input type="integer" class="form-control" id="forquotas" placeholder="Número de cuotas" name="quotas" required="">
            <small> * 2 = cuotas 30% y 70% / 3 = cuotas 50%,25%,25%</small> -->
            <select name="quota_id" id="forquotas" class="form-control" required>
                <option value="">Seleccione cuotas</option>
                @foreach($quota_options as $quota_option)
                    <option value="{{ $quota_option['id'] }}">{{ $quota_option['name'] }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-5">
            <label for="forreferente">Referente Técnico</label>
            <!-- <input type="input" class="form-control" id="forreferente" name="referente" required=""> -->
             <select name="referrer_id" class="form-control selectpicker" data-live-search="true" title="Seleccione referente" required>
				@foreach($referrers as $referrer)
				<option value="{{$referrer->id}}">{{$referrer->fullName}}</option>
				@endforeach
			</select>
        </fieldset>
    </div>
    <button type="submit" class="btn btn-primary mb-4">Guardar</button>

</form>

@endsection

@section('custom_js')
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/show_hide_tab.js') }}"></script>
@endsection
