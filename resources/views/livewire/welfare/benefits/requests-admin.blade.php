<div>
    @include('welfare.nav')

    <h4>Administrador de solicitudes</h4>

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
                <th>ID</th>
                <th style="width: 8%">F.solicitud</th>
                <th style="width: 12%">Solicitante</th>
                <th style="width: 25%">Beneficio</th>
                <th style="width: 5%">Adjunto</th>
                <!-- <th>Estado</th> -->
                <th style="width: 8%">Acciones</th>
                <th style="width: 20%">Monto aceptado</th>
                <th>Monto transferido</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $key => $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->created_at->format('Y-m-d') }}</td>
                    <td>{{ $request->applicant->shortName }}</td>
                    <td>
                        {{ $request->subsidy->benefit->name }} - {{ $request->subsidy->name }}
                        <br><br>
                        @if($request->status != "En revisión")
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="">Observación</span>
                                <input type="text" class="form-control" wire:model.defer="requests.{{$key}}.status_update_observation">
                                <button wire:click="saveObservation({{ $key }})" class="btn btn-primary" type="button">
                                    <i class="bi bi-floppy"></i>
                                </button>
                            </div>
                        @endif
                    </td>
                    <td>
                        @if($request->files->count() > 0)
                            @foreach($request->files as $file)
                                <a href="#" wire:click="showFile({{ $file->id }})">
                                <span class="fas fa-download" aria-hidden="true"></span></a>
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
                                <button class="btn btn-outline-success" wire:click="accept({{$request->id}})" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                                <button class="btn btn-outline-danger" wire:click="reject({{$request->id}})" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                            @endif
                            @if($request->status == "Aceptado")
                                <button class="btn btn-success" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                                <button class="btn btn-outline-danger" wire:click="reject({{$request->id}})" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                            @endif
                            @if($request->status == "Rechazado")
                                <button class="btn btn-outline-success" wire:click="accept({{$request->id}})" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                                <button class="btn btn-danger" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                            @endif
                        </div>
                    </td>
                    <td class="text-end">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="">$</span>
                            <input type="number" class="form-control" wire:model.defer="requests.{{$key}}.accepted_amount">
                            <button wire:click="saveAcceptedAmount({{ $key }})" class="btn btn-primary" type="button" @disabled($request->status != "Aceptado")>
                                <i class="bi bi-floppy"></i>
                            </button>
                        </div>
                        @if($request->accepted_amount != null && $request->subsidy->payment_in_installments)
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="">N°Cuotas</span>
                                <input type="number" class="form-control" wire:model.defer="requests.{{$key}}.installments_number">
                                <button wire:click="saveInstallmentsNumber({{ $key }})" class="btn btn-primary" type="button" @disabled($request->status != "Aceptado")>
                                    <i class="bi bi-floppy"></i>
                                </button>
                            </div>
                        @endif
                        <!-- se muestra solo si el subsidio tiene un tope anual -->
                        @if($request->subsidy->annual_cap != null)
                            <span class="text-secondary">Tope anual: $ {{ money($request->subsidy->annual_cap) }}</span><br>
                            <span class="text-secondary">Utilizado: $ {{ money($request->getSubsidyUsedMoneyAll()) }}</span><br>
                            <span class="text-success ">Disponible: $ {{ money($request->subsidy->annual_cap - $request->getSubsidyUsedMoneyAll())}}</span>
                        @else
                            <span class="text-secondary">Descripción del beneficio: </span>{{$request->subsidy->description}}<br>
                        @endif
                    </td>
                    <td>
                        <!-- cuando tenga tope anual -->
                        @if($request->subsidy->annual_cap != null)
                            <!-- cuando el pago es en cuotas -->
                            @if($request->subsidy->payment_in_installments)
                                @foreach($request->transfers as $key2 => $transfer)
                                    @if($transfer->payed_amount != null)
                                        <li>
                                            {{$transfer->payed_date->format('Y-m-d')}} - <b>${{ money($transfer->payed_amount)}}</b>
                                        </li>
                                    @else
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon3">$</span>
                                            <input type="number" class="form-control" wire:model.defer="requests.{{$key}}.transfers.{{$key2}}.payed_amount">
                                            <button wire:click="saveTransfer({{$key}},{{ $key2 }})" class="btn btn-primary" type="button" @disabled($request->status == "Pagado")>
                                                <i class="bi bi-floppy"></i>
                                            </button>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <!-- pago tiene tope anual pero no es en cuotas -->
                                @if($request->transfers->count() > 0)
                                    <li>
                                        {{$request->transfers->first()->payed_date->format('Y-m-d')}} - <b>${{ money($request->transfers->first()->payed_amount)}}</b>
                                    </li>
                                @else
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="">Transferir</span>
                                        <button wire:click="saveTransferWithoutInstallments({{$key}})" class="btn btn-primary" type="button" @disabled($request->status == "Pagado")>
                                            <i class="bi bi-floppy"></i>
                                        </button>
                                    </div>
                                @endif
                            @endif
                        @else
                            @if($request->accepted_amount != null)
                                @if($request->transfers->count() > 0)
                                    <li>
                                        {{$request->transfers->first()->payed_date->format('Y-m-d')}} - <b>${{ money($request->transfers->first()->payed_amount)}}</b>
                                    </li>
                                @else
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="">$ Transferencia</span>
                                        <button wire:click="saveTransferWithoutInstallments({{$key}})" class="btn btn-primary" type="button" @disabled($request->status == "Pagado")>
                                            <i class="bi bi-floppy"></i>
                                        </button>
                                    </div>
                                @endif
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
