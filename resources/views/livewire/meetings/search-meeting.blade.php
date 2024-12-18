<div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm small">
            <thead>
                <tr class="text-center">
                    <th width="4%">ID</th>
                    <th width="7%">Estado</th>
                    <th width="8%">Fecha Creación</th>
                    <th width="8%">Fecha Reunión</th>
                    <th>Tipo</th>
                    <th>Asunto</th>
                    <th width="8%">N° Compromisos</th>
                    <th width="8%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($meetings as $key => $meeting)
                    <tr>
                        <th class="text-center">{{ $meeting->id }}</th>
                        <td class="text-center">
                            @switch($meeting->StatusValue)
                                @case('Guardado')
                                    <span class="badge text-bg-warning">{{ $meeting->StatusValue }}</span>
                                    @break

                                @case('Derivado SGR')
                                    <span class="badge text-bg-primary">{{ $meeting->StatusValue }} <i class="fas fa-rocket"></i></span>
                                    @break
                            @endswitch
                        </td>
                        <td>{{ $meeting->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $meeting->date }}</td>
                        <td class="text-center">{{ $meeting->TypeValue }}</td>
                        <td>
                            {{ $meeting->subject }}
                            <br><br>
                            <small>Creado por: <b>{{ $meeting->userCreator->tinyName }}</b></small>
                        </td>
                        <td class="text-center">{{ ($meeting->commitments) ? $meeting->commitments->count() : 0 }}</td>
                        <td class="text-center">
                            @if($meeting->StatusValue == 'Guardado')
                                <a href="{{ route('meetings.edit', $meeting) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-edit fa-fw"></i>
                                </a>

                                {{--
                                <a class="btn btn-outline-danger btn-sm"
                                    wire:click="deleteMeeting({{ $key }})">
                                    <i class="fas fa-trash-alt fa-fw"></i>
                                </a>
                                --}}
                            @endif
                                
                            @if($meeting->StatusValue == 'Derivado SGR')
                                <a href="{{ route('meetings.show', $meeting) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-eye fa-fw"></i>
                                </a>
                            @endif
                            
                            @if($meeting->file)
                                <a href="{{ route('meetings.show_file', $meeting) }}"
                                    class="btn btn-outline-primary btn-sm" target="_blank">
                                    <i class="fas fa-paperclip fa-fw"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
