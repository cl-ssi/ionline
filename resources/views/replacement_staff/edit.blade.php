@extends('layouts.app')

@section('title', 'Nuevo Staff')

@section('content')

@include('replacement_staff.nav')

<h5>Edición de Staff</h5>

<br>

<form method="POST" class="form-horizontal" action="">
    @csrf
    @method('POST')
    <div class="form-row">
        <fieldset class="form-group col-sm-2">
            <label for="for_run">RUT</label>
            <input type="text" class="form-control" name="run" id="for_run" value="{{ $replacementStaff->run }}" readonly>
        </fieldset>
        <fieldset class="form-group col-sm-1">
            <label for="for_dv">DV</label>
            <input type="text" class="form-control" name="dv" id="for_dv" value="{{ $replacementStaff->dv }}" readonly>
        </fieldset>

        <fieldset class="form-group col-sm-3">
            <label for="for_birthday">Fecha Nacimiento</label>
            <input type="date" class="form-control" id="for_birthday" name="birthday" value="{{ $replacementStaff->birthday }}">
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-3">
            <label for="for_name">Nombres</label>
            <input type="text" class="form-control" name="name" id="for_name" value="{{ $replacementStaff->name }}">
        </fieldset>
        <fieldset class="form-group col-3">
            <label for="for_name">Apellido Paterno</label>
            <input type="text" class="form-control" name="fathers_family" id="for_fathers_family" value="{{ $replacementStaff->fathers_family }}">
        </fieldset>
        <fieldset class="form-group col-3">
            <label for="for_name">Apellido Materno</label>
            <input type="text" class="form-control" name="mothers_family" id="for_mothers_family" value="{{ $replacementStaff->mothers_family }}">
        </fieldset>
        <fieldset class="form-group col-3">
            <label for="for_gender" >Género</label>
            <select name="gender" id="for_gender" class="form-control selectpicker" title="Seleccione...">
                <option value="male" {{ ($replacementStaff->gender == 'male')?'selected':'' }}>Masculino</option>
                <option value="female {{ ($replacementStaff->gender == 'female')?'selected':'' }}">Femenino</option>
                <option value="other" {{ ($replacementStaff->gender == 'other')?'selected':'' }}>Otro</option>
                <option value="unknown" {{ ($replacementStaff->gender == 'unknown')?'selected':'' }}>Desconocido</option>
            </select>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-6">
            <label for="for_email">Correo Electrónico</label>
            <input type="text" class="form-control" name="email" id="for_email" value="{{ $replacementStaff->email }}">
        </fieldset>
        <fieldset class="form-group col-3">
            <label for="for_telephone">Teléfono Movil</label>
            <input type="text" class="form-control" name="telephone" id="for_telephone"  placeholder="+569xxxxxxxx" value="{{ $replacementStaff->telephone }}">
        </fieldset>
        <fieldset class="form-group col-3">
            <label for="for_telephone2">Teléfono Fijo</label>
            <input type="text" class="form-control" name="telephone2" id="for_telephone2"  placeholder="572xxxxxx" value="{{ $replacementStaff->telephone2 }}">
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_commune_id">Comuna</label>
            <select name="commune" id="for_commune" class="form-control selectpicker" title="Seleccione...">
                <option value="camina" {{ ($replacementStaff->commune == 'camina')?'selected':'' }}>Camiña</option>
                <option value="colchane" {{ ($replacementStaff->commune == 'colchane')?'selected':'' }}>Colchane</option>
                <option value="huara" {{ ($replacementStaff->commune == 'huara')?'selected':'' }}>Huara</option>
                <option value="iquique" {{ ($replacementStaff->commune == 'iquique')?'selected':'' }}>Iquique</option>
                <option value="pica" {{ ($replacementStaff->commune == 'pica')?'selected':'' }}>Pica</option>
                <option value="pozo almonte" {{ ($replacementStaff->commune == 'pozo almonte')?'selected':'' }}>Pozo Almonte</option>
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_address">Dirección</label>
            <input type="text" class="form-control" name="address" id="for_address" value="{{ $replacementStaff->address }}">
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary float-right">Guardar <i class="fas fa-save"></i></button>

</form>

<br><br>

<hr>

