<div class="card mt-4 d-print-none">
    <div class="card-body">

        <h5 class="card-title">Agregar Adjuntos</h5>

        <form method="POST" class="form-horizontal" action="{{ route('request_forms.files.store', $requestForm) }}" enctype="multipart/form-data">
            @csrf
            <input type="file" class="form-control-file" id="forfile" name="forfile[]" multiple required>

            <button class="btn btn-primary btn-sm float-right mr-3" type="submit">
                <i class="fas fa-save"></i> Enviar
            </button>

        </form>

    </div>
</div>
