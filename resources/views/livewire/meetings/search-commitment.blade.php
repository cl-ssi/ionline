<div>
    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped table-sm small">
            <thead>
                <tr class="text-center">
                    <th>N° Reunión</th>
                    <th>Fecha Reunión</th>
                    <th>Tipo</th>
                    <th>Asunto</th>
                    <th width="30%">Descripción</th>
                    <th>Funcionario / Unidad Organizacional</th>
                    <th width="7%">Fecha límite</th>
                    <th width="10%">Estado <i class="fas fa-rocket"></i> SGR</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commitments as $key => $commitment)
                    <tr>
                        <th class="text-center" width="3%">{{ $commitment->meeting->id }}</th>
                        <td width="7%" class="text-center">{{ $commitment->meeting->date }}</td>
                        <td width="10%" class="text-center">{{ $commitment->meeting->TypeValue }}</td>
                        <td width="20%">
                            {{ $commitment->meeting->subject }}
                            <br><br>
                            <small>Creado por: <b>{{ $commitment->meeting->userCreator->tinyName }}</b></small>
                        </td>
                        <td style="text-align: justify;">{{ $commitment->description }}</td>
                        <td width="14%" class="text-center">{{ ($commitment->commitment_user_id) ?  $commitment->commitmentUser->tinyName : $commitment->commitmentOrganizationalUnit->name }}</td>
                        <td width="7%" class="text-center">
                            {{ ($commitment['closing_date']) ? $commitment['closing_date'] : 'Sin fecha límite' }} <br>
                            @switch($commitment->priority)
                                @case('normal')
                                    <span class="badge text-bg-success">{{ $commitment->priority }}</span>
                                    @break
                                @case('urgente')
                                    <span class="badge text-bg-danger">{{ $commitment->priority }}</span>
                                    @break
                            @endswitch
                        </td>
                        <td width="8%" class="text-center">
                            @switch($commitment->requirement->status)
                                @case('creado')
                                    <span class="badge text-bg-light">{{ $commitment->requirement->status }}</span>
                                    @break
                                @case('respondido') 
                                    <span class="badge text-bg-warning">{{ $commitment->requirement->status }}</span>
                                    @break
                                @case('cerrado') 
                                    <span class="badge text-bg-success">{{ $commitment->requirement->status }}</span>
                                    @break
                                @case('derivado') 
                                    <span class="badge text-bg-primary">{{ $commitment->requirement->status }}</span>
                                    @break
                                @case('reabierto')
                                    <span class="badge text-bg-light">{{ $commitment->requirement->status }}</span>
                                    @break
                            @endswitch
                            <br>
                            <a class="btn btn-primary btn-sm" href="{{ route('requirements.show', $commitment->requirement->id) }}" target="_blank">
                                <i class="fas fa-rocket"></i> SGR
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
