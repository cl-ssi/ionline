@extends('layouts.bt4.app')

@section('title', 'Editar funcionario/a')

@section('content')

@include('mammography.partials.nav')

<div class="card">
    <h5 class="card-header">Editar funcionario</h5>
    <div class="card-body">
        <form method="POST" class="form-horizontal" action="{{ route('mammography.update',$mammography) }}">
            @csrf
            @method('PUT')

            <div class="form-row">
                <fieldset class="form-group col-md-2">
                    <label for="for_run">Run*</label>
                    <input type="text" class="form-control" name="run"
                        id="for_run" required value="{{ $mammography->run }}" readonly>
                </fieldset>

                <fieldset class="form-group col-md-1">
                    <label for="for_dv">Digito*</label>
                    <input type="text" class="form-control" name="dv"
                        id="for_dv" required value="{{ $mammography->dv }}" readonly>
                </fieldset>

                <fieldset class="form-group col-md-3">
                    <label for="for_name">Nombre*</label>
                    <input type="text" class="form-control" name="name"
                        id="for_name" required value="{{ $mammography->name }}">
                </fieldset>

                <fieldset class="form-group col-md-3">
                    <label for="for_fathers_family">Apellido Paterno*</label>
                    <input type="text" class="form-control" name="fathers_family"
                        id="for_fathers_family" required value="{{ $mammography->fathers_family }}">
                </fieldset>

                <fieldset class="form-group col-md-3">
                    <label for="for_mothers_family">Apellido Materno*</label>
                    <input type="text" class="form-control" name="mothers_family"
                        id="for_mothers_family" required value="{{ $mammography->mothers_family }}">
                </fieldset>

            </div>

            <div class="form-row">
                <fieldset class="form-group col-md-3 ">
                    <label for="for_establishment">Establecimiento*</label>
                    <select name="establishment_id" id="for_establishment" class="form-control">
                        <option value=""></option>
                        <option value="1" {{ ($mammography->establishment_id == 1)? 'selected':'' }}>HETG</option>
                        <option value="38" {{ ($mammography->establishment_id == 38)? 'selected':'' }}>DSSI</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-md-6">
                    <label for="for_ortanizationalUnit">Unidad Organizacional</label>
                    <input type="text" class="form-control" name="ortanizationalUnit"
                        id="for_ortanizationalUnit" placeholder="unidad/depto" value="{{ $mammography->organizationalUnit }}">
                </fieldset>

                <fieldset class="form-group col-md-3">
                    <label for="for_inform_method">Informado a través</label>
                    <select name="inform_method" id="for_inform_method" class="form-control">
                        <option value=""></option>
                        <option value="1" {{ ($mammography->inform_method == 1)? 'selected':'' }}>Clave Única</option>
                        <option value="2" {{ ($mammography->inform_method == 2)? 'selected':'' }}>Teléfono</option>
                        <option value="3" {{ ($mammography->inform_method == 3)? 'selected':'' }}>Correo Electrónico</option>
                    </select>
                </fieldset>
          </div>

          <div class="float-right">
              <button type="submit" class="btn btn-primary form-control"><i class="fas fa-save"></i> Actualizar</button>
          </div>
        </form>
    </div>
</div>

    <div class="">

    {{-- @livewire('vaccination.admin-book',['vaccination' => $vaccination]) --}}

    </div>


@can('be god')
    @include('partials.audit', ['audits' => $mammography->audits()] )
@endcan

@endsection

@section('custom_js')

@endsection
