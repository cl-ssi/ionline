@extends('layouts.bt4.app')

@section('title', 'Mantenedor de Perfiles')

@section('content')

@include('replacement_staff.nav')

<h5><i class="fas fa-cog"></i> Mantenedor de Profesiones.</h5>

<br>

<div class="row">
    <div class="col-sm-4">
      <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.manage.profession.store') }}">
          @csrf
          @method('POST')
          <fieldset class="form-group col">
              <label for="for_name">Nombre de Profesión</label>
                  <input type="text" class="form-control" name="name">
          </fieldset>
          <fieldset class="form-group col mt">
              <label for="for_profile_manage_id">Estamento</label>
              <select name="profile_manage_id" class="form-control" wire:model.live="profileSelected" required>
                  <option value="">Seleccione</option>
                  @foreach($profiles as $profile)
                      <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                  @endforeach
              </select>
          </fieldset>
          <button type="submit" class="btn btn-primary float-right">Guardar</button>
      </form>
    </div>

    <div class="col-sm-8">
        <br>
        <table class="table table-sm table-striped table-bordered">
            <thead class="text-center small">
                <tr>
                    <th>#</th>
                    <th>Nombre Profesión</th>
                    <th>Nombre Perfil</th>
                    <th style="width: 5%"></th>
                    <th style="width: 5%"></th>
                </tr>
            </thead>
            <tbody class="small">
                @foreach($professionManage as $key => $profession)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $profession->name }}</td>
                    <td>{{ $profession->profileManage->name }}</td>
                    <td>
                        <a href="{{ route('replacement_staff.manage.profession.edit', $profession) }}"
                          class="btn btn-outline-secondary btn-sm"
                          title="Editar"> <i class="fas fa-edit"></i></a>
                    </td>
                    <td>
                        <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.manage.profession.destroy', $profession) }}">
                            @csrf
                            @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('¿Está seguro que desea eliminar el Perfil Estamento?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

@endsection

@section('custom_js')

@endsection
