<div>
@include('welfare.nav')

    <div class="form-row">
        <div class="form-group col-3">
            <label for="text11">Fecha de inicio</label>
            <input type="date" class="form-control" wire:model.defer="finicio" required>
            @error('finicio') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-3">
            <label for="text12">Fecha de término</label>
            <input type="date" class="form-control" wire:model.defer="ftermino" required>
            @error('ftermino') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="text12"><br></label>
            <div wire:loading.remove>
                <button wire:click="search" type="button" class="form-control btn btn-primary">Generar</button>
            </div>
            <div wire:loading.delay class="z-50 static flex fixed left-0 top-0 bottom-0 w-full bg-gray-400 bg-opacity-50">
                <img src="https://paladins-draft.com/img/circle_loading.gif" width="64" height="64" class="m-auto mt-1/4">
            </div>

        </div>
    </div>

    @if($finicio!=null && $ftermino!=null)

    <hr>

    <table class="table table-bordered table-sm" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>Run</th>
                <th>Nombre</th>
                <th>Cargado en AMIPASS</th>
                <th>Calculo Sistema</th>
                <th>Diferencia</th>
            </tr>
        </thead>
        <tbody>
            @if($userWithContracts)
                @foreach ($userWithContracts as $ct => $user)
                
                <tr >
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->shortName }}</td>
                    <td>{{ money($user->AmiLoadMount) }}</td>
                    <td>{{ money($user->contracts->sum('ammount')) }}</td>
                    <td>
                        @if($user->diff < 0)
                            <p style="color:red;display: inline;">
                                {{$user->diff}}
                            </p>
                        @else
                            {{$user->diff}}
                        @endif
                    </td>
                    <td>
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#demo{{$ct}}" aria-expanded="false" aria-controls="collapseExample">
                        Detalles
                    </button>
                    </td>
                </tr>
                
                <tr class="collapse" id="demo{{$ct}}">
                    <td></td>
                    <td></td>
                    <td>
                        <ul>
                            @foreach($user->amiLoads as $amiLoad)
                                <li> 
                                {{$amiLoad->fecha->format('Y-m-d')}} - {{$amiLoad->monto}} 
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

                        <hr>

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
                    <td></td>
                </tr>
                
                @endforeach
            @endif
        </tbody>
    </table>

    @endif

</div>
