@extends('layouts.app')

@section('title', 'Nuevo Staff')

@section('content')

@include('replacement_staff.nav')

<h5>Edición de Staff</h5>

<br>

<form method="POST" class="form-horizontal" action="{{ route('replacement_staff.update', $replacementStaff) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
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
                <option value="female" {{ ($replacementStaff->gender == 'female')?'selected':'' }}>Femenino</option>
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
                <option value="alto hospicio" {{ ($replacementStaff->commune == 'alto hospicio')?'selected':'' }}>Alto Hospicio</option>
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

    <div class="form-row">
      <fieldset class="form-group col-6">
          <label for="for_status">Disponibilidad</label>
          <select name="status" id="for_status" class="form-control selectpicker" title="Seleccione...">
              <option value="immediate_availability" {{ ($replacementStaff->status == 'immediate_availability')?'selected':'' }}>Inmediata</option>
              <option value="working_external" {{ ($replacementStaff->status == 'working_external')?'selected':'' }}>Trabajando</option>
          </select>
      </fieldset>
      <fieldset class="form-group col-5">
          <div class="mb-3">
            <label for="forcv_file" class="form-label">Actualizar Curriculum Vitae</label>
            <input class="form-control" type="file" name="cv_file" accept="application/pdf" value="{{ $replacementStaff->telephone2 }}">
          </div>
      </fieldset>
      <div class="col-1">
        <p>&nbsp;</p>
        <a href="{{ route('replacement_staff.show_file', $replacementStaff) }}"
            class="btn btn-outline-secondary btn-sm"
            title="Ir"
            target="_blank"> <i class="far fa-eye"></i></a>
        <a class="btn btn-outline-secondary btn-sm"
            href="{{ route('replacement_staff.download', $replacementStaff) }}"
            target="_blank"><i class="fas fa-download"></i>
        </a>
      </div>
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
                    <th style="width: 11%">Fecha Registro</th>
                    <th>Título</th>
                    <th>Archivo</th>
                    <th style="width: 10%"></th>
                    <th style="width: 2%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($replacementStaff->profiles as $profile)
                <tr>
                    <td>{{ $profile->updated_at->format('d-m-Y H:i:s') }}</td>
                    <td>{{ $profile->profession }}</td>
                    <td>
                      @if(pathinfo($profile->file, PATHINFO_EXTENSION) == 'pdf')
                          <i class="fas fa-file-pdf fa-2x"></i>
                      @endif
                    </td>
                    <td>
                        <a href="{{ route('replacement_staff.profile.show_file', $profile) }}"
                            class="btn btn-outline-secondary btn-sm"
                            title="Ir"
                            target="_blank"> <i class="far fa-eye"></i></a>
                        <a class="btn btn-outline-secondary btn-sm"
                            href="{{ route('replacement_staff.profile.download', $profile) }}"
                            target="_blank"><i class="fas fa-download"></i>
                        </a>
                    </td>
                    <td>
                        <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.profile.destroy', $profile) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('¿Está seguro que desea eliminar su perfil : {{$profile->profession}}? ' )">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        @livewire('replacement-staff.profile', ['replacementStaff' => $replacementStaff,
                                                'professionManage' => $professionManage,
                                                'profileManage' => $profileManage])

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
                    <th style="width: 5%"></th>
                    <th style="width: 2%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($replacementStaff->experiences as $experience)
                <tr>
                    <td>{{ $experience->updated_at->format('d-m-Y H:i:s') }}</td>
                    <td>{{ substr($experience->previous_experience, 0, 150) }}</td>
                    <td>{{ substr($experience->performed_functions, 0, 150) }}</td>
                    <td>{{ $experience->contact_name }}<br>{{ $experience->contact_telephone }}</td>
                    <td>
                        <button href="" class="btn btn-outline-secondary btn-sm exp-modal" title="Ir" data-toggle="modal" data-target="#exampleModal-exp-{{ $experience->id }}"> <i class="far fa-eye"></i></button>
                    </td>
                    <td>
                        <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.experience.destroy', $experience) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('¿Está seguro que desea eliminar su Experiencia Laboral? ' )">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
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
                        <td style="width: 11%">Fecha Registro</td>
                        <th>Nombre de Capacitación</th>
                        <th>N° de Horas Realizadas</th>
                        <th>Archivo</th>
                        <th style="width: 10%"></th>
                        <th style="width: 2%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($replacementStaff->trainings as $training)
                    <tr>
                        <td>{{ $training->updated_at->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $training->training_name }}</td>
                        <td>{{ $training->hours_training }}</td>
                        <td>
                            @if(pathinfo($training->file, PATHINFO_EXTENSION) == 'pdf')
                                <i class="fas fa-file-pdf fa-2x"></i>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('replacement_staff.training.show_file', $training) }}"
                                class="btn btn-outline-secondary btn-sm"
                                title="Ir"
                                target="_blank"> <i class="far fa-eye"></i></a>
                            <a class="btn btn-outline-secondary btn-sm"
                                href="{{ route('replacement_staff.training.download', $training) }}"
                                target="_blank"><i class="fas fa-download"></i>
                            </a>
                        </td>
                        <td>
                          <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.training.destroy', $training) }}">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-outline-danger btn-sm"
                                  onclick="return confirm('¿Está seguro que desea eliminar su Capacitación?')">
                                  <i class="fas fa-trash"></i>
                              </button>
                          </form>
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
                            <th style="width: 11%">Fecha Registro</th>
                            <th>Idioma</th>
                            <th>Nivel</th>
                            <th>Archivo</th>
                            <th style="width: 10%"></th>
                            <th style="width: 2%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($replacementStaff->languages as $language)
                        <tr>
                            <td>{{ $profile->updated_at->format('d-m-Y H:i:s') }}</td>
                            <td>{{ $language->LanguageValue }}</td>
                            <td>{{ $language->LevelValue }}</td>
                            <td>
                                @if(pathinfo($language->file, PATHINFO_EXTENSION) == 'pdf')
                                    <i class="fas fa-file-pdf fa-2x"></i>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('replacement_staff.language.show_file', $language) }}"
                                    class="btn btn-outline-secondary btn-sm"
                                    title="Ir"
                                    target="_blank"> <i class="far fa-eye"></i></a>
                                <a class="btn btn-outline-secondary btn-sm"
                                    href="{{ route('replacement_staff.language.download', $language) }}"
                                    target="_blank"><i class="fas fa-download"></i>
                                </a>
                            </td>
                            <td>
                              <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.language.destroy', $language) }}">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-outline-danger btn-sm"
                                      onclick="return confirm('¿Está seguro que desea eliminar su idioma: {{$language->LanguageValue}}?')">
                                      <i class="fas fa-trash"></i>
                                  </button>
                              </form>
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

@endsection
