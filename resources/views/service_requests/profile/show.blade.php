@extends('layouts.app')

@section('title', 'Maqueta Honorario')

@section('content')

    <h3 class="mb-3">Perfil del Funcionario</h3>

    <!-- Datos Personales -->
    <div class="card mb-3">
        <div class="card-body">
            <h4 class="card-title">Datos Personales</h4>
            <div class="form-row mb-3">
                <div class="col-md-2">
                    <label for="validationDefault02">Run.</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->runFormat() }}">
                </div>
                <div class="col-md-3">
                    <label for="validationDefault01">Nombres</label>
                    <input type="text" class="form-control" id="validationDefault01" value="{{ $user->name }}">
                </div>
                <div class="col-md-2">
                    <label for="validationDefault02">Apellido P.</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->fathers_family }}">
                </div>
                <div class="col-md-2">
                    <label for="validationDefault02">Apellido M.</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->mothers_family }}">
                </div>
                <div class="col-md-1">
                    <label for="validationDefault02">Sexo</label>
                    <select name="" id="" class="form-control">
                        <option value=""></option>
                        <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Masculino</option>
                        <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="validationDefault02">F. Nac.</label>
                    <input type="date" class="form-control" id="validationDefault02" value="{{ $user->birthday }}">
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-4">
                    <label for="validationDefault02">Dirección</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->address }}">
                </div>
                <div class="col-md-2">
                    <label for="validationDefault02">Comuna</label>
                    <select name="" id="" class="form-control">
                        <option value="">Iquique</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="validationDefault02">Telefono</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->phone_number }}">
                </div>
                <div class="col-md-4">
                    <label for="validationDefault02">Email</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->email }}">
                </div>
            </div>

        </div>

        <ul class="nav justify-content-end nav-tabs card-header-tabs">
            <li class="nav-item">
                <b class="nav-link">Año</b>
            </li>
            @foreach (range(2020, now()->format('Y')) as $ano)
                <li class="nav-item">
                    <a class="nav-link @if ($year == $ano) active @endif"
                        href="{{ route('rrhh.service-request.show', ['run' => $user->id, 'year' => $ano]) }}">{{ $ano }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    @if ($year)
        <h5>Contratos</h5>
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    @foreach ($workingDayTypes as $workingDayType)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('rrhh.service-request.show', ['run' => $user->id, 'year' => $ano, 'type' => $workingDayType]) }}">{{ $workingDayType }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-body">
                <ul class="nav mb-3">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <h5><i>id: 124</i></h5>
                            2023-01-10 <br>
                            2023-02-28 <br>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <h5><i>id: 340</i></h5>
                            2023-03-01 <br>
                            2023-04-30 <br>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <h5><i>id: 1240</i></h5>
                            2023-05-01 <br>
                            2023-05-15 <br>
                        </a>
                    </li>
                    <li>
                        |<br>
                        |<br>
                        |<br>
                        |
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <h5><i>id: 2534</i></h5>
                            2023-06-08 <br>
                            2023-07-10 <br>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-success" href="#">
                            <h5><i>id: 14355</i></h5>
                            2023-07-11 <br>
                            2023-08-31 <br>
                        </a>
                    </li>
                </ul>





            </div>
        </div>
    @endif
    </div>


@endsection
