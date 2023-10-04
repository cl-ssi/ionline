<div>
@include('welfare.nav')

    <h4>{{ $startDate->format('Y-m-d') }} - {{ $endDate->format('Y-m-d') }}</h4>


    - Input selector de fecha inicio y fin <br>
    - Boton para ver archivo de salida "run | monto" del rango seleccionado

    <table class="table table-sm table-bordered">
        <thead>
            <tr class="text-center">
                <th></th>
                <th></th>
                <th colspan="3">Enero</th>
                <th colspan="3">Febrero</th>
                <th></th>
                <th></th>

            </tr>
            <tr class="text-center">
                <th>Run</th>
                <th>Nombre</th>
                <th>Cargado en AMIPASS</th>
                <th>Calculo Sistema</th>
                <th>Diferencia</th>
                <th>Cargado en AMIPASS</th>
                <th>Calculo Sistema</th>
                <th>Diferencia</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-center">
                <td>152342342-4</td>
                <td>Alvaro Torres F</td>
                <td>
                    $ 108.000
                </td>
                <td>
                    <a href="#">
                    $ 95.000
                    </a>
                    
                </td>
                <td class="text-danger">
                    $ -13.000
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>


    <hr>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Ct</th>
                <th>Datos Peronales</th>
                <th>Contratos</th>
                <th>Ausentismos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userWithContracts as $ct => $user)
            <tr>
                <td>
                    {{ ++$ct }}
                </td>
                <td>
                    {{ $user->id }} <br>
                    {{ $user->shortName }}
                </td>
                <td>
                    <ul>
                    @foreach($user->contracts as $contract)
                        <li>
                        {{ $contract->id }} - 
                        {{ optional($contract->fecha_inicio_contrato)->format('Y-m-d') }} - 
                        {{ optional($contract->fecha_termino_contrato)->format('Y-m-d') }}<br>
                        Horas: {{ $contract->numero_horas }} - 
                        Días Hábiles {{ $contract->businessDays }} <br>
                        Monto a cargar $ {{ money($contract->ammount) }}
                        </li>
                    @endforeach
                    </ul>
                </td>
                <td class="small">
                    <ul>
                        @foreach($user->absenteeisms as $absenteeism)
                        <li> 
                            @if($absenteeism->totalDays==0)
                                {{ $absenteeism->finicio->format('Y-m-d') }} - {{ $absenteeism->ftermino->format('Y-m-d') }} 
                                <small>({{ $absenteeism->tipo_de_ausentismo }})</small> 
                                Dias: {{ $absenteeism->total_dias_ausentismo }} => {{ $absenteeism->totalDays}}repor
                            @else 
                                <p style="color:red;display: inline;">
                                    {{ $absenteeism->finicio->format('Y-m-d') }} - {{ $absenteeism->ftermino->format('Y-m-d') }} 
                                    <small>({{ $absenteeism->tipo_de_ausentismo }})</small> 
                                    Dias: {{ $absenteeism->total_dias_ausentismo }} => {{ $absenteeism->totalDays}}
                                </p>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    Total días: {{ $user->totalAbsenteeismsEnBd }} =>  {{ $user->totalAbsenteeisms }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
