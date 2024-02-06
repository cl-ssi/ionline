<div class="modal fade" id="changeDegreeModal-{{ $requestReplacementStaff->id }}" tabindex="-1" aria-labelledby="changeDegreeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeDegreeModalLabel">Cambio de Grado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm">
                        <h6>Solicitud ID: {{ $requestReplacementStaff->id }}</h6> 
                        
                        <form method="POST" action="{{ route('replacement_staff.request.store_change_degree', $requestReplacementStaff) }}">
                            @csrf
                            @method('POST')
                            <label for="for_degree">Grado</label>
                            <input type="text" class="form-control mt-2" name="degree" id="for_degree" value="{{ $requestReplacementStaff->degree }}">

                            <button type="submit" class="btn btn-primary float-right mt-2"><i class="fas fa-save"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>