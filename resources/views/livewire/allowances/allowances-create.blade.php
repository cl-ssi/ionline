<div>
    <h6 class="small"><b>1. Funcionario</b></h6> <br>
    
    @if($totalCurrentAllowancesDaysByUser < 90 && $userAllowance && $form == 'create')
        <div class="alert alert-info alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
            El usuario <b>{{ $userAllowance->FullName }}</b> registra los siguiente días de viáticos: <br>
            - <b>Utilizados</b>: {{ $totalCurrentAllowancesDaysByUser }} <br>
            - <b>Disponibles</b>:  {{ 90 - $totalCurrentAllowancesDaysByUser }}
        </div>
    @endif

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-6">
            <label for="for_user_allowance_id">Nombre Funcionario:</label>
            @if($allowanceToEdit)
                @livewire('search-select-user', [
                    'selected_id'   => 'user_allowance_id',
                    'required'      => 'required',
                    'emit_name'     => 'searchedUser',
                    'user'          => $allowanceToEdit->userAllowance
                ])
            @else
                @livewire('search-select-user', [
                    'selected_id'   => 'user_allowance_id',
                    'required'      => 'required',
                    'emit_name'     => 'searchedUser'
                ])
            @endif
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_contractual_condition">Calidad</label>
            <select class="form-control" wire:model="contractualConditionId" required>
                <option value="">Seleccione...</option>
                @foreach($contractualConditions as $contractualCondition)
                    <option value="{{ $contractualCondition->id }}">{{ $contractualCondition->name }}</option>
                @endforeach
            </select>
            @error('contractualConditionId') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            @if($allowanceToEdit)
                @livewire('allowances.show-position', [
                    'position' => $allowanceToEdit->position
                ])
            @else
                @livewire('allowances.show-position')
            @endif
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-3">
            <label for="for_allowance_value_id">Grado E.U.S.</label>
            <select name="allowance_value_id" class="form-control" wire:model="allowanceValueId" required>
                <option value="">Seleccione...</option>
                @foreach($allowanceValues as $allowanceValue)
                    <option value="{{ $allowanceValue->id }}">{{ $allowanceValue->name }}</option>
                @endforeach
            </select>
            @error('allowanceValueId') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_place">Grado Específico</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="grade" required>
            @error('grade') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_law">Ley</label>
            <div class="mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="for_law" value="18834" wire:model.debounce.500ms="law" {{ $disabledLaw }}>
                    <label class="form-check-label" for="for_law">N° 18.834</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="for_law" value="19664" wire:model.debounce.500ms="law" {{ $disabledLaw }}>
                    <label class="form-check-label" for="for_law">N° 19.664</label>
                </div>
            </div>
            @error('law') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-6">
            <label for="for_reason">Motivo</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="reason" required>
            @error('reason') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <hr>

    <h6 class="small"><b>2. Origen / Destino</b></h6> <br>
    <div class="form-row">
        <fieldset class="form-group col-12 col-md-6">
            <label for="for_requester_id">Comuna Origen:</label>
                @if($allowanceToEdit)
                    @livewire('search-select-commune', [
                        'selected_id'           => 'origin_commune_id',
                        'required'              => 'required',
                        'commune'               => $allowanceToEdit->originCommune
                    ])
                @else
                    @livewire('search-select-commune', [
                        'selected_id'           => 'origin_commune_id',
                        'required'              => 'required'
                    ])
                @endif
        </fieldset>
    </div>
    
    <div class="form-row">
        <fieldset class="form-group col-12 col-md-6">
            <label for="for_requester_id">Comuna Destino:</label>
            @livewire('search-select-commune', [
                'selected_id' => 'destination_commune_id',
                'required' => 'required'
            ])
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_locality_id">Localidad</label>
            <select name="locality_id[]" class="form-control" wire:model="selectedLocality" id="for_selected_locality_{{$i}}" required>
                <option value="">Seleccione...</option>
                @if($localities)
                    @foreach($localities as $locality)
                        <option value="{{ $locality->id }}">{{ $locality->name }}</option>
                    @endforeach
                @endif
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_place">Descripción Lugar</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="description" required>
        </fieldset>

        <div class="form-group col-12 col-md-1">
            <label for="for_button"><br></label>
            <a class="btn btn-info btn-block" wire:click="addDestination"> Agregar</a>
        </div>  
    </div>

    @if(count($errors) > 0 && $validateMessage == "destination")
        <div class="alert alert-danger">
            <p>Corrige los siguientes errores:</p>
            <ul>
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($destinations)
    <br>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm small" name="items">
            <thead>
                <tr class="bg-light text-center">
                    <th>#</th>
                    <th>Comuna</th>
                    <th>Localidad</th>
                    <th>Descripción</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($destinations as $key => $destination)
                <tr>
                    <td class="brd-l text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $destination['commune_name'] }}</td>
                    <td class="text-center">{{ $destination['locality_name'] }}</td>
                    <td>{{ $destination['description'] }}</td>
                    <td width="5%" class="text-center">
                        <a class="btn btn-danger btn-sm" href="#items" class="text-danger" 
                            title="Eliminar" 
                            onclick="confirm('¿Está seguro que desea eliminar el destino?') || event.stopImmediatePropagation()"
                            wire:click="deleteDestination({{ $key }})">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <hr>

    <h6 class="small"><b>3. Información de Itinerario</b></h6> <br>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-4">
            <label for="for_round_trip">Medio de Transporte</label>
            <select wire:model="meansOfTransport" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="ambulance">Ambulancia</option>
                <option value="plane">Avión</option>
                <option value="bus">Bus</option>
                <option value="other">Otro</option>
            </select>
            @error('meansOfTransport') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_round_trip">Itinerario</label>
            <select wire:model="roundTrip" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="round trip">Ida, vuelta</option>
                <option value="one-way only">Sólo ida</option>
            </select>
            @error('roundTrip') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
        
        <fieldset class="form-group col-12 col-md-4 text-center">
            <label for="for_overnight">Derecho de Pasaje</label>
            <div class="mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="for_passage_yes" wire:model.debounce.500ms="passage" value="1" required>
                    <label class="form-check-label" for="for_passage_yes">Si</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="for_passage_no" wire:model.debounce.500ms="passage" value="0" required>
                    <label class="form-check-label" for="for_passage_no">No</label>
                </div>
            </div>
            @error('passage') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="form-row text-center">
        <fieldset class="form-group col-12 col-md-4">
            <label for="for_overnight">Pernocta fuera de residencia</label>
            <div class="mt-1 text-center">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="for_overnight_yes" wire:model.debounce.500ms="overnight" value="1" required>
                    <label class="form-check-label" for="for_overnight_no">Si</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="for_overnight_no" wire:model.debounce.500ms="overnight" value="0" required>
                    <label class="form-check-label" for="for_overnight_no">No</label>
                </div>
            </div>
            @error('overnight') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_accommodation">Alojamiento (Incluída en cometido o actividad)</label>
            <div class="mt-1 text-center">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="for_accommodation_yes" wire:model="accommodation" value="1" required>
                    <label class="form-check-label" for="for_accommodation_yes">Si</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="for_overnight_no" wire:model="accommodation" value="0" required>
                    <label class="form-check-label" for="for_accommodation_no">No</label>
                </div>
            </div>
            @error('accommodation') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-md-4">
            <label for="for_food">Alimentación (Incluída en cometido o actividad)</label>
            <div class="mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="for_food_yes" wire:model="food" value="1" required>
                    <label class="form-check-label" for="for_food_yes">Si</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="for_food_no" wire:model="food" value="0" required>
                    <label class="form-check-label" for="for_food_no">No</label>
                </div>
            </div>
            @error('food') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12 col-sm-4">
            <label for="for_start_date">Desde</label>
            <input type="date" class="form-control" wire:model.defer="from" id="for_from">
            @error('from') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-12 col-sm-4">
            <label for="for_end_date">Hasta</label>
            <input type="date" class="form-control" wire:model.defer="to" id="for_to">
            @error('to') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <div class="form-group col-12 col-md-4 text-center">
            <label for="name" class="col-form-label">Sólo medios días (Inlcusive):</label>
            <br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="1" id="for_half_days_only" wire:model.debounce.500ms="halfDaysOnly" {{ $disabledHalfDayOnly }}>
                <label class="form-check-label" for="for_yes">
                    Si
                </label>
            </div>
        </div>
    </div>

    @if(session('current'))
        <div class="alert alert-danger">
            {{ session('current') }}
        </div>
    @endif

    <hr>
    <br>
    
    @if($messageMeansOfTransport != NULL)
        <div class="alert alert-info" role="alert">
            {!! $messageMeansOfTransport !!}
        </div>
    @endif

    <h6><i class="fas fa-paperclip"></i> Archivos Adjuntos</h6>
    <br>
    
    <div class="form-row">
        <fieldset class="form-group col mt">
            <label for="for_name">Nombre Archivo</label>
            <input type="text" class="form-control" wire:model="fileName" required>
        </fieldset>
            
        <fieldset class="form-group col mt">
            <div class="mb-3">
                <label for="forFile" class="form-label"><br></label>
                <input class="form-control" type="file" wire:model.defer="file" accept="application/pdf" required>
                <div wire:loading wire:target="fileRequests">Cargando archivo(s)...</div>
            </div>
        </fieldset>

        <div class="form-group col-12 col-md-1">
            <label for="for_button"><br></label>
            <a class="btn btn-info btn-block" wire:click="addFile"> Agregar</a>
        </div> 
    </div>

    @if(count($errors) > 0 && $validateMessage == "file")
        <div class="alert alert-danger">
            <p>Corrige los siguientes errores:</p>
            <ul>
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($files)
    <br>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm small" name="items">
            <thead>
                <tr class="bg-light text-center">
                    <th>#</th>
                    <th>Nombre archivo</th>
                    <th>Archivo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($files as $key => $file)
                <tr>
                    <td class="brd-l text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $file['fileName'] }}</td>
                    <td class="text-center">
                        <a class="btn btn-secondary btn-sm" href="#items" title="Eliminar" wire:click="showFile({{$key}})"><i class="fas fa-file"></i></a>
                    </td>
                    <td width="5%" class="text-center">
                        <a class="btn btn-danger btn-sm" href="#items" title="Eliminar" wire:click="deleteItem({{-- $key --}})"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(count($errors) > 0 && $validateMessage == "allowance")
        <div class="alert alert-danger">
            <p>Corrige los siguientes errores:</p>
            <ul>
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session()->has('exceedTotalDays'))
        <div class="alert alert-danger">
            {{ session('exceedTotalDays') }}
        </div>
    @endif

    <button wire:click="saveAllowance"  class="btn btn-primary float-right" type="button" wire:loading.attr="disabled">
        <i class="fas fa-save"></i> Guardar
    </button>
    
    <br><br>

    
</div>
