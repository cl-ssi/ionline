<div>
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
                                <td @if($SignatureFlow->status === 1) class="table-success" @endif>
                                    @if ($SignatureFlow->status === null)
                                    Aca deberia estar la logica para el guardado
                                    @elseif($SignatureFlow->status === 1)
                                        Aceptada
                                    @elseif($SignatureFlow->status === 0)
                                        Rechazada
                                    @elseif($SignatureFlow->status === 2)
                                        Devuelta
                                    @endif
                                </td>

                                <td>{{ $SignatureFlow->observation }}</td>

                                <td>{{ $SignatureFlow->signature_date}}</td>






                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>



        </div>
    </div>
</div>
