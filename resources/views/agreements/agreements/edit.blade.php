@extends('layouts.app')

@section('title', 'Nueva Resolución')

@section('content')

@include('agreements/nav')

<h3 class="mb-3">Nueva Resolución</h3>

<form method="POST" class="form-horizontal" action="{{ route('agreements.resolutions.store') }}">
    @csrf
    @method('PUT')

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="forestablishment">Establecimiento</label>
            <select name="establishment" id="formestablishment" class="form-control">
                @foreach($establishments as $e)
                    <option value="{{ $e->id }}">{{ $e->type }} - {{ $e->name }} ({{ $e->commune->name }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="foragreement">Convenio</label>
            <select name="agreement" id="formagreement" class="form-control">
                @foreach($agreements as $a)
                    <option value="{{ $a->id }}">{{ $a->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-3">
            <label for="fornumber">Número</label>
            <input type="integer" class="form-control" id="fornumber" placeholder="Número de resolución" name="number" required="">
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="fordate">Fecha</label>
            <input type="date" class="form-control" id="fordate" name="date" required="">
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="forfile">Archivo</label>
            <input type="file" class="form-control" id="forfile" name="file" required="">
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary mb-4">Guardar</button>

</form>


    <div class="card">
        <div class="card-body">
            <h5>Montos</h5>

            <div class="form-row">

                <fieldset class="form-group col-6">
                    <label for="forcomponent">Componente</label>
                    <select name="component" id="formcomponent" class="form-control">
                        <option value=""></option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="forsubtitle">Subtítulo</label>
                    <select name="subtitle" id="formsubtitle" class="form-control">
                        <option value="22">22</option>
                        <option value="29">29</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="foramount">Monto $</label>
                    <input type="text" class="form-control" id="foramount" placeholder="Agregue el monto" name="amount" required="">
                </fieldset>

            </div>

            <div class="form-row">

                <fieldset class="form-group col-6">
                    <label for="forcomponent">Componente</label>
                    <select name="component" id="formcomponent" class="form-control">
                        <option value=""></option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="forsubtitle">Subtítulo</label>
                    <select name="subtitle" id="formsubtitle" class="form-control">
                        <option value="22">22</option>
                        <option value="29">29</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="foramount">Monto $</label>
                    <input type="text" class="form-control" id="foramount" placeholder="Agregue el monto" name="amount" required="">
                </fieldset>

            </div>

            <div class="form-row">

                <fieldset class="form-group col-6">
                    <label for="forcomponent">Componente</label>
                    <select name="component" id="formcomponent" class="form-control">
                        <option value=""></option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="forsubtitle">Subtítulo</label>
                    <select name="subtitle" id="formsubtitle" class="form-control">
                        <option value="22">22</option>
                        <option value="29">29</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="foramount">Monto $</label>
                    <input type="text" class="form-control" id="foramount" placeholder="Agregue el monto" name="amount" required="">
                </fieldset>

            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>


        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5>Addendum</h5>

            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Número</th>
                        <th>Fecha</th>
                        <th>Ingresado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>123</td>
                        <td>05-07-2018</td>
                        <td>06-07-2018</td>
                        <td><button type="submit" class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>




            <div class="form-row">
                <fieldset class="form-group col-3">
                    <label for="fornumber">Número</label>
                    <input type="integer" class="form-control" id="fornumber" placeholder="Número de resolución" name="number" required="">
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="fordate">Fecha</label>
                    <input type="date" class="form-control" id="fordate" name="date" required="">
                </fieldset>

                <fieldset class="form-group col-6">
                    <label for="forfile">Archivo</label>
                    <input type="file" class="form-control" id="forfile" name="file" required="">
                </fieldset>
            </div>



            <button type="submit" class="btn btn-primary">Agregar</button>
        </div>
    </div>

@endsection

@section('custom_js')

@endsection
