@extends('layouts.app')

@section('title', 'Nuevo convenio')

@section('content')

@include('agreements/nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

<h3 class="mb-3">Nuevo convenio</h3>

<!--<div class="form-row">
    <div class="form-group custom-control custom-radio custom-control-inline">
        <input type="radio" id="customRadioInline1" name="customRadioInline" class="custom-control-input" value="agreement" checked>
        <label class="custom-control-label" for="customRadioInline1">Convenio de ejecución</label>
    </div>
    <div class="form-group custom-control custom-radio custom-control-inline">
        <input type="radio" id="customRadioInline2" name="customRadioInline" class="custom-control-input" value="agreement2">
        <label class="custom-control-label" for="customRadioInline2">Convenio retiro voluntario</label>
    </div>
</div>-->
<!-- agreement form -->

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
        <fieldset id="agreement" class="form-group col-4">
            <label for="forquotas">Cuotas</label>
            <select name="quota_id" id="forquotas" class="form-control" required>
                <option value="">Seleccione cuotas</option>
                @foreach($quota_options as $quota_option)
                <option value="{{ $quota_option['id'] }}">{{ $quota_option['name'] }}</option>
                @endforeach
            </select>
        </fieldset>
        <fieldset id="agreement2" class="form-group col-2">
            <label for="forquotas2">N° de cuotas</label>
            <input type="integer" class="form-control text-right" id="forquotas2" name="quotas" min="1" required="">
        </fieldset>
        <fieldset id="agreement2_1" class="form-group col-2">
            <label for="fortotal_amount">Monto total</label>
            <input type="integer" class="form-control text-right" id="fortotal_amount" name="total_amount" min="100" required="">
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

@endsection

@section('custom_js')
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/show_hide_tab.js') }}"></script>
<script>
    $('#agreement2,#agreement2_1').hide();
    $('#forquotas2,#fortotal_amount').prop('required', false);

    $('select[name=program_id]').change(function() {
        if (this.value != 3) {
            $('#agreement').show();
            $('#forquotas').prop('required', true);
            $('#agreement2,#agreement2_1').hide();
            $('#forquotas2,#fortotal_amount').prop('required', false);
        } else { //retiro voluntario
            $('#agreement').hide();
            $('#forquotas').prop('required', false);
            $('#agreement2,#agreement2_1').show();
            $('#forquotas2,#fortotal_amount').prop('required', true);
        }
    });
</script>
@endsection