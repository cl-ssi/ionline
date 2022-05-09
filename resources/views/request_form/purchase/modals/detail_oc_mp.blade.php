<!-- Modal -->
<div class="modal fade" id="mp-{{ $item->Correlativo }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-{{ $item->Correlativo }}">Detalles Orden de Compra {{$oc->Codigo}} <br>Item {{ $item->Correlativo }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="form-row">
                        <fieldset class="form-group col-sm">
                            <label>Nombre Orden de Compra:</label>
                            <input type="text" class="form-control form-control-sm" readonly value="{{$objoc->Listado[0]->Nombre}}">
                        </fieldset>
                    </div>
                    <div class="form-row">
                        <fieldset class="form-group col-sm">
                            <label>Estado:</label>
                            <input type="text" class="form-control form-control-sm" readonly value="{{$objoc->Listado[0]->Estado}}">
                        </fieldset>
                    </div>
                    <div class="form-row">
                        <fieldset class="form-group col-sm">
                            <label>Estado Proveedor:</label>
                            <input type="text" class="form-control form-control-sm" readonly value="{{$objoc->Listado[0]->EstadoProveedor}}">
                        </fieldset>
                    </div>
                    <div class="form-row">
                        <fieldset class="form-group col-sm">
                            <label>Fecha Creación:</label>
                            <input type="text" class="form-control form-control-sm" readonly value="{{
                                date('d-m-Y H:i:s', strtotime($objoc->Listado[0]->Fechas->FechaCreacion));
                            }}">
                        </fieldset>                  
                        <fieldset class="form-group col-sm">
                            <label>Fecha Envío:</label>
                            <input type="text" class="form-control form-control-sm" readonly value="{{
                                date('d-m-Y H:i:s', strtotime($objoc->Listado[0]->Fechas->FechaEnvio));
                            
                            }}">
                        </fieldset>
                    </div>
                    <div class="form-row">
                        <fieldset class="form-group col-sm">
                            <label>Fecha Aceptación:</label>
                            <input type="text" class="form-control form-control-sm" readonly value="{{
                                date('d-m-Y H:i:s', strtotime($objoc->Listado[0]->Fechas->FechaAceptacion));
                            
                            }}">
                        </fieldset>
                        <fieldset class="form-group col-sm">
                            <label>Fecha Cancelación:</label>
                            <input type="text" class="form-control form-control-sm" readonly value="{{
                                date('d-m-Y H:i:s', strtotime($objoc->Listado[0]->Fechas->FechaCancelacion));
                            }}">
                        </fieldset>
                    </div>
                </div>

            </div>
        </div>
    </div>