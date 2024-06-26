<div>
    @if($showStep1)
        <div class="text-center"> <!-- Agrega una clase para centrar el contenido -->
            <h3>¿Qué especialidad necesitas agendar?</h3>
        </div><br>

        <div class="row">
            @foreach($professions as $profession)
                <div class="col-md-4 mb-4">
                    <div class="card border-success mb-3">
                        <div class="card-body btn-like-div" wire:click="showStep2({{ $profession->id }})">
                            <h5 class="card-title">{{ $profession->name }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($showStep2)
        <div class="text-center"> <!-- Agrega una clase para centrar el contenido -->
            <h3>¿Que tipo de atención necesitas?</h3>
        </div><br>

        @if($profession->professionMessages->first())
            <div class="alert alert-warning" role="alert">
                Información! {{$profession->professionMessages->first()->text}}
            </div>
        @endif

        <div class="row">
            @if(count($activityTypes)>0)
                @foreach($activityTypes as $activityType)
                    <!-- no se porque se cambia a array, por eso el if (debo revisar) -->
                    @if(!is_array($activityType))
                        <div class="col-md-4 mb-4">
                            <div class="card border-success mb-3">
                                <div class="card-body btn-like-div" wire:click="showStep3({{ $activityType->id }})">
                                    <h5 class="card-title">{{ $activityType->name }}</h5>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-4 mb-4">
                            <div class="card border-success mb-3">
                                <div class="card-body btn-like-div" wire:click="showStep3({{ $activityType['id'] }})">
                                    <h5 class="card-title">{{ $activityType['name'] }}</h5>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="col-md-12 mb-12 alert alert-warning" role="alert">
                    No existen atenciones reservables en este momento.
                </div>
            @endif
        </div>

        <div class="btn-like-div" wire:click="goStep1">
            <button class="btn btn-secondary">Volver atrás</button>
        </div>
    @endif

    @if($showStep3)
        <div class="text-center"> <!-- Agrega una clase para centrar el contenido -->
            <h3>Seleccione la hora</h3>
            <h5>{{$activityType->name}}</h5>

            @if($activityType->description)
                <div class="alert alert-info" role="alert">
                    {{$activityType->description}}
                </div>
            @endif
            
        </div><br>

        <div class="text-center">
            @if (session()->has('message'))
                <div class="alert alert-warning">
                    {{ session('message') }}
                </div>
            @endif
        </div>

        <div class="row">
            @if(count($users_with_openhours)>0)
                @foreach($users_with_openhours as $user)
                <div class="col-md-4 mb-4" id="{{$user->id}}">
                    <div class="card border-success mb-3" style="max-width: 18rem;">
                        <div class="card-header" style="cursor: pointer;" data-toggle="collapse" data-target="#collapse{{ $user->id }}">
                            {{ $user->shortName }} <i class="fas fa-caret-down"></i>
                        </div>
                        <div id="collapse{{ $user->id }}" class="collapse">
                            <div class="card-body text-success">
                                <h5 class="card-title">Disponibles</h5>
                                <p class="card-text">
                                    <div wire:loading>
                                        Procesando...
                                    </div>
                                    @foreach($openHours as $openHour)
                                        @if($openHour->profesional_id == $user->id)
                                            <div wire:loading.remove>
                                                <button type="button" class="btn btn-outline-success mb-2" wire:click="saveReservation({{$openHour->id}})">
                                                    {{$openHour->start_date->format('Y-m-d H:i')}}
                                                </button>
                                            </div>
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
            @else
                <div class="col-md-12 mb-12 alert alert-warning" role="alert">
                    No existen horas disponibles.
                </div>
            @endif
        </div>

        <div class="btn-like-div" wire:click="goStep2">
            <button class="btn btn-secondary">Volver atrás</button>
        </div>
    @endif

    @if($showStep4)
        <div class="text-center">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>

        <button class="btn btn-secondary" wire:click="goStep1">Salir</button>

    @endif

    <style>
        .btn-like-div {
            cursor: pointer;
            /* Otros estilos que desees para que se vea como un botón */
        }
    </style>
</div>