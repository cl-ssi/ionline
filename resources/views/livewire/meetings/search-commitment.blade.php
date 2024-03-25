<div>
    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped table-sm small">
            <thead>
                <tr class="text-center">
                    <th>N° Reunión</th>
                    <th>Fecha Reunión</th>
                    <th>Tipo</th>
                    <th>Asunto</th>
                    <th>Prioridad</th>
                    <th>Tipo</th>
                    <th>Funcionario / Unidad Organizacional</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commitments as $key => $commitment)
                    <tr>
                        <th class="text-center" width="3%">{{ $commitment->meeting->id }}</th>
                        <td width="7%" class="text-center">{{ $commitment->meeting->date }}</td>
                        <td width="10%" class="text-center">{{ $commitment->meeting->TypeValue }}</td>
                        <td width="20%">{{ $commitment->meeting->subject }}</td>
                        <td class="text-center">{{-- $commitment->TypeValue --}}</td>
                        <td>{{-- $meeting->subject --}}</td>
                        <td width="8%" class="text-center">
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