<div class="card">
    <div class="card-header">
        <h5>Perfil Profesional:</h5>
    </div>
    <div class="card-body">
        @if($replacementStaff->profiles->count() > 0)
        <table class="table small table-striped ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Archivo</th>
                    <th style="width: 12%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($replacementStaff->profiles as $profile)
                <tr>
                    <td>{{ $profile->updated_at->format('d-m-Y H:i:s') }}</td>
                    <td>{{ $profile->profession }}</td>
                    <td>{{ $profile->file }}</td>
                    <td>
                        <button href="" class="btn btn-outline-secondary btn-sm" title="Ir" disabled> <i class="far fa-eye"></i></button>
                        <button href="" class="btn btn-outline-secondary btn-sm" title="Ir"> <i class="fas fa-paperclip"></i></button>
                        <button href="" class="btn btn-danger btn-sm" title="Ir"> <i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        @livewire('replacement-staff.profile', ['replacementStaff' => $replacementStaff])
        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
    </div>
</div>

<br>

<div class="card">
    <div class="card-header">
        <h5>Experiencia laboral</h5>
    </div>

    <div class="card-body">
        @if($replacementStaff->experiences->count() > 0)
        <table class="table small table-striped ">
            <thead>
                <tr>
                    <th style="width: 11%">Fecha Registro</th>
                    <th>Experiencia</th>
                    <th>Funciones Realizadas</th>
                    <th style="width: 15%">Contacto</th>
                    <th style="width: 12%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($replacementStaff->experiences as $experience)
                <tr>
                    <td>{{ $experience->updated_at->format('d-m-Y') }}</td>
                    <td>{{ substr($experience->previous_experience, 0, 100) }}</td>
                    <td>{{ substr($experience->performed_functions, 0, 100) }}</td>
                    <td>{{ $experience->contact_name }}<br>{{ $experience->contact_telephone }}</td>
                    <td>
                        <button href="" class="btn btn-outline-secondary btn-sm exp-modal" title="Ir" data-toggle="modal" data-target="#exampleModal-exp-{{ $experience->id }}"> <i class="far fa-eye"></i></button>
                        <button href="" class="btn btn-outline-secondary btn-sm" title="Ir"> <i class="fas fa-paperclip"></i></button>
                        <button href="" class="btn btn-danger btn-sm" title="Ir"> <i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @include('replacement_staff.modals.experience_details')
                @endforeach
            </tbody>
        </table>
        @endif

        @livewire('replacement-staff.experience', ['replacementStaff' => $replacementStaff])
    </div>
</div>

<br>

<div class="card">
    <div class="card-header">
        <h5>Perfeccionamiento / Capacitaciones</h5>
    </div>
    <div class="card-body">
        @if($replacementStaff->trainings->count() > 0)
            <table class="table small table-striped ">
                <thead>
                    <tr>
                        <td>#</td>
                        <th>Nombre de Capacitación</th>
                        <th>N° de Horas Realizadas</th>
                        <th>Certificado</th>
                        <th style="width: 12%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($replacementStaff->trainings as $training)
                    <tr>
                        <td>{{ $profile->updated_at->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $training->training_name }}</td>
                        <td>{{ $training->hours_training }}</td>
                        <td>{{ $training->file }}</td>
                        <td>
                            <button href="" class="btn btn-outline-secondary btn-sm" title="Ir" disabled> <i class="far fa-eye"></i></button>
                            <button href="" class="btn btn-outline-secondary btn-sm" title="Ir"> <i class="fas fa-paperclip"></i></button>
                            <button href="" class="btn btn-danger btn-sm" title="Ir"> <i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @livewire('replacement-staff.training', ['replacementStaff' => $replacementStaff])
    </div>

    <br>

    <div class="card">
        <div class="card-header">
            <h5>Idiomas</h5>
        </div>
        <div class="card-body">
            @if($replacementStaff->languages->count() > 0)
                <table class="table small table-striped ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Idioma</th>
                            <th>Nivel</th>
                            <th>Certificado (Si dispone)</th>
                            <th style="width: 12%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($replacementStaff->languages as $language)
                        <tr>
                            <td>{{ $profile->updated_at->format('d-m-Y H:i:s') }}</td>
                            <td>{{ $language->language }}</td>
                            <td>{{ $language->level }}</td>
                            <td>{{ $language->file }}</td>
                            <td>
                                <button href="" class="btn btn-outline-secondary btn-sm" title="Ir" disabled> <i class="far fa-eye"></i></button>
                                <button href="" class="btn btn-outline-secondary btn-sm" title="Ir"> <i class="fas fa-paperclip"></i></button>
                                <button href="" class="btn btn-danger btn-sm" title="Ir"> <i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            @livewire('replacement-staff.languages', ['replacementStaff' => $replacementStaff])
        </div>
    </div>
</div>

@endsection

@section('custom_js')

<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-select.min.css') }}">
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

<script>
    $(document).ready(function(){
       $(".exp-modal").click(function(){ // Click to only happen on announce links
         $("#cafeId").val($(this).data('id'));
         $('#createFormId').modal('show');
       });
    });
</script>

@endsection
