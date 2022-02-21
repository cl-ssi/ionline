<div class="card mt-3 mb-3 d-print-none">
    <div class="card-body">

        <h5 class="card-title">Crear oficio a fiscalía</h5>

        <form method="POST" class="form-horizontal" action="{{ route('drugs.receptions.record_to_court.store', $reception ) }}">
            @csrf
            @method('POST')

            <div class="form-row">

                <fieldset class="form-group col-2">
                    <label for="for_number">N° de Documento</label>
                    <input type="number" class="form-control" id="for_number"
                        name="number" value="{{ $reception->recordToCourt ? $reception->recordToCourt->number : '' }}">
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="for_document_date">Fecha Documento</label>
                    <input type="date" class="form-control" id="for_document_date"
                        name="document_date"
                        value="{{ ($reception->recordToCourt AND $reception->recordToCourt->document_date) ? $reception->recordToCourt->document_date->format('Y-m-d') : '' }}">
                </fieldset>

                <fieldset class="form-group col-3">
                    <label for="for_number">Observación</label>
                    <input type="text" class="form-control" id="for_observation"
                        name="observation" value="{{ $reception->recordToCourt ? $reception->recordToCourt->observation : '' }}">
                </fieldset>

                <div class="col-2">
                    
                </div>

                <div class="col-1">
                    <label for="">&nbsp;</label>
                    <button type="submit" class="btn btn-primary form-control"><i class="fas fa-save"></i></button>
                </div>

                @if($reception->recordToCourt)
                <div class="col-1">
                    <label for="">&nbsp;</label>
                    <a class="btn btn-outline-secondary form-control" target="_blank"
                        href="{{ route('drugs.receptions.record_to_court.show', $reception )}}">
                        <i class="fas fa-file-alt"></i>
                    </a>
                </div>
                @endif
            </div>

        </form>
    </div>
</div>
