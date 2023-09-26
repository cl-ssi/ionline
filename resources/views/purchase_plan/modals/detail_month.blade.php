<div class="modal fade" id="modal-ppl-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-shopping-cart"></i> Detalle de envíos, cantidad y meses de despacho
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm small">
                        <thead>
                            <tr>
                                <th class="table-secondary">Producto:</th>
                                <td>{{ $item->unspscProduct->name }}</td>
                            </tr>
                            <tr>
                                <th class="table-secondary">Cantidad:</th>
                                <td>{{ $item->quantity }}</td>
                            </tr>
                        </thead>
                    </table>
                </div>

                <form method="POST" class="form-horizontal" action="{{-- route('replacement_staff.request.technical_evaluation.store', $requestReplacementStaff) --}}">
                    @csrf
                    @method('POST')
                    <div class="row g-3 align-items-center">
                        <div class="col-3">
                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="text" value="Enero" autocomplete="off" disabled>
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="text" value="Febrero" autocomplete="off" disabled>
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="text" value="Marzo" autocomplete="off" disabled>
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="text" value="Abril" autocomplete="off" disabled>
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="text" value="Mayo" autocomplete="off" disabled>
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="text" value="Junio" autocomplete="off" disabled>
                            </fieldset>
                        </div>

                        <div class="col-3">
                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="number" autocomplete="off">
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="number" autocomplete="off">
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="number" autocomplete="off">
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="number" autocomplete="off">
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="number" autocomplete="off">
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="number" autocomplete="off">
                            </fieldset>
                        </div>

                        <div class="col-3">
                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="text" value="Julio" autocomplete="off" disabled>
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="text" value="Agosto" autocomplete="off" disabled>
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="text" value="Septiembre" autocomplete="off" disabled>
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="text" value="Octubre" autocomplete="off" disabled>
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="text" value="Noviembre" autocomplete="off" disabled>
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="text" value="Diciembre" autocomplete="off" disabled>
                            </fieldset>
                        </div>

                        <div class="col-3">
                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="number" autocomplete="off">
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="number" autocomplete="off">
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="number" autocomplete="off">
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="number" autocomplete="off">
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="number" autocomplete="off">
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_user_allowance_id"></label>
                                <input class="form-control form-control-sm" type="number" autocomplete="off">
                            </fieldset>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-sm float-end"><i class="fas fa-save"></i> Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>