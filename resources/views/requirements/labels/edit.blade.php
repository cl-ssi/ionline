@extends('layouts.app')

@section('title', 'Editar Etiqueta')

@section('content')
    
@include('requirements.partials.nav')

    <h3 class="mb-3">Editar Etiqueta</h3>

    <form method="POST" class="form-horizontal" action="{{ route('requirements.labels.update', $label) }}">
        @csrf
        @method('PUT')

        <div class="form-row g-2">
            <fieldset class="form-group col-md col-sm-12">
                <label for="for_name">Nombre*</label>
                <input
                    type="text"
                    class="form-control"
                    id="for_name"
                    value="{{ $label->name }}"
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
                        <option value="{{ $ouRoot->id }}" {{ ($label->organizationalunit == $ouRoot)?'selected':''}}>
                            {{ $ouRoot->name }} ({{$ouRoot->establishment->name}})
                        </option>
                        @foreach($ouRoot->childs as $child_level_1)
                            <option
                                value="{{ $child_level_1->id }}" {{ ($label->organizationalunit == $child_level_1)?'selected':''}}>
                                &nbsp;&nbsp;&nbsp;
                                {{ $child_level_1->name }} ({{ $child_level_1->establishment->name }})
                            </option>
                            @foreach($child_level_1->childs as $child_level_2)
                                <option
                                    value="{{ $child_level_2->id }}" {{ ($label->organizationalunit == $child_level_2)?'selected':''}}>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ $child_level_2->name }} ({{ $child_level_2->establishment->name }})
                                </option>
                                @foreach($child_level_2->childs as $child_level_3)
                                    <option
                                        value="{{ $child_level_3->id }}" {{ ($label->organizationalunit == $child_level_3)?'selected':''}}>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ $child_level_3->name }} ({{ $child_level_3->establishment->name }})
                                    </option>
                                    @foreach($child_level_3->childs as $child_level_4)
                                        <option
                                            value="{{ $child_level_4->id }}" {{ ($label->organizationalunit == $child_level_4)?'selected':''}}>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ $child_level_4->name }} ({{ $child_level_4->establishment->name }})
                                        </option>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
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
