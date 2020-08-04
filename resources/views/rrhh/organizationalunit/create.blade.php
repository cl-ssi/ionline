<h3>Crear nueva unidad organizacional</h3>

<form method="POST" class="form-horizontal" action="{{ route('rrhh.organizationalunits.store') }}">
    @csrf
    <fieldset class="form-group">
        <label for="forName">Nombre</label>
        <input type="text" class="form-control" id="forName" placeholder="Nombre de la unidad organizacional" name="name" required="required">
    </fieldset>
    <fieldset class="form-group">
        <label for="forFather">Depende de</label>
        <select class="custom-select" id="forFather" name="organizational_unit_id">
            <option value="{{ $organizationalunit->id }}">
                {{ $organizationalunit->name }}
            </option>

            @foreach($organizationalunit->childs as $child_level_1)

            <option value="{{ $child_level_1->id }}">
                &nbsp;&nbsp;&nbsp;
                {{ $child_level_1->name }}
                </option>
                @foreach($child_level_1->childs as $child_level_2)
                <option value="{{ $child_level_2->id }}">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {{ $child_level_2->name }}
                </option>
                    @foreach($child_level_2->childs as $child_level_3)
                    <option value="{{ $child_level_3->id }}">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    {{ $child_level_3->name }}
                    </option>
                    @endforeach       
                @endforeach                
            @endforeach

        </select>

    </fieldset>

    <button type="submit">Guardar</button>



</form>