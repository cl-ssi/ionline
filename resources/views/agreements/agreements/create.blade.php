@extends('layouts.app')

@section('title', 'Nuevo convenio')

@section('content')

@include('agreements/nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

<h3 class="mb-3">Nuevo convenio</h3>

<div class="form-row">
    <div class="form-group custom-control custom-radio custom-control-inline">
        <input type="radio" id="customRadioInline1" name="customRadioInline" class="custom-control-input" value="agreement" checked>
        <label class="custom-control-label" for="customRadioInline1">Convenio de ejecución</label>
    </div>
    <div class="form-group custom-control custom-radio custom-control-inline">
        <input type="radio" id="customRadioInline2" name="customRadioInline" class="custom-control-input" value="agreement2">
        <label class="custom-control-label" for="customRadioInline2">Convenio retiro voluntario</label>
    </div>
</div>
<!-- agreement form -->
<div id="agreement">
    <form method="POST" class="form-horizontal small" action="{{ route('agreements.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="forcommune">Comuna</label>
                <select name="commune_id" id="formcommune" class="form-control" required>
                    <option value="">Seleccione comuna</option>
                    @foreach($communes as $commune)
                    <option value="{{ $commune->id }}">{{ $commune->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-9">
                <label for="forprogram">Programa</label>
                <select name="program_id" id="formprogram" class="form-control selectpicker" data-live-search="true" title="Seleccione programa" required>
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
        <div class="form-row">
            <fieldset class="form-group col-12">
                <label for="forrepresentative">Director/a a cargo quien firmará convenio</label>
                <select name="director_signer_id" class="form-control selectpicker" title="Seleccione..." required>
                    @foreach($signers as $signer)
                    <option value="{{$signer->id}}">{{$signer->appellative}} {{$signer->user->fullName}}, {{$signer->decree}}</option>
                    @endforeach
                </select>
            </fieldset>
        </div>
        <button type="submit" class="btn btn-primary mb-4">Guardar</button>
    </form>
</div>

<div id="agreement2">
    <form method="POST" class="form-horizontal small" action="{{ route('agreements.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <fieldset class="form-group col-3">
                <label for="forcommune">Comuna</label>
                <select name="commune_id" id="formcommune" class="form-control" required>
                    <option value="">Seleccione comuna</option>
                    @foreach($communes as $commune)
                    <option value="{{ $commune->id }}">{{ $commune->name }}</option>
                    @endforeach
                </select>
            </fieldset>
            <fieldset class="form-group col-2">
                <label for="fordate">Fecha</label>
                <input type="date" class="form-control" id="fordate" name="date" required="">
            </fieldset>
            <fieldset class="form-group col-1">
                <label for="forquotas">N° de cuotas</label>
                <input type="integer" class="form-control" id="forquotas" name="quotas" min="1" required="">
            </fieldset>
            <fieldset class="form-group col-2">
                <label for="fortotal_amount">Monto total</label>
                <input type="integer" class="form-control" id="fortotal_amount" name="total_amount" min="100" required="">
            </fieldset>
            <fieldset class="form-group col-4">
                <label for="forreferente">Referente Técnico</label>
                <select name="referrer_id" class="form-control selectpicker" data-live-search="true" title="Seleccione referente" required>
                    @foreach($referrers as $referrer)
                    <option value="{{$referrer->id}}">{{$referrer->fullName}}</option>
                    @endforeach
                </select>
            </fieldset>
        </div>
        <div class="form-row">
            <fieldset class="form-group col-12">
                <label for="forrepresentative">Director/a a cargo quien firmará convenio</label>
                <select name="director_signer_id" class="form-control selectpicker" title="Seleccione..." required>
                    @foreach($signers as $signer)
                    <option value="{{$signer->id}}">{{$signer->appellative}} {{$signer->user->fullName}}, {{$signer->decree}}</option>
                    @endforeach
                </select>
            </fieldset>
        </div>
        <button type="submit" class="btn btn-primary mb-4">Guardar</button>
    </form>
</div>


@endsection

@section('custom_js')
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/show_hide_tab.js') }}"></script>
<script>
    $('#agreement2').hide();

    $('input[type=radio][name=customRadioInline]').change(function() {
        if (this.value == 'agreement') {
            $('#agreement').show();
            $('#agreement2').hide().prop('required', false);
        } else if (this.value == 'agreement2') {
            $('#agreement').hide().prop('required', false);
            $('#agreement2').show();
        }
    });
</script>
@endsection