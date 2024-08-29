<div>
    @include('welfare.nav')

    <h4>Administrador de solicitudes</h4>

    <br>
    <div>
        <label>
            <input type="checkbox" wire:model.live="statusFilters" value="En revisión"> En revisión
        </label>
        <label>
            <input type="checkbox" wire:model.live="statusFilters" value="Aceptado"> Aceptado
        </label>
        <label>
            <input type="checkbox" wire:model.live="statusFilters" value="Rechazado"> Rechazado
        </label>
        <label>
            <input type="checkbox" wire:model.live="statusFilters" value="Pagado"> Pagado
        </label>
    </div>
    <br>

    <div>
        @if (session()->has('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <table class="table table-bordered table-sm" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th >ID</th>
                <th >F.solicitud</th>
                <th >Solicitante</th>
                <th >Beneficio</th>
                <th >Adjunto</th>
                <th >Acciones</th>
                <th >Monto aprobado</th>
                <th>Notificar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $key => $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->created_at->format('Y-m-d') }}</td>
                    <td>{{ $request->applicant->shortName }}<br><b><small>{{$request->applicant->runFormat}}</small></b></td>
                    <td>
                        @if($request->subsidy->benefit) 
                            {{ $request->subsidy->benefit->name }} - {{ $request->subsidy->name }} 
                        @endif
                        <br>
                        Monto solicitado: <b>${{ money($request->requested_amount) }}</b>
                        <br><br>
                        @if($request->status != "En revisión")
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="" style="align-self: flex-start; height: auto;">Observación</span>
                                <textarea class="form-control" wire:model="requests.{{$key}}.status_update_observation" style="height: 100px;">
                                </textarea>
                                <div wire:loading wire:target="saveObservation">
                                    <i class="fas fa-spinner fa-spin"></i> Espere...
                                </div>
                                <div wire:loading.remove wire:target="saveObservation">
                                    <button wire:click="saveObservation({{ $key }})" class="btn btn-primary" type="button">
                                        <i class="bi bi-floppy"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </td>
                    <td>
                        @if($request->files->count() > 0)
                            @foreach($request->files as $file)
                                <a href="{{ route('welfare.download', $file->id) }}" target="_blank">
                                    <i class="fas fa-paperclip"></i>
                                </a>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <div class="input-group mb-3">
                            @if($request->status == "Pagado")
                                {{$request->status}}
                            @endif
                            @if($request->status == "En proceso de pago")
                                {{$request->status}}
                            @endif
                            @if($request->status == "En revisión")
                                <div wire:loading wire:target="accept">
                                    <i class="fas fa-spinner fa-spin"></i> Espere...
                                </div>
                                <div wire:loading.remove wire:target="accept">
                                    <button class="btn btn-outline-success" wire:click="accept({{$request->id}})" type="button">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <div wire:loading wire:target="reject">
                                    <i class="fas fa-spinner fa-spin"></i> Espere...
                                </div>
                                <div wire:loading.remove wire:target="reject">
                                    <button class="btn btn-outline-danger" wire:click="reject({{$request->id}})" type="button">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </div>
                                
                            @endif
                            @if($request->status == "Aceptado")
                                <button class="btn btn-success" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                                <div wire:loading wire:target="reject">
                                    <i class="fas fa-spinner fa-spin"></i> Espere...
                                </div>
                                <div wire:loading.remove wire:target="reject">
                                    <button class="btn btn-outline-danger" wire:click="reject({{$request->id}})" type="button">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </div>
                            @endif
                            @if($request->status == "Rechazado")
                                <div wire:loading wire:target="accept">
                                    <i class="fas fa-spinner fa-spin"></i> Espere...
                                </div>
                                <div wire:loading.remove wire:target="accept">
                                    <button class="btn btn-outline-success" wire:click="accept({{$request->id}})" type="button">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <button class="btn btn-danger" type="button">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            @endif
                        </div>
                        @if($showTextarea)
                            <div class="mt-2">
                                <textarea class="form-control" wire:model="observation" placeholder="Ingrese la observación"></textarea>
                                <div wire:loading wire:target="saveCancelObservation">
                                    <i class="fas fa-spinner fa-spin"></i> Espere...
                                </div>
                                <div wire:loading.remove wire:target="saveCancelObservation">
                                    <div class="mt-2">
                                        <button class="btn btn-primary" wire:click="saveCancelObservation">Guardar</button>
                                        <button class="btn btn-secondary" wire:click="cancel">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="">$</span>
                            <input type="number" class="form-control" wire:model="requests.{{$key}}.accepted_amount" @disabled($request->status != "Aceptado")>
                            
                            <div wire:loading wire:target="saveAcceptedAmount">
                                <i class="fas fa-spinner fa-spin"></i> Espere...
                            </div>
                            <div wire:loading.remove wire:target="saveAcceptedAmount">
                                <button wire:click="saveAcceptedAmount({{ $key }})" class="btn btn-primary" type="button" @disabled($request->status != "Aceptado")>
                                    <i class="bi bi-floppy"></i>
                                </button>
                            </div>
    
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="">Folio</span>
                            <input type="text" class="form-control" wire:model="requests.{{$key}}.folio_number" @disabled($request->status != "Aceptado")>
                            
                            <div wire:loading wire:target="saveFolio">
                                <i class="fas fa-spinner fa-spin"></i> Espere...
                            </div>
                            <div wire:loading.remove wire:target="saveFolio">
                                <button wire:click="saveFolio({{ $key }})" class="btn btn-primary" type="button" @disabled($request->status != "Aceptado")>
                                    <i class="bi bi-floppy"></i>
                                </button>
                            </div>

                            
                        </div>
                        @if($request->accepted_amount != null && $request->subsidy->payment_in_installments)
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="">N°Cuotas</span>
                                <input type="number" class="form-control" wire:model="requests.{{$key}}.installments_number" @disabled($request->status != "Aceptado")>
                                <button wire:click="saveInstallmentsNumber({{ $key }})" class="btn btn-primary" type="button" @disabled($request->status != "Aceptado")>
                                    <i class="bi bi-floppy"></i>
                                </button>
                            </div>
                        @endif
                        <span class="text-secondary">Descripción del beneficio: </span>{{$request->subsidy->description}}<br>
                    </td>
                    <td>
                        @if($request->payed_date)
                            {{ $request->payed_date->format('Y-m-d')}} - <b>${{ money($request->payed_amount) }}
                        @else
                            @if($request->status == "Aceptado")
                                <div wire:loading wire:target="saveTransfer">
                                    <i class="fas fa-spinner fa-spin"></i> Espere...
                                </div>
                                <div wire:loading.remove wire:target="saveTransfer">
                                    <button wire:click="saveTransfer({{$key}})" class="btn btn-success" type="button" @disabled($request->status == "Pagado")>
                                        <i class="bi bi-floppy"></i> Transferencia
                                </button>
                                </div>
                            @endif
                        @endif
                    </td>
                </tr>
                @if($request->responsable)
                    <tr>
                        <td colspan="8">
                            <small>Revisor: <b>{{$request->responsable->shortName}}</b></small>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
