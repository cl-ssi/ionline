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

            @if($detail->pivot->tender)
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered">
                        <tbody>
                            <tr>
                                <th class="table-active" style="width: 33%">Fecha creacion</th>
                                <td>{{ $detail->pivot->tender->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th class="table-active" style="width: 33%">ID de la licitación</th>
                                <td>{{ $detail->pivot->tender->tender_number }}</td>
                            </tr>
                            <tr>
                                <th class="table-active" style="width: 33%">Descripción de la licitación</th>
                                <td>{{ $detail->pivot->tender->description }}</td>
                            </tr>
                            <tr>
                                <th class="table-active" scope="row">Nº Resol. de las Bases Administrativas</th>
                                <td>{{ $detail->pivot->tender->resol_administrative_bases }}</td>
                            </tr>
                            <tr>
                                <th class="table-active" style="width: 33%">Nº Resol. de Adjudicación</th>
                                <td>{{ $detail->pivot->tender->resol_adjudication }}</td>
                            </tr>
                            <tr>
                                <th class="table-active" style="width: 33%">Nº Resol. Desierta</th>
                                <td>{{ $detail->pivot->tender->resol_deserted }}</td>
                            </tr>
                            <!-- Licitacion LP/LQ -->
                            @if(in_array($detail->pivot->tender->purchase_type_id, [14,15,16,17,18]))
                            <tr>
                                <th class="table-active" style="width: 33%">Nº Resol. de Contrato</th>
                                <td>{{ $detail->pivot->tender->resol_contract }}</td>
                            </tr>
                            <tr>
                                <th class="table-active" style="width: 33%">Nº Boleta de Garantía</th>
                                <td>{{ $detail->pivot->tender->guarantee_ticket }}</td>
                            </tr>
                            @endif
                            <!-- Licitacion LR MAYOR-->
                            @if(in_array($detail->pivot->tender->purchase_type_id, [16,17,18]))
                            <tr>
                                <th class="table-active" style="width: 33%">Cuenta con Toma de razón</th>
                                <td>{{ $detail->pivot->tender->has_taking_of_reason ? 'SÍ' : 'NO' }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <h6><i class="fas fas fa-paperclip" aria-hidden="true"></i> Anexos</h6>
                <div class="list-group">
                    @forelse($detail->pivot->tender->attachedFiles as $attachedFile)
                    <a href="{{ route('request_forms.supply.attached_file.download', $attachedFile) }}" class="list-group-item list-group-item-action py-2" target="_blank">
                        <i class="fas fa-file"></i> {{ $attachedFile->document_type }} </a>
                    @empty
                    <p>No existen archivos adjuntos a esta licitación.</p>
                    @endforelse
                </div>
            @endif
            </div>
        </div>
    </div>
</div>
