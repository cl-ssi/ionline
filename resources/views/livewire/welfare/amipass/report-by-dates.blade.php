<div>
@include('welfare.nav')

    <h4>Reporte Amipass - General</h4>

    <div class="form-row">
        <div class="form-group col-3">
            <label for="text12">Periodo</label>
            <input type="month" class="form-control" wire:model="search_date" required/>
            @error('search_date') <span class="error">{{ $message }}</span> @enderror
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

    @if($search_date!=null)

    <div class="form-row">
        <div class="form-group col-10">
            
        </div>
        <div class="form-group col-2">
            <button class="btn btn-outline-success float-right" wire:click="export">
                Montos <i class="fas fa-download"></i>
            </button>
        </div>
        <!-- <div class="form-group col-2">
            <button class="btn btn-outline-info float-right" wire:click="process">
                Procesar montos <i class="fa fa-cogs"></i>
            </button>
        </div> -->
    </div>

    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <table class="table table-bordered table-sm" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>Run</th>
                <th>Nombre</th>
                <!-- <th>Cargado en AMIPASS</th> -->
                <th>Calculo Sistema</th>
                <!-- <th>Valor (S.T)</th>  debe eliminarse esta columna -->
                <!-- <th>Diferencia</th> -->
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($output as $id => $user)
                @if(!$user['shifts'])
                    <tr>
                        <td>{{ $id }}</td>
                        <td>{{ $user['shortName'] }}</td>
                        <td>{{ money($user['regularized_ammount']) }}</td>
                        <td>--</td>
                        <td>
                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#demo{{$id}}" aria-expanded="false" aria-controls="collapseExample">
                                Detalles
                            </button>
                        </td>
                    </tr>
                    <tr class="collapse" id="demo{{$id}}">
                        <td></td>
                        <td></td>
                        
                        <td>
                            <ul>
                                Detalles de cargas: <br>
                                @if($user['amiLoads'])
                                    @foreach($user['amiLoads'] as $amiLoad)
                                        <li>{{$amiLoad['fecha']}} - {{$amiLoad['monto']}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </td>
                        
                        
                        <td class="small">
                            <ul>
                                <!-- ausentismos (sin condierar dias compensatorios) -->
                                @if($user['absenteeisms'])
                                    @foreach($user['absenteeisms'] as $absenteeism)
                                    <li> 
                                        @if($absenteeism['totalDays']==0)
                                            {{ $absenteeism['finicio'] }} - {{ $absenteeism['ftermino'] }} 
                                            <small>({{ $absenteeism['tipo_de_ausentismo'] }})</small> 
                                            Dias: {{ $absenteeism['total_dias_ausentismo'] }} => {{ $absenteeism['totalDays']}}
                                        @else 
                                            <p style="color:red;display: inline;">
                                                {{ $absenteeism['finicio'] }} - {{ $absenteeism['ftermino'] }} 
                                                <small>({{ $absenteeism['tipo_de_ausentismo'] }})</small> 
                                                Dias: {{ $absenteeism['total_dias_ausentismo'] }} => {{ $absenteeism['totalDays']}}
                                            </p>
                                        @endif
                                    </li>
                                    @endforeach
                                @endif

                                
                                <!-- solo dias compensatorios -->
                                @if($user['compensatoryDays'])
                                    @foreach($user['compensatoryDays'] as $compensatoryDay)
                                    <li> 
                                        @if($compensatoryDay['totalDays'] == 0)
                                            {{ $compensatoryDay['start_date'] }} - {{ $compensatoryDay['end_date']}} => {{$compensatoryDay['diffInHours']}} Hrs. 
                                            <small>(DÍA COMPENSATORIO)</small> 
                                            Dias: {{ $compensatoryDay['total_dias_ausentismo'] }} => {{ $compensatoryDay['totalDays']}}
                                        @else 
                                            <p style="color:red;display: inline;">
                                                {{ $compensatoryDay['start_date'] }} - {{ $compensatoryDay['end_date'] }} => {{$compensatoryDay['diffInHours']}} Hrs. 
                                                <small>(DÍA COMPENSATORIO)</small> 
                                                Dias: {{ $compensatoryDay['total_dias_ausentismo'] }} => {{ $compensatoryDay['totalDays']}}
                                            </p>
                                        @endif
                                    </li>
                                    @endforeach
                                @endif

                                
                                <br>
                                <li>Días hábiles en búsqueda: {{$user['businessDays']}}</li>
                                <li>Días descuento: {{ $user['totalAbsenteeismsEnBd'] }} => {{ $user['totalAbsenteeisms'] }}</li>
                                <li>Días a pagar: {{$user['businessDays'] - $user['totalAbsenteeisms']}}</li>
                                <li>Valor día: {{$user['dailyAmmount']}}</li>
                                <li>Valor calculado del mes: {{ money($user['ammount']) }}</li>
                                @if(array_key_exists('pendingAmount', $user))
                                    <li>Débito acumulado: {{$user['pendingAmount']}}</li>
                                @endif

                            </ul>

                            <hr>

                            <ul>
                                <li>
                                H.Totales contratos: {{$user['contract_hours']}} 
                                @if($user['contract_hours'] <= 33)
                                    <p style="color:red;display: inline;">(Menor a 33 hrs - No se paga amipass)</p>
                                @endif
                                </li>
                            </ul>
                        </td>
                        
                        <td><small>D.Ausentismo: {{$user['dias_ausentismo']}}</small></td>
                    </tr>
                @else
                    <tr class="table-info">
                        <td>{{ $id }}</td>
                        <td>{{ $user['shortName'] }}</td>
                        <td>FALTA INCORPORAR!</td>
                        <td>Turno</td>
                        <td>
                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#demo{{$id}}" aria-expanded="false" aria-controls="collapseExample">
                                Detalles
                            </button>
                        </td>
                    </tr>

                    <tr class="collapse" id="demo{{$id}}">
                        <td></td>
                        <td></td>
                        <td>

                        </td>
                        <td class="small">
                            @foreach($user['shifts'] as $shift)
                                <li>
                                {{ $shift->year }} - {{ $shift->monthName() }}: {{ $shift->quantity }} días * {{ money($user->shiftAmmount) }}
                                </li>
                            @endforeach
                        </td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    @endif

</div>
