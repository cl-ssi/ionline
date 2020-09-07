<div class="card">
    <div class="card-body">
        <form class="form" id="form1" enctype="multipart/form-data" method="post" action="">
            <!--
            <div class="checkbox">
                <label><input type="checkbox" name="chk_requiere_respuesta"/> Requiere Respuesta</label>
            </div>
            -->
            <div class="form-group row">
                <label for="for_organizational_unit_id" class="col-3">Unidad Organizacional</label>
                <div class="col-9">
                    <select name="organizational_unit_id" id="ou" class="form-control">
                        <option value="{{ $organizationalUnit->id }}">
                            {{ $organizationalUnit->name }}
                        </option>
                        @foreach($organizationalUnit->childs as $child_level_1)
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
                </div>
            </div>


            <div class="form-group row">
                <label for="for_to" class="col-3">Destinatario</label>
                <div class="col-9">
                    <select class="form-control" name="to" id="user">

                    </select>
                </div>
            </div>

            <div class="row">
                <fieldset class="form-group col">
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Anular</button>
                </fieldset>

                <fieldset class="form-group col text-center">
                    <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-archive"></i> Archivar</button>
                </fieldset>

                <fieldset class="form-group col text-right">
                    <button type="button" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Derivar</button>
                </fieldset>
            </div>

            <hr>

            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Ingrese un comentario (opcional)">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button"><i class="fas fa-comment"></i> Comentar</button>
                </div>
            </div>


        </form>
    </div>
</div>





@section('custom_js')
<script>
$('#ou').on('change', function(e){
    console.log(e);
    var ou_id = e.target.value;
    $.get('{{ route('rrhh.users.get.from.ou')}}/'+ou_id, function(data) {
        console.log(data);
        $('#user').empty();
        $.each(data, function(index,subCatObj){
            $('#user').append(
                '<option value="'+subCatObj.id+'">'
                +subCatObj.name+' '
                +subCatObj.fathers_family+' '
                +subCatObj.mothers_family+'</option>');
        });
    });
});
</script>
@endsection
