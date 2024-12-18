<!-- Modal -->
<div class="modal fade" id="exampleModal-{{ $requestForm->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-{{ $requestForm->id }}">Reasignar al ID: {{$requestForm->id}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="reasign-purchaser-form" action="{{ route('request_forms.supply.reasign_purchaser', $requestForm )}}">
                    @csrf
                    <div>
                        <div class="form-row">
                            <fieldset class="form-group col-sm">
                                <label>Comprador Actual:</label><br>
                                <select name="" class="form-control form-control-sm" disabled>
                                    <option value="{{ $requestForm->purchasers->first()->id }}">{{ ucfirst($requestForm->purchasers->first()->tinyName ?? '') }}</option>
                                </select>
                            </fieldset>

                            <fieldset class="form-group col-sm">
                                <label>Nuevo Comprador:</label><br>
                                <select name="new_purchaser_user_id" class="form-control form-control-sm">
                                    <option value="">Seleccione...</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ ucfirst($user->tinyName) }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>
                        <div class="form-row">
                            <fieldset class="form-group col-sm">
                                <label>Usuario Gestor Actual:</label><br>
                                <select name="" class="form-control form-control-sm" disabled>
                                    <option value="{{ $requestForm->request_user_id }}">{{ ucfirst($requestForm->user->tinyName ?? '') }}</option>
                                </select>
                            </fieldset>

                            <fieldset class="form-group col-sm">
                                <label>Nuevo Usuario Gestor:</label><br>
                                @livewire('search-select-user', [
                                    'selected_id' => 'new_request_user_id',
                                    'small_option' => true
                                ], key($requestForm->id))
                            </fieldset>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fas fa-save"></i> Guardar</button>

                    </div>
                </form>

            </div>

        </div>
    </div>
</div>