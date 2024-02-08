<div class="modal fade" id="editModalBudgetAvailability-{{$budget_availability->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar disponibilidad presupuestaria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-edit-budget-{{$budget_availability->id}}" action="{{ route('agreements.programs.budget_availability.update', $budget_availability )}}" enctype="multipart/form-data">
                <div class="modal-body">
                    {{ method_field('PUT') }} {{ csrf_field() }}
                    
                    <div class="form-group">
                        <label for="date" class="col-form-label">Fecha</label>
                        <input type="date" class="form-control" name="date" value="{{$budget_availability->date ? $budget_availability->date->format('Y-m-d') : ''}}" required>
                    </div>
                    <div class="form-group">
                        <label for="res_minsal_date" class="col-form-label">Fecha Resolución Minsal</label>
                        <input type="date" class="form-control" name="res_minsal_date" value="{{$budget_availability->res_minsal_date ? $budget_availability->res_minsal_date->format('Y-m-d') : ''}}" required>
                    </div>
                    <div class="form-group">
                        <label for="res_minsal_number" class="col-form-label">N° Resolución Minsal</label>
                        <input type="number" class="form-control" name="res_minsal_number" value="{{$budget_availability->res_minsal_number ?? ''}}" required>
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
