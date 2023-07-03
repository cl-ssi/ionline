<div>

    @include('welfare.nav')

    @include('layouts.partials.errors')
    @include('layouts.partials.flash_message')
    
    <h3 class="mb-3">Solicitudes de beneficio AmiPass</h3>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Run</th>
                <th>Correo Personal</th>
                <th>Unidad Organizacional</th>
                <th>Inicio Contrato</th>
                <th>Término Contrato</th>
                <th>AmiPass</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
            <tr class="{{ ($request->estado == 'Ok') ? 'table-success': '' }}">
                <td>{{ $request->id }}</td>
                <td>{{ $request->nombre_completo }}</td>
                <td>{{ $request->rut_funcionario }}</td>
                <td>{{ $request->correo_personal }}</td>
                <td>{{ $request->donde_cumplira_funciones }}</td>
                <td>{{ $request->fecha_inicio_contrato }}</td>
                <td>{{ $request->fecha_termino_contrato }}</td>
                <td class="small">
                    {{ optional($request->ami_manager)->shortName }}
                    <br>
                    {{ $request->ami_manager_at }}
                </td>
                <td>
                    <button class="btn btn-primary" wire:click="showElement({{ $request->id }})">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
                <td>
                    @if($request->estado == 'Ok')
                        <button class="btn btn-secondary" disabled>
                            <i class="fas fa-check"></i>
                        </button>
                    @else
                        <button class="btn btn-primary" wire:click="amiOk({{ $request->id }})">
                            <i class="fas fa-check"></i>
                        </button>
                    @endif
                </td>
            </tr>
            @if($element == $request->id)
                <tr>
                    <td colspan="9">
                        <table class="table table-sm">
                            <tr>
                                <th>Jefatura</th>
                                <td>
                                    {{ $beneficiaryRequest->nombre_jefatura }}
                                </td>
                            </tr>
                            <tr>
                                <th>Correo Jefatura</th>
                                <td>
                                    {{ $beneficiaryRequest->correo_jefatura }}
                                </td>
                            </tr>
                            <tr>
                                <th>Motivo Requerimiento</th>
                                <td>
                                    {{ $beneficiaryRequest->motivo_requerimiento }}
                                </td>
                            </tr>
                            <tr>
                                <th>Nombre Funcionario a Reemplazar</th>
                                <td>
                                    {{ $beneficiaryRequest->nombre_funcionario_reemplazar }}
                                </td>
                            </tr>
                            <tr>
                                <th>Jornada Laboral</th>
                                <td>
                                    {{ $beneficiaryRequest->jorndada_laboral }}
                                </td>
                            </tr>
                            <tr>
                                <th>Residencia</th>
                                <td>
                                    {{ $beneficiaryRequest->residencia }}
                                </td>
                            </tr>
                        </table> 
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary" wire:click="closeElement">
                            X
                        </button>
                    </td>
                </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    
    {{ $requests->links() }}
</div>
