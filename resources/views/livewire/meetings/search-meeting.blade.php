<div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm small">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>Estado</th>
                    <th>Fecha Creación</th>
                    <th>Fecha Reunión</th>
                    <th>Tipo</th>
                    <th>Asunto</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($meetings as $key => $meeting)
                <tr>
                    <th class="text-center">{{ $meeting->id }}</th>
                    <td width="7%" class="text-center">
                        @switch($meeting->StatusValue)
                            @case('Guardado')
                                <span class="badge text-bg-primary">{{ $meeting->StatusValue }}</span>
                                @break

                            @case('Derivado SGR')
                                <span class="badge text-bg-primary">{{ $meeting->StatusValue }} <i class="fas fa-rocket"></i></span>
                                @break
                        @endswitch
                    </td>
                    <td width="7%">{{ $meeting->created_at->format('d-m-Y H:i:s') }}</td>
                    <td width="7%">{{ $meeting->date }}</td>
                    <td class="text-center">{{ $meeting->TypeValue }}</td>
                    <td>{{ $meeting->subject }}</td>
                    <td width="8%" class="text-center">
                        <a href="{{ route('meetings.edit', $meeting) }}"
                            class="btn btn-outline-secondary btn-sm">
                            @if($meeting->StatusValue == 'Guardado') <i class="fas fa-edit"></i> @else <i class="fas fa-eye"></i> @endif 
                        </a>
                        <a class="btn btn-outline-danger btn-sm"
                            wire:click="deleteMeeting({{ $key }})">
                            <i class="fas fa-trash-alt fa-fw"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
