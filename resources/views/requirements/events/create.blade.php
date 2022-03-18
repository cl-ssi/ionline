<div class="collapse" id="collapseExample">
    <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('requirements.events.store') }}">
        @csrf
        @method('POST')


        <div class="form-row">
            <fieldset class="form-group col-12 col-md-4" id="div_tipo">
                <label for="for_date">Tipo</label>
                <select name="status" id="status" class="form-control">
                    @if($requirement->status == "cerrado")
                    <option value="reabierto" selected>Reabrir</option>
                    @else
                    <option value="respondido" selected>Responder a todos</option>
                    <option value="derivado">Derivar</option>
                    <option value="cerrado">Cerrar</option>
                    @endif
                </select>
            </fieldset>


            <fieldset class="form-group col-12 col-md-4" id="div_ou">
                <label for="ou">Unidad Organizacional</label>
                <select id="ou" name="to_ou_id" class="form-control selectpicker" data-live-search="true" required data-size="5">
                    @foreach($ouRoots as $ouRoot)
                    <option value="{{ $ouRoot->id }}" {{ (Auth::user()->organizationalunit == $ouRoot)?'selected':''}}>
                        {{ $ouRoot->name }} ({{$ouRoot->establishment->name}})
                    </option>
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

            <fieldset class="form-group col-12 col-md-4" id="div_destinatario">
                <label for="for_origin">Destinatario</label>
                <div class="input-group">
                    <select class="form-control" name="to_user_id" id="user" required="">

                    </select>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-primary add_destinatario" data-toggle="tooltip" data-placement="top" id="add_destinatario" title="Utilizar para agregar más de un destinatario">
                            <i class="fas fa-user-plus"></i>
                        </button>
                        <button type="button" class="btn btn-outline-primary add_destinatario_cc" data-toggle="tooltip" data-placement="top" id="add_destinatario_cc" title="Utilizar para agregar en copia al requerimiento">
                            <i class="far fa-copy"></i>
                        </button>
                    </div>
                </div>
            </fieldset>


            <table id="tabla_funcionarios" class="table table-striped table-sm" style="display: none">
                <thead>
                    <tr>
                        <th>Unidad Organizacional</th>
                        <th>Destinatario</th>
                        <th>En copia</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <input type="hidden" value="{{$requirement->id}}" name="requirement_id">
        </div>

        <div class="form-row">
            <fieldset class="form-group col-12 col-md-4">
                <label for="forFile">Adjuntar archivos</label>
                <input type="file" class="form-control-file" id="forfile" name="forfile[]" multiple>
            </fieldset>

            <fieldset class="form-group col-12 col-md-4">
                <label for="for_document">Asociar documentos</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="for_document" name="document">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary add-row">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </fieldset>
            <fieldset class="form-group col-12 col-md-4" id="div_limit_at">
                <label for="for_limit_at">Fecha Límite Evento</label>
                <input type="datetime-local" class="form-control" id="for_subject" name="limit_at">
            </fieldset>

            <fieldset class="form-group col-12 col-md-4">
                <label for="for_tabla_documents"></br></label></br>
                <table id="tabla_documents" style="display: none">
                    <tr></tr>
                </table>
            </fieldset>
        </div>

        <div class="row">
            <fieldset class="form-group col">
                <label for="for_date">Observación</label>
                <textarea class="form-control" id="for_body" name="body" rows="3" required=""></textarea>
            </fieldset>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>

    </form>
</div>