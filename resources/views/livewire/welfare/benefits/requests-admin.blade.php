<div>
    @include('welfare.nav')

    <h4>Administrador de solicitudes</h4>

    <!-- Mensaje de éxito -->
    @include('layouts.bt4.partials.flash_message')

    <table class="table table-bordered table-sm" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha solicitud</th>
                <th>Solicitante</th>
                <th>Beneficio</th>
                <th>Adjunto</th>
                <!-- <th>Estado</th> -->
                <th nowrap>Acciones</th>
                <th>Monto aceptado</th>
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
                        @if($request->accepted_amount)
                        <br><b>Monto aceptado: </b> ${{ money($request->accepted_amount) }}
                        @endif
                        @if($request->status_update_observation)
                        <br><b>Observaciones: </b> {{ $request->status_update_observation }}
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
                    <!-- <td>{{ $request->status }}</td> -->
                    <td nowrap>
                        <div class="input-group mb-3">
                            @if($request->status == "En revisión")
                                <button class="btn btn-outline-success" wire:click="accept({{$request->id}})" type="button">Aceptar</button>
                                <button class="btn btn-outline-danger" wire:click="reject({{$request->id}})" type="button">Rechazar</button>
                            @endif
                            @if($request->status == "Aceptado")
                                <button class="btn btn-success" type="button">Aceptado</button>
                                <button class="btn btn-outline-danger" wire:click="reject({{$request->id}})" type="button">Rechazar</button>
                            @endif
                            @if($request->status == "Rechazado")
                                <button class="btn btn-outline-success" wire:click="accept({{$request->id}})" type="button">Aceptar</button>
                                <button class="btn btn-danger" type="button">Rechazado</button>
                            @endif
                        </div>

                        @if($request->status != "En revisión")
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" wire:model.defer="status_update_observation" placeholder="Observación" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button wire:click="saveObservation({{$request->id}})" class="btn btn-primary" type="button" id="button-addon2">
                                    <i class="bi bi-floppy"></i>
                                </button>
                            </div>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" value="" size="10" maxlength="10" wire:model.defer="accepted_amount">
                            <button class="btn btn-primary" type="button" id="button-addon2" @disabled($request->status != "Aceptado") wire:click="saveAcceptedAmount({{$request->id}})">
                                <i class="bi bi-floppy"></i>
                            </button>
                        </div>
                        <span class="text-secondary">Tope anual: $ {{$request->subsidy->annual_cap}}</span><br>
                        <span class="text-secondary">Utilizado: $ {{$request->getSubsidyUsedMoney()}}</span><br>
                        <span class="text-success ">Disponible: $ {{$request->subsidy->annual_cap - $request->getSubsidyUsedMoney()}}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
