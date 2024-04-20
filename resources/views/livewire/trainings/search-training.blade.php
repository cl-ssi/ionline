<div>
<div class="table-responsive">
        <table class="table table-bordered table-striped table-sm small">
            <thead>
                <tr class="text-center">
                    <th rowspan="2">ID</th>
                    <th rowspan="2">Estado</th>
                    <th rowspan="2">Fecha Creación</th>
                    <th rowspan="2">Funcionario</th>
                    <th rowspan="2">Nombre de la Actividad</th>
                    <th colspan="2">Fecha</th>
                    <th rowspan="2"></th>
                </tr>
                <tr class="text-center">
                    <th>Inicio</th>
                    <th>Termino</th>
                </tr>
            </thead>
            <tbody>
                {{-- dd($trainings) --}}
                @foreach($trainings as $key => $training)
                <tr>
                    <th class="text-center" width="4%">{{ $training->id }}</th>
                    <td width="7%" class="text-center">
                        @switch($training->StatusValue)
                            @case('Guardado')
                                <span class="{{ ($bootstrap == 'v4') ? 'badge badge-primary' : 'badge text-bg-primary' }}">{{ $training->StatusValue }}</span>
                                @break
                            
                            @case('Enviado')
                                <span class="{{ ($bootstrap == 'v4') ? 'badge badge-warning' : 'badge text-bg-warning' }}">{{ $training->StatusValue }}</span>
                                @break

                            @case('Pendiente')
                                <span class="badge text-bg-warning">{{ $training->StatusValue }}</span>
                                @break
                        
                            @case(2)
                                Second case...
                                @break
                        
                            @default
                                Default case...
                        @endswitch
                    </td>
                    <td width="7%">{{ $training->created_at->format('d-m-Y H:i:s') }}</td>
                    <td width="30%">
                        {{ (auth()->guard('external')->check() == true) ? $training->userTraining->FullName : $training->userTraining->TinnyName }} <br><br>
                        <small><b>{{ ($training->userTrainingOu) ? $training->userTrainingOu->name : 'Funcionario Externo'}}</b></small> <br>
                        <small><b>{{ ($training->userTrainingEstablishment) ? $training->userTrainingEstablishment->name : '' }}</b></small>
                    </td>
                    <td width="30%">
                        {{ $training->activity_name }}<br><br>
                        <small><b>Tipo de Actividad:</b> {{ $training->activity_type }}</b></small> <br>
                    </td>
                    <td class="text-center" width="7%">{{ $training->activity_date_start_at }}</td>
                    <td class="text-center" width="7%">{{ $training->activity_date_end_at }}</td>
                    <td width="8%" class="text-center">
                        @if($training->StatusValue == 'Guardado' || $training->StatusValue == 'Enviado')
                            @if(auth()->guard('external')->check() == true)
                                <a href="{{ route('trainings.external_edit', $training) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-edit"></i> 
                                </a>
                            @else
                                <a href="{{ route('trainings.edit', $training) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-edit"></i> 
                                </a>
                            @endif
                        @else
                            <a href="{{-- route('trainings.external_edit', $training) --}}"
                                class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        @endif
                        {{--
                        <a class="btn btn-outline-danger btn-sm"
                            wire:click="deleteMeeting({{ $key }})">
                            <i class="fas fa-trash-alt fa-fw"></i>
                        </a>
                        --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
