<div class="modal fade" id="addModalBudgetAvailability" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Nueva disponibilidad presupuestaria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-add2" enctype="multipart/form-data">
                <div class="modal-body">
                    {{ csrf_field() }}

                    <input type="hidden" name="program_id" value="{{$program->id}}">
                    
                    <div class="form-group">
                        <label for="date" class="col-form-label">Fecha</label>
                        <input type="date" class="form-control" name="date" value="{{now()->format('Y-m-d')}}" required>
                    </div>
                    <div class="form-group">
                        <label for="res_minsal_date" class="col-form-label">Fecha Resolución Minsal</label>
                        <input type="date" class="form-control" name="res_minsal_date" required>
                    </div>
                    <div class="form-group">
                        <label for="res_minsal_number" class="col-form-label">N° Resolución Minsal</label>
                        <input type="number" class="form-control" name="res_minsal_number" required>
                    </div>
                    {{--<div class="form-group">
                        <label for="forreferente">Referente</label>
                        @livewire('search-select-user', [
                            'required' => 'required',
                            'selected_id' => 'referrer_id',
                        ])
                    </div>--}}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
