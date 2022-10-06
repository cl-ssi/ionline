<!-- Modal -->
<div class="modal fade" id="exampleModal-{{ $requestForm->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-{{ $requestForm->id }}">Reasignar Comprador al ID: {{$requestForm->id}}
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
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ ($requestForm->purchasers->first()->id==$user->id)?'selected':''}}>{{ ucfirst(trans($user->FullName)) }}</option>
                                    @endforeach
                                </select>
                            </fieldset>

                            <fieldset class="form-group col-sm">
                                <label>Nuevo Comprador:</label><br>
                                <select name="new_purchaser_user_id" class="form-control form-control-sm" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ ucfirst(trans($user->TinnyName)) }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fas fa-save"></i> Guardar</button>

                    </div>
                </form>

            </div>

        </div>
    </div>
</div>