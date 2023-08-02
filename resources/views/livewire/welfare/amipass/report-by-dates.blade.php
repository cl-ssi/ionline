<div>
    <ul>
        @foreach ($userWithContracts as $ct => $user)
        <li>
            {{ ++$ct }} - ID: {{ $user->id }}  Nombre:  {{ $user->shortName }}
            <ul>
                @foreach($user->absenteeisms as $absenteeism)
                    <li>
                        {{ $absenteeism->finicio->format('Y-m-d') }} - {{ $absenteeism->ftermino->format('Y-m-d') }} - {{ $absenteeism->tipo_de_ausentismo }} - Total dias {{ $absenteeism->total_dias_ausentismo }} => {{ $absenteeism->totalDays}}
                    </li>
                @endforeach
                <li>
                    Total ausentismos {{ $user->totalAbsenteeismsEnBd }} =>  {{ $user->totalAbsenteeisms }}
                </li>
            </ul>
            <ul>
            @foreach($user->contracts as $contract)
                <li>
                {{ $contract->id }} - 
                Inicio: {{ optional($contract->fecha_inicio_contrato)->format('Y-m-d') }}
                Término: {{ optional($contract->fecha_termino_contrato)->format('Y-m-d') }}
                Número Horas: {{ $contract->numero_horas }} 
                Días Hábiles trabajados {{ $contract->businessDays }} 
                Monto a cargar en el rango {{ money($contract->ammount) }}
                </li>
            @endforeach
            </ul>
        </li>
        @endforeach
    </ul>
</div>
