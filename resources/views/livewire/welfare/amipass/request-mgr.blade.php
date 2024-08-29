<div>

    @include('welfare.nav')

    @include('layouts.bt4.partials.errors')
    @include('layouts.bt4.partials.flash_message')

<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('welfare.amipass.new-beneficiary-request') }}" target="blank">
            Agregar Solicitud de Beneficio Amipass
        </a>
    </div>
</div>
    
    <h3 class="mb-3">Solicitudes de beneficio Amipass</h3>

    <div class="row mb-3">
        <div class="col-lg-6">
            <input type="text" wire:model="filter" class="form-control" placeholder="Buscar por RUN o nombre">
        </div>
        <div class="col-lg-1">
            <button class="btn btn-primary" wire:click="searchBeneficiary">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th nowrap>Fecha Solic.</th>
                <th>Nombre</th>
                <th>Run</th>
                <th>Correo Personal</th>
                <th>Unidad Organizacional</th>
                <th>Inicio Contrato</th>
                <th>Término Contrato</th>
                <th>Amipass</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
            <tr class="{{ ($request->estado == 'Ok') ? 'table-success': '' }}">
                <td>{{ $request->id }}</td>
                <td>{{ $request->created_at }}</td>
                <td>{{ $request->nombre_completo }}</td>
                <td>{{ $request->rut_funcionario }}</td>
                <td>{{ $request->correo_personal }}</td>
                <td>{{ $request->donde_cumplira_funciones }}</td>
                <td>{{ optional($request->fecha_inicio_contrato)->format('Y-m-d') }}</td>
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
