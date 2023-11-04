<div>
    @include('his.partials.nav')

    <h3 class="mb-3">Mis solicitudes de Ficha Clínica</h3>

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>VBs</th>
                    <th>Solicitante</th>
                    <th>Tipo</th>
                    <th>Asunto</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($modifications as $modification)
                <tr class="table-{{ $modification->color }}">
                    <td>{{ $modification->id }}</td>
                    <td>
                        @foreach($modification->approvals as $approval)
                            <i class="fa fa-fw fa-lg {{ $approval->icon }} text-{{ $approval->color }}" 
                                title="{{ $approval->sentToOu->name }}"></i>
                        @endforeach
                    </td>
                    <td>{{ $modification->creator->shortName }}</td>
                    <td>{{ $modification->type }}</td>
                    <td>{{ $modification->subject }}</td>
                    <td>{{ $modification->created_at }}</td>
                    <td>
                        @switch($modification->status)
                            @case('1')
                                Listo
                            @break
                            @case('0')
                                Rechazado
                            @break
                            @default
                                
                            @break
                        @endswitch

                        @foreach($modification->approvals as $approval)
                            @if($approval->approver_observation)
                                <br><span class="smal text-danger">{{ $approval->approver_observation }} </span> 
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <a class="btn btn-sm btn-outline-danger" target="_blank" 
                            href="{{ route('his.modification-request.show', $modification->id) }}">
                            <i class="fas fa-fw fa-file-pdf"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $modifications->links() }}

</div>
