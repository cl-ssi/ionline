<div>
    @include('prof_agenda.partials.nav')

    <h4>Reporte ficha paciente</h4>

    <div class="row">
        <fieldset class="form-group col col-md-6">
            <label for="for_id_deis">Paciente</label>
            @livewire('search-select-user', [
                'selected_id' => 'patient_id',
                'emit_name' => 'get_user',
                'user' => $patient
            ])
        </fieldset>

        <fieldset class="form-group col col-md-2">
            <label for="for_id_deis"><br></label>
            <button type="button" class="btn btn-primary form-control" wire:click="search()">Buscar</button>
        </fieldset>
    </div>

    <hr>

    <div class="container">
        <div class="row">
            <div class="col-sm">
                Últimas 10 reservas
                <hr>
                <table class="table table-striped">
                    <tbody>
                        @foreach($passedOpenHours as $openHour)
                            @if($openHour->assistance === 0) <tr class="table-danger">
                            @else <tr> @endif

                                <td>{{$openHour->start_date->format('Y-m-d H:i')}}</td>
                                <td>
                                    @if(array_key_exists($openHour->id, $openHours) && $openHours[$openHour->id]['showSelect'])
                                        <select wire:change="updateAssistance({{$openHour->id}}, $event.target.value)" wire:model.live="openHours.{{$openHour->id}}.selectedAssistance">
                                            <option value=""></option>
                                            <option value="0">No asistió</option>
                                            <option value="1">Asistió</option>
                                            <option value="2">Sin especificar</option>
                                        </select>
                                    @else
                                        <a href="#" wire:click="showSelect({{$openHour->id}})">
                                            @if($openHour->assistance === 0)
                                                No asistió
                                            @elseif($openHour->assistance === 1)
                                                Asistió
                                            @else
                                                Sin especificar
                                            @endif
                                        </a>
                                    @endif
                                </td>
                                <td>{{$openHour->profesional->shortName}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-sm">
                Próximas reservas
                <hr>
                <table class="table table-striped">
                    <tbody>
                        @foreach($nextOpenHours as $openHour)
                            <tr>
                                <td>{{$openHour->start_date->format('Y-m-d H:i')}}</td>
                                <td>{{$openHour->profesional->shortName}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- <div class="col-sm">
            One of three columns
            </div> -->
        </div>
    </div>
    
</div>
