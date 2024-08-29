<div>
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>
    @endif


    <h5 class="card-title">Aprobaciones</h5>

    <table class="table table-sm table-bordered small">
        <thead>
            <tr>
                <th scope="col">U.Organizacional</th>
                <th scope="col">Cargo</th>
                <th scope="col">Usuario</th>
                <th scope="col">Tipo</th>
                <th scope="col">Estado</th>
                <th scope="col">Observación</th>
                <th scope="col">Fecha</th>
                @canany(['Service Request: additional data rrhh'])
                    <th scope="col"></th>
                @endcanany
                
            </tr>
        </thead>
        <tbody>
            @foreach ($serviceRequest->SignatureFlows->sortBy('sign_position') as $key => $SignatureFlow)
                @if($SignatureFlow->status === null)
                    <tr class="table-light">
                @elseif($SignatureFlow->status === 0)
                    <tr class="table-danger">
                @elseif($SignatureFlow->status === 1)
                    <tr>
                @elseif($SignatureFlow->status === 2)
                    <tr class="table-warning">
                @else
                    <tr>
                @endif

                    <td>{!! optional($SignatureFlow->user->organizationalUnit)->name ??
                        '<span class="text-danger">SIN UNIDAD ORGANIZACIONAL</span>' !!}</td>
                    <td>{{ $SignatureFlow->user->position }}</td>
                    <td>{{ $SignatureFlow->user->shortName }}</td>
                    <td>
                        @if ($SignatureFlow->sign_position == 1)
                            Responsable
                        @elseif($SignatureFlow->sign_position == 2)
                            Supervisor
                        @else
                            {{ $SignatureFlow->type }}
                        @endif
                    </td>

                    <!-- mientras el usuario logeado sea el "proximo" firmante y mientras la solicitud no este cancelada: se puede visar -->
                    @if($SignatureFlow->serviceRequest->SignatureFlows->whereNull('status')->count() > 0
                        && $SignatureFlow->serviceRequest->SignatureFlows->whereNull('status')->sortBy('sign_position')->first()->responsable_id == auth()->id()
                        && $SignatureFlow->serviceRequest->SignatureFlows->where('status', '===', 0)->count() == 0 
                        && $SignatureFlow->responsable_id == auth()->id())

                        <td>
                            <select class="form-control-sm" wire:model="status" >
                                <option value="">Seleccionar Estado</option>
                                <option value="1">Aceptar</option>
                                <option value="0">Rechazar</option>
                                <option value="2">Devolver</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control-sm"
                            value="{{ $SignatureFlow->observation }}" wire:model="observation">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" @disabled(auth()->user()->godMode) wire:click="saveSignatureFlow({{ $SignatureFlow->id }})">Guardar</button>
                        </td>
                    @else
                        <td>
                            @if ($SignatureFlow->status === null)
                                Pendiente
                            @elseif($SignatureFlow->status === 1)
                                Aceptada
                            @elseif($SignatureFlow->status === 0)
                                Rechazada
                            @elseif($SignatureFlow->status === 2)
                                Devuelta
                            @endif
                        </td>
                        <td>
                            @if ($SignatureFlow->signature_date)
                                {{ $SignatureFlow->observation }}
                            @endif
                        </td>
                        <td>
                            @if ($SignatureFlow->signature_date)
                                {{ $SignatureFlow->signature_date }}
                            @endif
                        </td>
                    @endif

                    @canany(['Service Request: additional data rrhh'])
                        <td>
                            @if($SignatureFlow->serviceRequest->SignatureFlows->whereNull('status')->count() > 0)
                            <button class="btn btn-sm btn-outline-primary" wire:click="edit({{$SignatureFlow}})" @disabled(auth()->user()->godMode)>
                                <span class="fas fa-edit" aria-hidden="true"></span>
                            </button>
                            @endif
                        </td>
                    @endcanany
                    
                </tr>
            @endforeach
        </tbody>
    </table>

    @include('layouts.bt4.partials.errors')
    @include('layouts.bt4.partials.flash_message_custom',[
        'name' => 'approval-workflow',  // debe ser único
        'type' => 'primary' // optional: 'primary' (default), 'danger', 'warning', 'success', 'info'
    ])

    @if($showDiv)
        <table class="table table-sm table-bordered small">
            <tbody>
            <tr>
                <td>
                    @livewire('search-select-user',['user' => $edit_user])
                </td>
                <td>
                    <select class="form-control" wire:model="edit_status" >
                        <option value="">Seleccionar Estado</option>
                        <option value="1" @selected($edit_status == 1)>Aceptar</option>
                        <option value="0" @selected($edit_status == 0)>Rechazar</option>
                        <option value="2" @selected($edit_status == 2)>Devolver</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control"
                    value="{{ $SignatureFlow->observation }}" wire:model="edit_observation">
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" wire:click="save()" @disabled(auth()->user()->godMode)>Guardar</button>
                    <button class="btn btn-sm btn-outline-danger" wire:click="delete()" @disabled(auth()->user()->godMode)>Eliminar</button>
                </td>
            </tr>
            </tbody>
        </table>

        <hr>
    @endif

</div>
