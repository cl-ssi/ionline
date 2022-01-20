<!-- Modal -->
<div class="modal fade" id="Receipt-{{$detail->pivot->id}}" tabindex="-1" aria-labelledby="ReceiptLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ReceiptLabel"><i class="fas fa-info-circle"></i> Detalle {{$detail->pivot->getPurchasingTypeName()}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            @if($detail->pivot->internalPurchaseOrder)
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered">
                        <tbody>
                            <tr>
                                <th class="table-active" scope="row">Fecha de registro</th>
                                <td>{{ $detail->pivot->internalPurchaseOrder->date->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <th class="table-active" style="width: 33%">Proveedor</th>
                                <td>{{ $detail->pivot->internalPurchaseOrder->supplier->name}}</td>
                            </tr>
                            <tr>
                                <th class="table-active" style="width: 33%">Condición de pago</th>
                                <td>{{ $detail->pivot->internalPurchaseOrder->payment_condition }}</td>
                            </tr>
                            <tr>
                                <th class="table-active" style="width: 33%">Fecha estimada entrega</th>
                                <td>{{ $detail->pivot->internalPurchaseOrder->estimated_delivery_date->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <th class="table-active" style="width: 33%">Registrado por</th>
                                <td>{{ $detail->pivot->user->fullName ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('request_forms.create_internal_purchase_order_document', $detail->pivot->id) }}"
                  class="btn btn-primary btn-sm float-right" title="Formulario" target="_blank">
                  Orden de Compra <i class="fas fa-file-alt"></i>
                </a>
            @endif

            @if($detail->pivot->pettyCash)
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered">
                        <tbody>
                            <tr>
                                <th class="table-active" style="width: 33%">Tipo documento</th>
                                <td>{{ $detail->pivot->pettyCash->receipt_type }}</td>
                            </tr>
                            <tr>
                                <th class="table-active" style="width: 33%">Folio</th>
                                <td>{{ $detail->pivot->pettyCash->receipt_number }}</td>
                            </tr>
                            <tr>
                                <th class="table-active" scope="row">Fecha de documento</th>
                                <td>{{ $detail->pivot->pettyCash->date->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <th class="table-active" style="width: 33%">Monto total</th>
                                <td>${{ number_format($detail->pivot->pettyCash->amount,0,",",".") }}</td>
                            </tr>
                            <tr>
                                <th class="table-active" style="width: 33%">Registrado por</th>
                                <td>{{ $detail->pivot->user->fullName ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if($detail->pivot->pettyCash->file)
                <object type="application/pdf" data="{{ route('request_forms.supply.petty_cash.download', $detail->pivot->pettyCash->id) }}" width="100%" height="400" style="height: 85vh;"><a href="{{ route('request_forms.supply.petty_cash.download', $detail->pivot->pettyCash->id) }}" target="_blank">
                            <i class="fas fa-file"></i> Ver documento</a></object>
                @endif
            @endif

            @if($detail->pivot->fundToBeSettled)
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered">
                        <tbody>
                            <tr>
                                <th class="table-active" scope="row">Fecha registro</th>
                                <td>{{ $detail->pivot->fundToBeSettled->date->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <th class="table-active" style="width: 33%">Monto total</th>
                                <td>${{ number_format($detail->pivot->fundToBeSettled->amount,0,",",".") }}</td>
                            </tr>
                            <tr>
                                <th class="table-active" style="width: 33%">Registrado por</th>
                                <td>{{ $detail->pivot->user->fullName ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <object type="application/pdf" data="{{ route('request_forms.supply.fund_to_be_settled.download', $detail->pivot->fundToBeSettled->id) }}" width="100%" height="400" style="height: 85vh;"><a href="{{ route('request_forms.supply.fund_to_be_settled.download', $detail->pivot->fundToBeSettled->id) }}" target="_blank">
                              <i class="fas fa-file"></i> Ver documento</a></object>
            @endif
            </div>
        </div>
    </div>
</div>
