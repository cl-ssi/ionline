<div>
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>            
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            Aprobaciones de Solicitud
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="card-table table table-sm table-bordered small">
                    <thead>
                        <tr>
                            <th scope="col">U.Organizacional</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Observación</th>
                            <th scope="col">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($serviceRequest->SignatureFlows->sortBy('sign_position') as $key => $SignatureFlow)
                            <tr>
                                <td>{!! optional($SignatureFlow->user->organizationalUnit)->name ??
                                    '<span class="text-danger">SIN UNIDAD ORGANIZACIONAL</span>' !!}</td>
                                <td>{{ $SignatureFlow->user->position }}</td>
                                <td>{{ $SignatureFlow->user->getFullNameAttribute() }}</td>
                                <td>
                                    @if ($SignatureFlow->sign_position == 1)
                                        Responsable
                                    @elseif($SignatureFlow->sign_position == 2)
                                        Supervisor
                                    @else
                                        {{ $SignatureFlow->type }}
                                    @endif
                                </td>
                                <td
                                    @if ($SignatureFlow->status === 1) class="table-success" @elseif($SignatureFlow->status === 0) class="table-danger" @endif>
                                    @if ($SignatureFlow->status === null)
                                        <select class="form-control-sm"
                                            wire:change="updateStatus({{ $SignatureFlow->id }}, $event.target.value)">
                                            <option value="">Seleccionar Estado</option>
                                            <option value="1">Aceptar</option>
                                            <option value="0">Rechazar</option>
                                            <option value="2">Devolver</option>
                                        </select>
                                    @elseif($SignatureFlow->status === 1)
                                        Aceptada
                                    @elseif($SignatureFlow->status === 0)
                                        Rechazada
                                    @elseif($SignatureFlow->status === 2)
                                        Devuelta
                                    @endif
                                </td>

                                <td>
                                    <input type="text" class="form-control-sm"
                                        wire:blur="updateObservation({{ $SignatureFlow->id }}, $event.target.value)"
                                        value="{{ $SignatureFlow->observation }}">
                                </td>
                                <td>{{ $SignatureFlow->signature_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>



        </div>
    </div>
</div>
