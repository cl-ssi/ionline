@section('custom_css')
<style>
.modal {
  padding: 0 !important;
}

.modal .full-width {
  width: 100%;
  max-width: 100%;
  height: 100%;
  margin: 0;
}
.modal .modal-content {
  border: 0;
  border-radius: 0;
  max-height: 100%; 
  height: 100%;
}
.modal .modal-body {
  overflow-y: auto;
}

.modal-dialog.modal-dialog-scrollable { max-height: 100%; }

.modal-dialog.modal-dialog-scrollable .modal-content { max-height: 100%; }

</style>
@endsection
<!-- Modal -->
<div class="modal fade" id="requestBudget" tabindex="-1" aria-labelledby="requestBudgetLabel" aria-hidden="true">
    <div class="modal-dialog full-width modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestBudgetLabel">Solicitar cambio presupuesto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="new-budget-form" action="{{ route('request_forms.supply.create_new_budget', $requestForm->id )}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="table-responsive">
                            @if($requestForm->type_form == 'bienes y/o servicios')
                            <h6><i class="fas fa-shopping-cart"></i> Lista de Bienes y/o Servicios:</h6>
                            <table id="items_tbl" class="table table-sm table-hover table-bordered small">
                                <thead class="text-center">
                                    <tr>
                                        <th>Item</th>
                                        <th>Cod.Presup.</th>
                                        <th>Artículo</th>
                                        <th>UM</th>
                                        <th width="250">Especificaciones Técnicas</th>
                                        <th><i class="fas fa-paperclip"></i></th>
                                        <th width="100">Cantidad</th>
                                        <th width="150">Valor U.</th>
                                        <th width="80">Impto.</th>
                                        <th width="150">Total Item</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requestForm->itemRequestForms as $key => $item)
                                    <tr>
                                        <input type="hidden" name="item_request_form_id[]" value="{{$item->id}}">
                                        <td>{{ $key+1 }}</td>
                                        <!-- <td>{{ $item->status }}</td> -->
                                        <td>{{ $item->budgetItem?->fullName() }}</td>
                                        <td>@if($item->product_id)
                                        {{ optional($item->product)->code}} {{ optional($item->product)->name }}
                                        @else
                                        {{ $item->article }}
                                        @endif
                                        </td>
                                        <td>{{ $item->unit_of_measurement }}</td>
                                        <td>
                                        <textarea class="form-control form-control-sm" name="new_specification[]" id="for_new_specification" rows="4" style="font-size: 13px!important;">{!! old('new_specification.'.$key, $item->specification) !!}</textarea>
                                        </td>
                                        <td align="center">
                                        @if($item->article_file)
                                        <a href="{{ route('request_forms.show_item_file', $item) }}" target="_blank">
                                        <i class="fas fa-file"></i></a>
                                        @endif
                                        </td>
                                        <td align="right">
                                        <input type="number" class="form-control form-control-sm text-right new-item" step="0.01" min="0.1" id="for_new_quantity" name="new_quantity[]" value="{{ old('new_quantity.'.$key, $item->quantity) }}">
                                        </td>
                                        <td align="right">
                                            <input type="number" class="form-control form-control-sm text-right new-item" step="0.01" min="1" id="for_new_unit_value" name="new_unit_value[]" value="{{ old('new_unit_value.'.$key, $item->unit_value) }}">
                                        </td>
                                        <td align="right">
                                        <!-- <input type="text" class="form-control form-control-sm text-right" id="for_tax" name="tax[]" value="{{ $item->tax }}"> -->
                                        <select name="new_tax[]" class="form-control form-control-sm new-item" id="for_new_tax">
                                        <option value="">Seleccione...</option>    
                                        <option value="iva" {{$item->tax == 'iva' ? 'selected' : ''}} >I.V.A. 19%</option>
                                        <option value="bh" {{$item->tax == 'bh' ? 'selected' : ''}} ></option>
                                        <option value="srf" {{$item->tax == 'srf' ? 'selected' : ''}} >S.R.F Zona Franca 0%</option>
                                        <option value="e" {{$item->tax == 'e' ? 'selected' : ''}}>Exento 0%</option>
                                        <option value="nd" {{$item->tax == 'nd' ? 'selected' : ''}} >No Definido</option>
                                        </select>
                                        </td>
                                        <td align="right">
                                        <input type="number" class="form-control form-control-sm text-right new-item-total" step="0.01" min="1" name="new_item_total[]" value="{{ old('new_item_total.'.$key, $item->expense) }}" readonly>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8"></td>
                                        <td class="text-right">Valor Total</td>
                                        <td align="right">
                                        <input type="number" step="0.01" min="1" class="form-control form-control-sm text-right " id="total_new_amount" name="new_amount" readonly>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            @else <!-- Pasajeros -->
                            <h6><i class="fas fa-shopping-cart"></i> Lista de Pasajeros</h6>
                            <table id="items_tbl" class="table table-sm table-hover table-bordered small">
                                <thead class="text-center">
                                    <tr>
                                        <th>Item</th>
                                        <th width="70">RUT</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Fecha Nac.</th>
                                        <th>Teléfono</th>
                                        <th>E-mail</th>
                                        <th>Item Pres.</th> 
                                        <th>Tipo viaje</th>
                                        <th>Origen</th>
                                        <th>Destino</th>
                                        <th>Fecha ida</th>
                                        <th>Fecha vuelta</th>
                                        <th>Equipaje</th>
                                        <th width="150">Valor U.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requestForm->passengers as $key => $passenger)
                                    <tr>
                                        <input type="hidden" name="passenger_request_form_id[]" value="{{$passenger->id}}">
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ number_format($passenger->run, 0, ",", ".") }}-{{ $passenger->dv }}</td>
                                        <td>{{ $passenger->name }}</td>
                                        <td>{{ $passenger->fathers_family }} {{ $passenger->mothers_family }}</td>
                                        <td>{{ $passenger->birthday ? $passenger->birthday->format('d-m-Y') : '' }}</td>
                                        <td>{{ $passenger->phone_number }}</td>
                                        <td>{{ $passenger->email }}</td>
                                        <td>{{ $passenger->budgetItem ? $passenger->budgetItem->fullName() : '' }}</td>
                                        <td>{{ $passenger->roundTripName }}</td>
                                        <td>{{ $passenger->origin }}</td>
                                        <td>{{ $passenger->destination }}</td>
                                        <td>{{ $passenger->departure_date->format('d-m-Y H:i') }}</td>
                                        <td>{{ $passenger->return_date ? $passenger->return_date->format('d-m-Y H:i') : '' }}</td>
                                        <td>{{ $passenger->baggageName }}</td>
                                        <td align="right">
                                            <!-- <input type="number" class="form-control form-control-sm text-right" step="0.01" min="1" id="for_new_item_total" name="new_item_total[]" value="{{ old('new_item_total.'.$key, $passenger->unit_value) }}"> -->
                                            <input type="number" class="form-control form-control-sm text-right new-item-total" step="0.01" min="1" name="new_item_total[]" value="{{ old('new_item_total.'.$key, $passenger->unit_value) }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="13"></td>
                                        <td class="text-right">Valor Total</td>
                                        <td align="right">
                                        <input type="number" step="0.01" min="1" class="form-control form-control-sm text-right" id="total_new_amount" name="new_amount" readonly>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <fieldset class="form-group col-sm">
                            <textarea name="purchaser_observation" class="form-control form-control-sm" rows="3" placeholder="Ingrese observación" required></textarea>
                        </fieldset>
                    </div>
                    <div class="form-row">
                        <fieldset class="form-group col-sm">
                            <label for="for_files">Adjuntar archivos (opcional)</label>
                            <input type="file" class="form-control" id="for_files" name="files[]" accept="application/pdf" multiple>
                        </fieldset>
                    </div>
                    <button type="submit" id="send_budget" class="btn btn-primary float-right btn-sm">Enviar solicitud</button>
                </form>
            </div>
        </div>
    </div>
</div>
