<div>
    @include('prof_agenda.partials.nav')

    <h4>Reporte SIRSAP</h4>

    <form class="row g-3">
        <div class="col-md-3">
            <label for="inputEmail4" class="form-label">Inicio</label>
            <input type="date" class="form-control" wire:model="finicio" required>
            @error('finicio') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-3">
            <label for="inputPassword4" class="form-label">Término</label>
            <input type="date" class="form-control" wire:model="ftermino" required>
            @error('ftermino') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="col-3">
            <label for="inputPassword4" class="form-label"><br></label>
            <div wire:loading.remove>
                <button wire:click="search" type="button" class="form-control btn btn-primary">Generar</button>
            </div>
            <div wire:loading.delay class="z-50 static flex fixed left-0 top-0 bottom-0 w-full bg-gray-400 bg-opacity-50">
                <img src="https://paladins-draft.com/img/circle_loading.gif" width="64" height="64" class="m-auto mt-1/4">
            </div>
        </div>
    </form>

    @if($finicio!=null && $ftermino!=null)
        @if($data)
        <table class="table table-striped">
            <thead>
                <!-- <tr>
                    <th scope="col" colspan="12" style="text-align: center;"></th>
                    <th scope="col">(+ de 2)</th>
                </tr> -->
                <tr>
                    <th scope="col">Especialidad</th>
                    <th scope="col">T.Actividad</th>
                    <th scope="col">Total Programadas</th>
                    <th scope="col" colspan="2" style="text-align: center;">Agendadas</th>
                    <th scope="col">No agendadas</th>
                    <th scope="col" colspan="2" style="text-align: center;">Asiste</th>
                    <th scope="col" colspan="2" style="text-align: center;">No asiste</th>
                    <th scope="col" colspan="2" style="text-align: center;">Cantidad</th>
                    <th scope="col" colspan="2" style="text-align: center;">Cantidad (>=2)</th>
                </tr>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">Hombres</th>
                    <th scope="col">Mujeres</th>
                    <th scope="col"></th>
                    <th scope="col">Hombres</th>
                    <th scope="col">Mujeres</th>
                    <th scope="col">Hombres</th>
                    <th scope="col">Mujeres</th>
                    <th scope="col">Hombres</th>
                    <th scope="col">Mujeres</th>
                    <th scope="col">Hombres</th>
                    <th scope="col">Mujeres</th>
                </tr>
            </thead>
        <tbody>
            @foreach($data as $profession_name => $item)
            <tr>
                <td colspan="14"><b>{{$profession_name}}</b></td>
            </tr>
                @foreach($item as $activity_type => $item2)
                    <tr>
                        <td></td>
                        <td><b>{{$activity_type}}</b></td>
                        <td style="text-align: center;"><b>{{$item2['Total']}}</b></td>
                        <td style="text-align: center;">@if(array_key_exists('Agendadas', $item2) && array_key_exists('male', $item2['Agendadas'])) {{$item2['Agendadas']['male']}} @endif</td>
                        <td style="text-align: center;">@if(array_key_exists('Agendadas', $item2) && array_key_exists('female', $item2['Agendadas'])) {{$item2['Agendadas']['female']}} @endif</td>
                        <td style="text-align: center;">@if(array_key_exists('No_agendadas', $item2) && array_key_exists('No_agendadas', $item2)) {{$item2['No_agendadas']}} @endif</td>
                        <td style="text-align: center;">@if(array_key_exists('Asiste', $item2) && array_key_exists('male', $item2['Asiste'])) {{$item2['Asiste']['male']}} @endif</td>
                        <td style="text-align: center;">@if(array_key_exists('Asiste', $item2) && array_key_exists('female', $item2['Asiste'])) {{$item2['Asiste']['female']}} @endif</td>
                        <td style="text-align: center;">@if(array_key_exists('No_asiste', $item2) && array_key_exists('male', $item2['No_asiste'])) {{$item2['No_asiste']['male']}} @endif</td>
                        <td style="text-align: center;">@if(array_key_exists('No_asiste', $item2) && array_key_exists('female', $item2['No_asiste'])) {{$item2['No_asiste']['female']}} @endif</td>

                        <td style="text-align: center;">@if(array_key_exists('Asiste_cantidad', $item2) && array_key_exists('male', $item2['Asiste_cantidad'])) {{count($item2['Asiste_cantidad']['male'])}} @endif</td>
                        <td style="text-align: center;">@if(array_key_exists('Asiste_cantidad', $item2) && array_key_exists('female', $item2['Asiste_cantidad'])) {{count($item2['Asiste_cantidad']['female'])}} @endif</td>

                        <td style="text-align: center;">@if(array_key_exists('Asiste_cantidad', $item2) && array_key_exists('male', $item2['Asiste_cantidad'])) {{ count(array_filter($item2['Asiste_cantidad']['male'], function($value) { return $value > 1; })) ?? 0 }} @else 0 @endif</td>
                        <td style="text-align: center;">@if(array_key_exists('Asiste_cantidad', $item2) && array_key_exists('female', $item2['Asiste_cantidad'])) {{ count(array_filter($item2['Asiste_cantidad']['female'], function($value) { return $value > 1; })) ?? 0 }} @else 0 @endif</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
        </table>
        @endif
    @endif
</div>
