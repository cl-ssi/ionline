@extends('layouts.app')

@section('title', 'Mantenedor de Perfiles')

@section('content')

@include('replacement_staff.nav')

<h5><i class="fas fa-cog"></i> Mantenedor de Fundamentos de Contratación.</h5>

<div class="row">
    <div class="col-sm-12">
        <table class="table table-sm table-striped table-bordered">
            <thead class="text-center small">
                <tr>
                    <th>#</th>
                    <th>Fundamentos</th>
                    <th>Detalle</th>
                    <th colspan="2" style="width: 10%"></th>
                </tr>
            </thead>
            <tbody class="small">
                @foreach($fundaments as $key => $fundament)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $fundament->NameValue }}</td>
                    <td>
                      <ul>
                        @foreach($fundament->rstDetailFundament as $detailFundament)
                          <li>{{ $detailFundament->fundamentDetailManage->NameValue }}</li>
                        @endforeach
                      </ul>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('replacement_staff.manage.fundament.edit', $fundament) }}"
                          class="btn btn-outline-secondary btn-sm"
                          title="Editar"> <i class="fas fa-edit"></i></a>
                    </td>
                    <td class="text-center">
                        <form method="POST" class="form-horizontal" action="{{-- route('replacement_staff.manage.profession.destroy', $profession) --}}">
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
