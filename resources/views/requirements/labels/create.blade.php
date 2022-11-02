@extends('layouts.app')

@section('title', 'Crear Ubicación')

@section('content')

@include('requirements.partials.nav')

<h3 class="mb-3">Crear Etiqueta</h3>

<form method="POST" class="form-horizontal" action="{{ route('requirements.labels.store') }}">
    @csrf

    <div class="form-row">
        <fieldset class="form-group col-md col-sm-12">
            <label for="for_name">Nombre*</label>
            <input
                type="text"
                class="form-control"
                id="for_name"
                name="name"
                required
            >
        </fieldset>


        <fieldset class="form-group col-md col-sm-12">
            <label for="ou">Unidad Organizacional</label>
            <!-- <select class="custom-select" id="forOrganizationalUnit" name="organizationalunit"> -->
            <select class="form-control selectpicker" data-live-search="true" id="ou" name="ou_id" required
                    data-size="5">
                @foreach($ouRoots as $ouRoot)
                    @if($ouRoot->name != 'Externos')
                        <option value="{{ $ouRoot->id }}">
                            {{($ouRoot->establishment->alias ?? '')}}-{{ $ouRoot->name }}
                        </option>
                        @foreach($ouRoot->childs as $child_level_1)

                            <option value="{{ $child_level_1->id }}">
                                &nbsp;&nbsp;&nbsp;
                                {{($child_level_1->establishment->alias ?? '')}}-{{ $child_level_1->name }}
                            </option>
                            @foreach($child_level_1->childs as $child_level_2)
                                <option value="{{ $child_level_2->id }}">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{($child_level_2->establishment->alias ?? '')}}-{{ $child_level_2->name }}
                                </option>
                                @foreach($child_level_2->childs as $child_level_3)
                                    <option value="{{ $child_level_3->id }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        {{($child_level_3->establishment->alias ?? '')}}-{{ $child_level_3->name }}
                                    </option>
                                    @foreach($child_level_3->childs as $child_level_4)
                                        <option value="{{ $child_level_4->id }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{($child_level_4->establishment->alias ?? '')}}-{{ $child_level_4->name }}
                                        </option>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @endif
                @endforeach
            </select>
        </fieldset>

    </div>
    
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('requirements.labels.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
