@extends('layouts.app')

@section('title', 'Mantenedor de Perfiles')

@section('content')

@include('replacement_staff.nav')

<h5><i class="fas fa-cog"></i> Mantenedor de Profesiones.</h5>

<br>

<div class="row">
    <div class="col-sm">
      <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.manage.profession.store') }}">
          @csrf
          @method('POST')
          <fieldset class="form-group col">
              <label for="for_name">Nombre de Profesión</label>
                  <input type="text" class="form-control" name="name">
          </fieldset>
          <button type="submit" class="btn btn-primary float-right">Guardar</button>
      </form>
    </div>

    <div class="col-sm">
        <br>
        <table class="table small">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre Perfil</th>
                    <th style="width: 5%"></th>
                    <th style="width: 5%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($professionManage as $key => $profession)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $profession->Name }}</td>
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
