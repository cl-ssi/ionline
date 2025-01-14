<div>
    <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.technical_evaluation.file.store', $technicalEvaluation) }}" enctype="multipart/form-data"/>
        @csrf
            <div class="form-row">
                <fieldset class="form-group col mt">
                    <fieldset class="form-group">
                        <label for="for_name">Nombre Archivo</label>
                        <input type="text" class="form-control" name="name[]" required>
                    </fieldset>
                </fieldset>
                <fieldset class="form-group col mt">
                    <div class="mb-3">
                      <label for="forFile" class="form-label"><br></label>
                      <input class="form-control" type="file" name="file[]" accept="application/pdf" required>
                    </div>
                </fieldset>
            </div>

            <div class="form-row">
                <button type="submit" class="btn btn-primary float-right">Guardar</button>
            </div>
    </form>
</div>
