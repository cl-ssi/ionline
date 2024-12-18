@foreach($serviceRequest->fulfillments->sortBy('month') as $fulfillment)
    @if($fulfillment->type != "Remanente")
        <div class="card border-dark">
            <div class="card-header">
                <h4>Información del período: {{$fulfillment->year}}-{{$fulfillment->month}} ({{Carbon\Carbon::parse($fulfillment->year . "-" . $fulfillment->month)->monthName}}) 
                <span class="small text-muted float-right">{{ $fulfillment->id}}
                    @can('Service Request: delete fulfillments')
                        <a class="btn btn-outline-dark" href="{{ route('rrhh.service-request.fulfillment.add_remainder',$fulfillment) }}" onclick="return confirm('¿Está seguro que desea agregar remanente de este período?')">
                            Agregar remanente
                        </a>
                    @endcan
                    @can('Service Request: delete fulfillments')
                        <a class="btn btn-outline-danger" href="{{ route('rrhh.service-request.fulfillment.destroy',$fulfillment) }}" onclick="return confirm('¿Está seguro que desea eliminar el período?')">
                            Eliminar período
                        </a>
                    @endcan
                </span>
                </h4>
                
                
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('rrhh.service-request.fulfillment.update',$fulfillment) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <fieldset class="form-group col-12 col-md-2">
                            <label for="for_type">Período</label>
                            <select name="type" class="form-control" required>
                                <option value=""></option>
                                <option value="Mensual" @if($fulfillment->type == "Mensual") selected @endif>Mensual</option>
                                <option value="Parcial" @if($fulfillment->type == "Parcial") selected @endif>Parcial</option>
                            </select>
                        </fieldset>
                        <fieldset class="form-group col-6 col-md-2">
                            <label for="for_start_date">Inicio</label>
                            <input type="date" class="form-control" name="start_date" value="{{$fulfillment->start_date->format('Y-m-d')}}" required>
                        </fieldset>
                        <fieldset class="form-group col-6 col-md-2">
                            <label for="for_end_date">Término</label>
                            <input type="date" class="form-control" name="end_date" value="{{$fulfillment->end_date->format('Y-m-d')}}" required>
                        </fieldset>
                        <fieldset class="form-group col-12 col-md-4">
                            <label for="for_observation">Observación</label>
                            <input type="text" class="form-control" name="observation" value="{{$fulfillment->observation}}">
                        </fieldset>

                        <fieldset class="form-group col-2">
                            <label for="for_submit"><br /></label>
                            @can('Service Request: fulfillments rrhh')
                            <button type="submit" class="form-control btn btn-primary">Guardar</button>
                            @endcan
                        </fieldset>

                    </div>
                </form>

                <hr>

                <div class="card border-success mb-3">
                    <div class="card-header bg-success text-white">
                    Responsable
                    </div>
                <div class="card-body">

                @if($serviceRequest->working_day_type == "DIARIO")
                    @livewire('service-request.shift-control-add-day', ['fulfillment' => $fulfillment])
                @else
                    @livewire('service-request.fulfillment-absences', ['fulfillment' => $fulfillment])
                @endif

                <!-- Aprobación alternativa de certificados de cumplimiento - vía módulo de solicitud de aprobaciones. -->
                <!-- @if(!$fulfillment->signatures_file_id && $fulfillment->responsable_approbation)
                    <div class="form-row">
                        <fieldset class="form-group col">
                            <div class="alert alert-primary" role="alert">
                                @if($fulfillment->approval)
                                    Debido a la intermitencia de firma digital del gobierno si ud. no consigue firmar el certificado de forma tradicional,
                                    le rogamos aprobar el certificado de con el botón "Aprobación Alternativa".
                                    <br><br>
                                    @livewire('documents.approval-button', [
                                        'approval' => $fulfillment->approval, 
                                        'redirect_route' => 'rrhh.service-request.fulfillment.edit',
                                        'redirect_parameter' => $fulfillment->serviceRequest->id,
                                        'button_text' => 'Aprobación Alternativa',
                                    ])
                                    
                                @else
                                    Debido a la intermitencia de firma digital del gobierno si ud. no consigue firmar el certificado de forma tradicional, 
                                    le rogamos presionar el botón "Activar Aprobación Alternativa", con el cual se visualizará botón para realizar dicho proceso.
                                    <br><br>
                                    <a type="button" class="btn btn-warning" href="{{ route('rrhh.service-request.fulfillment.approval-activation',$fulfillment) }}">
                                        Activar Aprobación Alternativa <i class="fas fa-signature"></i>
                                    </a>
                                @endif
                                
                            </div>
                        </fieldset>   
                    </div>
                @endif -->

                <div class="form-row">
                    <fieldset class="form-group col">
                            @if($fulfillment->responsable_approbation != NULL)
                                <a type="button" class="btn btn-outline-primary" href="{{ route('rrhh.service-request.fulfillment.certificate-pdf',$fulfillment) }}" target="_blank">
                                    Ver certificado
                                    <i class="fas fa-file"></i>
                                </a>

                                @if($fulfillment->signatures_file_id)
                                    <a class="btn btn-info" href="{{ route('rrhh.service-request.fulfillment.signed-certificate-pdf',[$fulfillment, time()]) }}" target="_blank" title="Certificado">
                                        Certificado firmado <i class="fas fa-signature"></i>
                                    </a>

                                    @can('Service Request: delete signed certificate')
                                        <a class="btn btn-outline-danger" href="{{ route('rrhh.service-request.fulfillment.delete-signed-certificate-pdf',$fulfillment) }}" title="Borrar Certificado" onclick="return confirm('¿Está seguro que desea eliminar el certificado de cumplimiento firmado?')">
                                            <i class="fas fa-trash"></i> Certificado
                                        </a>
                                    @endcan
                                @else
                                    @php
                                    $idModelModal = $fulfillment->id;
                                    $routePdfSignModal = "/rrhh/service-request/fulfillment/certificate-pdf/$idModelModal/".auth()->id();
                                    $routeCallbackSignModal = 'documents.callbackFirma';
                                    @endphp
                                    @include('documents.signatures.partials.sign_file')
                                    <button type="button" data-toggle="modal" class="btn btn-outline-info" data-target="#signPdfModal{{$idModelModal}}" title="Firmar">
                                        Firmar certificado <i class="fas fa-signature"></i>
                                    </button>
                                @endif
                            @else
                                <div class="alert alert-warning" role="alert">
                                Falta que firme supervisor para realizar proceso de Certificado.
                                </div>
                        @endif
                    </fieldset>

                    <fieldset class="form-group col text-right">
                        @can('Service Request: fulfillments responsable')
                            {{-- FIX: @sickiqq el first se va a caer si no existe flows --}}
                            @if(auth()->id() == $serviceRequest->signatureFlows->where('sign_position',2)->first()?->responsable_id or App\Models\Rrhh\Authority::getAmIAuthorityFromOu(now(),['manager'],auth()->id()))
                                @if($fulfillment->responsable_approver_id == NULL)
                                <a type="button" class="btn btn-danger" @disabled(auth()->user()->godMode) onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de rechazar?');" href="{{ route('rrhh.service-request.fulfillment.refuse-Fulfillment',$fulfillment) }}">
                                    Rechazar
                                </a>
                                <a type="button" class="btn btn-success" @disabled(auth()->user()->godMode) onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');" href="{{ route('rrhh.service-request.fulfillment.confirm-Fulfillment',$fulfillment) }}">
                                    Confirmar
                                </a>
                                @else
                                <button class="btn btn-danger" disabled>Rechazar</button>
                                <button class="btn btn-success" disabled>Confirmar</button>
                                @endif
                            @endif
                        @endcan
                        @can('Service Request: delete signed certificate')
                            <a class="btn btn-outline-danger" href="{{ route('rrhh.service-request.fulfillment.delete-responsable-vb',$fulfillment) }}" title="Borrar Aprobación Responsable" onclick="return confirm('¿Está seguro que desea eliminar las aprobaciones del cumplimiento, deberá contactar a responsable para que vuelva a dar VB')">
                                <i class="fas fa-trash"></i> Aprobación
                            </a>
                        @endcan
                    </fieldset>
                </div>

                <!--archivos adjuntos-->
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Adjuntar archivos al cumplimiento (opcional)</h6>

                            @if($fulfillment->attachments->count() > 0)
                            <table class="table table-sm small table-bordered">
                                <thead class="text-center">

                                    <tr class="table-secondary">
                                        <th width="160">Fecha de Carga</th>
                                        <th>Nombre</th>
                                        <th>Archivo</th>
                                        <th width="100"></th>
                                        <th width="50"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fulfillment->attachments as $attachment)
                                    <tr>
                                        <td>{{ $attachment->updated_at->format('d-m-Y H:i:s') }}</td>
                                        <td>{{ $attachment->name ?? '' }}</td>
                                        <td class="text-center">
                                            @if(pathinfo($attachment->file, PATHINFO_EXTENSION) == 'pdf')
                                            <i class="fas fa-file-pdf fa-2x"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('rrhh.service-request.fulfillment.attachment.show', $attachment) }}" class="btn btn-outline-secondary btn-sm" title="Ir" target="_blank"> <i class="far fa-eye"></i></a>
                                            <a class="btn btn-outline-secondary btn-sm" href="{{ route('rrhh.service-request.fulfillment.attachment.download', $attachment) }}" target="_blank"><i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <form method="POST" class="form-horizontal" action="{{ route('rrhh.service-request.fulfillment.attachment.destroy', $attachment) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Está seguro que desea eliminar este archivo adjunto?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                            </form>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                            <div>
                                @livewire('service-request.attachments-fulfillments', ['var' => $fulfillment->id])
                            </div>
                        </div>
                    </div>
                    <!--fin archivos adjuntos-->

                </div>
                </div>

                <!-- información adicional rrhh -->
                @can('Service Request: fulfillments rrhh')
                <form method="POST" action="{{ route('rrhh.service-request.fulfillment.update',$fulfillment) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card border-danger mb-3">
                        <div class="card-header bg-danger text-white">
                            Datos adicionales - RRHH
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <fieldset class="form-group col-5 col-md-2">
                                    <label for="for_resolution_number">N° Resolución</label>
                                    <input type="text" class="form-control" disabled name="resolution_number" value="{{$serviceRequest->resolution_number}}">
                                </fieldset>
                                <fieldset class="form-group col-7 col-md-2">
                                    <label for="for_resolution_date">Fecha Resolución</label>
                                    <input type="date" class="form-control" disabled name="resolution_date" @if($serviceRequest->resolution_date) value="{{$serviceRequest->resolution_date->format('Y-m-d')}}" @endif>
                                </fieldset>
                                <fieldset class="form-group col-4 col-md-2">
                                    <label for="for_total_hours_paid">Total hrs. a pagar</label>
                                    
                                        @if($serviceRequest->program_contract_type == "Mensual")
                                            @if($fulfillment->total_hours_to_pay) 
                                                <input type="text" class="form-control" name="total_hours_to_pay" value="{{$fulfillment->total_hours_to_pay}}">
                                            @else 
                                                <div class="input-group" data-toggle="tooltip" data-placement="right" title="Valor sugerido por el sistema.">
                                                    <input type="text" class="form-control" name="total_hours_to_pay" value="{{$fulfillment->serviceRequest->weekly_hours}}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">
                                                            <small><i class="fas fa-hand-holding"></i></small>
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <input type="text" class="form-control" name="total_hours_to_pay" value="{{$fulfillment->total_hours_to_pay}}">
                                        @endif
                                        
                                </fieldset>
                                <i class="fa-regular fa-clipboard"></i>
                                <fieldset class="form-group col-6 col-md-2">
                                    <label for="for_total_paid">Total a pagar</label>
                                    
                                        
                                        @if($serviceRequest->program_contract_type == "Mensual")
                                            @if($fulfillment->total_to_pay) 
                                                <input type="text" class="form-control" name="total_to_pay" value="{{$fulfillment->total_to_pay}}">
                                            @else 
                                                <div class="input-group" data-toggle="tooltip" data-placement="right" title="Valor sugerido por el sistema.">
                                                    <input type="text" class="form-control" name="total_to_pay" value="{{$fulfillment->getValueMonthlyQuoteValue()}}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">
                                                            <small><i class="fas fa-hand-holding"></i></small>
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <input type="text" class="form-control" name="total_to_pay" value="{{$fulfillment->total_to_pay}}"><input type="text" class="form-control" name="total_to_pay" value="{{$fulfillment->total_to_pay}}">
                                        @endif
                                        
                                        
                                </fieldset>
                                <div class="form-check form-check-inline">
                                    <input type="hidden" name="illness_leave" value="0">
                                    <input class="form-check-input" type="checkbox" name="illness_leave" value="1" {{ ( $fulfillment->illness_leave== '1' ) ? 'checked="checked"' : null }}>
                                    <label class="form-check-label" for="for_illness_leave">Licencias</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="hidden" name="leave_of_absence" value="0">
                                    <input class="form-check-input" type="checkbox" id="permisos" name="leave_of_absence" value="1" {{ ( $fulfillment->leave_of_absence== '1' ) ? 'checked="checked"' : null }}>
                                    <label class="form-check-label" for="permisos">Permisos</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="hidden" name="assistance" value="0">
                                    <input class="form-check-input" type="checkbox" name="assistance" value="1" {{ ( $fulfillment->assistance== '1' ) ? 'checked="checked"' : null }}>
                                    <label class="form-check-label" for="asistencia">Asistencia</label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-12 col-md-2">
                                    {{--@if($fulfillment->rrhh_approver_id == NULL)--}}
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    {{--@else
                                        <button type="submit" class="btn btn-primary" disabled>Guardar</button>
                                    @endif--}}
                                </div>
                                <div class="col-12 col-md-7">

                                </div>
                                <div class="col-12 col-md-3 text-right">
                                    @if($fulfillment->rrhh_approver_id == NULL)
                                    <a type="button" class="btn btn-danger" @disabled(auth()->user()->godMode) onclick="return confirm('Una vez rechazado, no podrá modificar la información. ¿Está seguro de rechazar?');" href="{{ route('rrhh.service-request.fulfillment.refuse-Fulfillment',$fulfillment) }}">
                                        Rechazar
                                    </a>
                                    <a type="button" class="btn btn-success" @disabled(auth()->user()->godMode) onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');" href="{{ route('rrhh.service-request.fulfillment.confirm-Fulfillment',$fulfillment) }}">
                                        Confirmar
                                    </a>
                                    @else
                                    <button type="submit" class="btn btn-danger" disabled>Rechazar</button>
                                    <button type="submit" class="btn btn-success" disabled>Confirmar</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @endcan

                <!-- información  boleta -->
                <div class="card border-warning mb-3">
                    <div class="card-header bg-warning text-white">
                        Boleta
                    </div>
                    <div class="card-body">

                        <div class="form-row">

                            <div class="col-12 col-md-8">
                                @if($fulfillment->total_to_pay)
                                @livewire('service-request.upload-invoice', ['fulfillment' => $fulfillment])
                                @else
                                No se ha ingresado el "Total a pagar".
                                @endif
                            </div>
                            <div class="col-12 col-md-4">
                                <strong>Valor de la boleta</strong>
                                <div>
                                    $ {{$fulfillment->getValueMonthlyQuoteValue()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- fin información boleta -->

                <!-- información adicional finanzas -->
                @canany(['Service Request: fulfillments finance'])
                    <div class="card border-info mb-3">
                        <div class="card-header bg-info text-white">
                            Datos adicionales - Finanzas/Contabilidad
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <fieldset class="form-group col-5 col-md-2">
                                    <label for="for_resolution_number">N° Resolución</label>
                                    <input type="text" class="form-control" disabled name="resolution_number" value="{{$serviceRequest->resolution_number}}">
                                </fieldset>
                                <fieldset class="form-group col-7 col-md-2">
                                    <label for="for_resolution_date">Fecha Resolución</label>
                                    <input type="date" class="form-control" disabled name="resolution_date" @if($serviceRequest->resolution_date) value="{{$serviceRequest->resolution_date->format('Y-m-d')}}" @endif>
                                </fieldset>
                                <fieldset class="form-group col col-md-2">
                                    <label for="for_total_hours_paid">Total hrs. a pagar per.</label>
                                    <input type="text" class="form-control" name="total_hours_to_pay" disabled value="{{$fulfillment->total_hours_to_pay}}">
                                </fieldset>
                                <fieldset class="form-group col col-md-2">
                                    <label for="for_total_paid">Total a pagar</label>
                                    <input type="text" class="form-control" name="total_to_pay" disabled value="{{$fulfillment->total_to_pay}}">
                                </fieldset>
                                <fieldset class="form-group col col-md-2">
                                    <label for=""><br></label>
                                    @can('Service Request: fulfillments finance')
                                        @if($fulfillment->finances_approver_id == NULL)
                                            <a type="button" class="btn btn-danger form-control" @disabled(auth()->user()->godMode) onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de rechazar?');" href="{{ route('rrhh.service-request.fulfillment.refuse-Fulfillment',$fulfillment) }}">
                                                Rechazar
                                            </a>
                                        @else
                                            <button type="submit" class="btn btn-danger form-control" disabled>Rechazar</button>
                                        @endif
                                    @endcan
                                </fieldset>
                                <fieldset class="form-group col col-md-2">
                                    <label for=""><br></label>
                                    @can('Service Request: fulfillments finance')
                                        @if($fulfillment->finances_approver_id == NULL)
                                            <a type="button" class="btn btn-success form-control" @disabled(auth()->user()->godMode) onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');" href="{{ route('rrhh.service-request.fulfillment.confirm-Fulfillment',$fulfillment) }}">
                                                Confirmar
                                            </a>
                                        @else
                                            <button type="submit" class="btn btn-success form-control" disabled>Confirmar</button>
                                        @endif
                                    @endcan
                                </fieldset>
                            </div>
                        </div>
                    </div>
                @endcan

                @canany(['Service Request: fulfillments finance', 'Service Request: fulfillments treasury'])
                    <form method="POST" action="{{ route('rrhh.service-request.fulfillment.update',$fulfillment) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card border-info mb-3">
                            <div class="card-header bg-info text-white">
                                Datos adicionales - Finanzas/Tesorería
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <fieldset class="form-group col-5 col-md-2">
                                        <label for="for_resolution_number">N° Resolución</label>
                                        <input type="text" class="form-control" disabled name="resolution_number" value="{{$serviceRequest->resolution_number}}">
                                    </fieldset>
                                    <fieldset class="form-group col-7 col-md-2">
                                        <label for="for_resolution_date">Fecha Resolución</label>
                                        <input type="date" class="form-control" disabled name="resolution_date" @if($serviceRequest->resolution_date) value="{{$serviceRequest->resolution_date->format('Y-m-d')}}" @endif>
                                    </fieldset>
                                    <fieldset class="form-group col col-md-2">
                                        <label for="for_total_hours_paid">Total hrs. a pagar per.</label>
                                        <input type="text" class="form-control" name="total_hours_to_pay" disabled value="{{$fulfillment->total_hours_to_pay}}">
                                    </fieldset>
                                    <fieldset class="form-group col col-md-2">
                                        <label for="for_total_paid">Total a pagar</label>
                                        <input type="text" class="form-control" name="total_to_pay" disabled value="{{$fulfillment->total_to_pay}}">
                                    </fieldset>
                                </div>
                                <div class="form-row">
                                    <fieldset class="form-group col-6 col-md-2">
                                        <label for="for_bill_number">N° Boleta</label>
                                        <input type="text" class="form-control" name="bill_number" value="{{$fulfillment->bill_number}}">
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-md-2">
                                        <label for="for_total_hours_paid">Tot. hrs pagadas per.</label>
                                        <input type="text" class="form-control" name="total_hours_paid" value="{{$fulfillment->total_hours_paid}}">
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-md-2">
                                        <label for="for_total_paid">Total pagado</label>
                                        <input type="text" class="form-control" name="total_paid" value="{{$fulfillment->total_paid}}">
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-md-2">
                                        <label for="for_payment_date">Fecha pago</label>
                                        <input type="date" class="form-control" name="payment_date" required @if($fulfillment->payment_date) value="{{$fulfillment->payment_date->format('Y-m-d')}}" @endif>
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-md-2">
                                        <label for="for_contable_month">Mes contable pago</label>
                                        <select name="contable_month" class="form-control" required>
                                            <option value=""></option>
                                            <option value="1" @if($fulfillment->contable_month == 1) selected @endif>Enero</option>
                                            <option value="2" @if($fulfillment->contable_month == 2) selected @endif>Febrero</option>
                                            <option value="3" @if($fulfillment->contable_month == 3) selected @endif>Marzo</option>
                                            <option value="4" @if($fulfillment->contable_month == 4) selected @endif>Abril</option>
                                            <option value="5" @if($fulfillment->contable_month == 5) selected @endif>Mayo</option>
                                            <option value="6" @if($fulfillment->contable_month == 6) selected @endif>Junio</option>
                                            <option value="7" @if($fulfillment->contable_month == 7) selected @endif>Julio</option>
                                            <option value="8" @if($fulfillment->contable_month == 8) selected @endif>Agosto</option>
                                            <option value="9" @if($fulfillment->contable_month == 9) selected @endif>Septiembre</option>
                                            <option value="10" @if($fulfillment->contable_month == 10) selected @endif>Octubre</option>
                                            <option value="11" @if($fulfillment->contable_month == 11) selected @endif>Noviembre</option>
                                            <option value="12" @if($fulfillment->contable_month == 12) selected @endif>Diciembre</option>
                                        </select>
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-md-2">
                                        <label for="for_payment_date"><br></label>
                                        <button type="submit" class="btn btn-primary form-control">Guardar</button>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </form>
                @endcan


                @if($fulfillment->responsable_approver_id != NULL || $fulfillment->rrhh_approver_id != NULL || $fulfillment->finances_approver_id != NULL)
                <h5>Visaciones</h5>
                <table class="table table-sm small">
                    <thead>
                        <tr>
                            <th>Unidad</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($fulfillment->responsable_approver_id != NULL)
                        <tr>
                            <td>Responsable</td>
                            <td>{{$fulfillment->responsable_approbation_date}}</td>
                            <td>{{$fulfillment->responsableUser->fullName}}</td>
                            <td>@if($fulfillment->responsable_approbation === 1) APROBADO @else RECHAZADO @endif</td>
                        </tr>
                        @endif
                        @if($fulfillment->rrhh_approver_id != NULL)
                        <tr>
                            <td>RRHH</td>
                            <td>{{$fulfillment->rrhh_approbation_date}}</td>
                            <td>{{$fulfillment->rrhhUser->fullName}}</td>
                            <td>@if($fulfillment->rrhh_approbation === 1) APROBADO @else RECHAZADO @endif</td>
                        </tr>
                        @endif
                        @if($fulfillment->finances_approver_id != NULL)
                        <tr>
                            <td>Finanzas</td>
                            <td>{{$fulfillment->finances_approbation_date}}</td>
                            <td>{{$fulfillment->financesUser->fullName}}</td>
                            <td>@if($fulfillment->finances_approbation === 1) APROBADO @else RECHAZADO @endif</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    @else
        <div class="card bg-info border-dark mb-3">
            <div class="card-header">
                <h4>Remanente del período: {{$fulfillment->year}}-{{$fulfillment->month}} ({{Carbon\Carbon::parse($fulfillment->year . "-" . $fulfillment->month)->monthName}}) 
                <span class="small text-muted float-right">{{ $fulfillment->id}}
                    @can('Service Request: delete fulfillments')
                        <a class="btn btn-outline-danger" href="{{ route('rrhh.service-request.fulfillment.destroy',$fulfillment) }}" onclick="return confirm('¿Está seguro que desea eliminar el período?')">
                            Eliminar período
                        </a>
                    @endcan
                </span>
                </h4>
                
                
            </div>

            <div class="card-body">

                <!-- información adicional rrhh -->
                @can('Service Request: fulfillments rrhh')
                <form method="POST" action="{{ route('rrhh.service-request.fulfillment.update',$fulfillment) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card border-danger mb-3">
                        <div class="card-header bg-danger text-white">
                            Datos adicionales - RRHH
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <fieldset class="form-group col-6 col-md-2">
                                    <label for="for_total_paid">Total a pagar</label>
                                    <input type="text" class="form-control" name="total_to_pay" value="{{$fulfillment->total_to_pay}}">     
                                </fieldset>
                            </div>

                            <div class="form-row">
                                <div class="col-12 col-md-2">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                                <div class="col-12 col-md-7">

                                </div>
                                <div class="col-12 col-md-3 text-right">
                                    @if($fulfillment->rrhh_approver_id == NULL)
                                        <a type="button" class="btn btn-danger" @disabled(auth()->user()->godMode) onclick="return confirm('Una vez rechazado, no podrá modificar la información. ¿Está seguro de rechazar?');" href="{{ route('rrhh.service-request.fulfillment.refuse-Fulfillment',$fulfillment) }}">
                                            Rechazar
                                        </a>
                                        <a type="button" class="btn btn-success" @disabled(auth()->user()->godMode) onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');" href="{{ route('rrhh.service-request.fulfillment.confirm-Fulfillment',$fulfillment) }}">
                                            Confirmar
                                        </a>
                                    @else
                                        <button type="submit" class="btn btn-danger" disabled>Rechazar</button>
                                        <button type="submit" class="btn btn-success" disabled>Confirmar</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @endcan

                <!-- información  boleta -->
                <div class="card border-warning mb-3">
                    <div class="card-header bg-warning text-white">
                        Boleta
                    </div>
                    <div class="card-body">

                        <div class="form-row">

                            <div class="col-12 col-md-8">
                                @if($fulfillment->total_to_pay)
                                @livewire('service-request.upload-invoice', ['fulfillment' => $fulfillment])
                                @else
                                No se ha ingresado el "Total a pagar".
                                @endif
                            </div>
                            <!-- <div class="col-12 col-md-4">
                                <strong>Valor de la boleta</strong>
                                <div>
                                    $ {{$fulfillment->getValueMonthlyQuoteValue()}}
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <!-- fin información boleta -->

                <!-- información adicional finanzas -->
                @canany(['Service Request: fulfillments finance'])
                    <div class="card border-dark mb-3">
                        <div class="card-header bg-info text-white">
                            Datos adicionales - Finanzas/Contabilidad
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <fieldset class="form-group col col-md-2">
                                    <label for="for_total_paid">Total a pagar</label>
                                    <input type="text" class="form-control" name="total_to_pay" disabled value="{{$fulfillment->total_to_pay}}">
                                </fieldset>
                                <fieldset class="form-group col col-md-6">
                                    
                                </fieldset>
                                <fieldset class="form-group col col-md-2">
                                    <label for="for_total_paid"><br></label>
                                    @can('Service Request: fulfillments finance')
                                        @if($fulfillment->finances_approver_id == NULL)
                                            <a type="button" class="btn btn-danger form-control" @disabled(auth()->user()->godMode) onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de rechazar?');" href="{{ route('rrhh.service-request.fulfillment.refuse-Fulfillment',$fulfillment) }}">
                                                Rechazar
                                            </a>
                                        @else
                                            <button type="submit" class="btn btn-danger form-control" disabled>Rechazar</button>
                                        @endif
                                    @endcan
                                </fieldset>
                                <fieldset class="form-group col col-md-2">
                                    <label for="for_total_paid"><br></label>
                                    @can('Service Request: fulfillments finance')
                                        @if($fulfillment->finances_approver_id == NULL)
                                            <a type="button" class="btn btn-success form-control" @disabled(auth()->user()->godMode) onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');" href="{{ route('rrhh.service-request.fulfillment.confirm-Fulfillment',$fulfillment) }}">
                                                Confirmar
                                            </a>
                                        @else
                                            <button type="submit" class="btn btn-success form-control" disabled>Confirmar</button>
                                        @endif
                                    @endcan
                                </fieldset>
                            </div>
                        </div>
                    </div>
                @endcan

                @canany(['Service Request: fulfillments finance', 'Service Request: fulfillments treasury'])
                    <form method="POST" action="{{ route('rrhh.service-request.fulfillment.update',$fulfillment) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card border-dark mb-3">
                            <div class="card-header bg-info text-white">
                                Datos adicionales - Finanzas/Tesorería
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <fieldset class="form-group col col-md-2">
                                        <label for="for_total_paid">Total a pagar</label>
                                        <input type="text" class="form-control" name="total_to_pay" disabled value="{{$fulfillment->total_to_pay}}">
                                    </fieldset>
                                </div>
                                <div class="form-row">
                                    <fieldset class="form-group col-6 col-md-2">
                                        <label for="for_bill_number">N° Boleta</label>
                                        <input type="text" class="form-control" name="bill_number" value="{{$fulfillment->bill_number}}">
                                    </fieldset>
                                    <!-- <fieldset class="form-group col-6 col-md-2">
                                        <label for="for_total_hours_paid">Tot. hrs pagadas per.</label>
                                        <input type="text" class="form-control" name="total_hours_paid" value="{{$fulfillment->total_hours_paid}}">
                                    </fieldset> -->
                                    <fieldset class="form-group col-6 col-md-2">
                                        <label for="for_total_paid">Total pagado</label>
                                        <input type="text" class="form-control" name="total_paid" value="{{$fulfillment->total_paid}}">
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-md-2">
                                        <label for="for_payment_date">Fecha pago</label>
                                        <input type="date" class="form-control" name="payment_date" required @if($fulfillment->payment_date) value="{{$fulfillment->payment_date->format('Y-m-d')}}" @endif>
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-md-3">
                                        <label for="for_contable_month">Mes contable pago</label>
                                        <select name="contable_month" class="form-control" required>
                                            <option value=""></option>
                                            <option value="1" @if($fulfillment->contable_month == 1) selected @endif>Enero</option>
                                            <option value="2" @if($fulfillment->contable_month == 2) selected @endif>Febrero</option>
                                            <option value="3" @if($fulfillment->contable_month == 3) selected @endif>Marzo</option>
                                            <option value="4" @if($fulfillment->contable_month == 4) selected @endif>Abril</option>
                                            <option value="5" @if($fulfillment->contable_month == 5) selected @endif>Mayo</option>
                                            <option value="6" @if($fulfillment->contable_month == 6) selected @endif>Junio</option>
                                            <option value="7" @if($fulfillment->contable_month == 7) selected @endif>Julio</option>
                                            <option value="8" @if($fulfillment->contable_month == 8) selected @endif>Agosto</option>
                                            <option value="9" @if($fulfillment->contable_month == 9) selected @endif>Septiembre</option>
                                            <option value="10" @if($fulfillment->contable_month == 10) selected @endif>Octubre</option>
                                            <option value="11" @if($fulfillment->contable_month == 11) selected @endif>Noviembre</option>
                                            <option value="12" @if($fulfillment->contable_month == 12) selected @endif>Diciembre</option>
                                        </select>
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-md-2">
                                        <label for=""><br></label>
                                        <button type="submit" class="btn btn-primary form-control">Guardar</button>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </form>
                @endcan


                @if($fulfillment->responsable_approver_id != NULL || $fulfillment->rrhh_approver_id != NULL || $fulfillment->finances_approver_id != NULL)
                <h5>Visaciones</h5>
                <table class="table table-sm small">
                    <thead>
                        <tr>
                            <th>Unidad</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($fulfillment->responsable_approver_id != NULL)
                        <tr>
                            <td>Responsable</td>
                            <td>{{$fulfillment->responsable_approbation_date}}</td>
                            <td>{{$fulfillment->responsableUser->fullName}}</td>
                            <td>@if($fulfillment->responsable_approbation === 1) APROBADO @else RECHAZADO @endif</td>
                        </tr>
                        @endif
                        @if($fulfillment->rrhh_approver_id != NULL)
                        <tr>
                            <td>RRHH</td>
                            <td>{{$fulfillment->rrhh_approbation_date}}</td>
                            <td>{{$fulfillment->rrhhUser->fullName}}</td>
                            <td>@if($fulfillment->rrhh_approbation === 1) APROBADO @else RECHAZADO @endif</td>
                        </tr>
                        @endif
                        @if($fulfillment->finances_approver_id != NULL)
                        <tr>
                            <td>Finanzas</td>
                            <td>{{$fulfillment->finances_approbation_date}}</td>
                            <td>{{$fulfillment->financesUser->fullName}}</td>
                            <td>@if($fulfillment->finances_approbation === 1) APROBADO @else RECHAZADO @endif</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    @endif
    <br>
@endforeach

@can('Service Request: add fulfillments')
<div class="float-right">
	<a href="{{route('rrhh.service-request.fulfillment.add_fulfillment', $serviceRequest)}}"
		class="btn btn-outline-primary"> Agregar período
	</a>
</div>
@endcan


