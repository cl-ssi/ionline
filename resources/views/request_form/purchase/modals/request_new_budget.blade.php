<!-- Modal -->
<div class="modal fade" id="requestBudget" tabindex="-1" aria-labelledby="requestBudgetLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestBudgetLabel">Solicitar nuevo presupuesto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="new-budget-form" action="{{ route('request_forms.supply.create_new_budget', $requestForm->id )}}">
                    @csrf
                    <div class="form-row">
                        <fieldset class="form-group col-sm">
                            <input type="number" class="form-control form-control-sm" id="newBudget" name="newBudget" placeholder="Ingrese nuevo presupuesto" min="{{number_format($requestForm->estimated_expense+1,$requestForm->precision_currency,',','')}}" required>
                        </fieldset>
                    </div>
                    <div class="form-row">
                        <fieldset class="form-group col-sm">
                            <textarea name="purchaser_observation" class="form-control form-control-sm" rows="3" placeholder="Ingrese observación" required></textarea>
                        </fieldset>
                    </div>

                    <button type="submit" class="btn btn-primary float-right btn-sm">Enviar solicitud</button>
                </form>
            </div>
        </div>
    </div>
</div>