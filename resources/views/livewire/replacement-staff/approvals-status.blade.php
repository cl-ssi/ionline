<div>
    <div class="card card-body small">
        <h5 class="mb-3"> Buscar:</h5>

        <div class="form-row">
            <fieldset class="form-group col-12 col-md-6">
                <label for="for_sub_search">Buscar por:</label>
                <select name="sub_search" class="form-control" wire:model.live.debounce.500ms="selectedSearch">
                    <option value="">Seleccione...</option>
                    <option value="ou">Unidad Organizacional</option>
                    <option value="sub">Subdirección</option>
                </select>
            </fieldset>

            @if($selectedSearch == 'ou')
                <fieldset class="form-group col">
                    <label for="for_requester_ou_id">Unidad Organizacional</label>
                    @livewire('search-select-organizational-unit', [
                        'emit_name'            => 'searchedOu',
                        'selected_id'          => 'requester_ou_id',
                    ])
                </fieldset>

            @elseif($selectedSearch == 'sub')
                <fieldset class="form-group col">
                    <label for="for_sub_search">Subdirección</label>
                    <select name="sub_search" class="form-control" wire:model.live.debounce.500ms="selectedOuId">
                        <option value="">Seleccione...</option>
                        @foreach($subs as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->name }} - {{ $sub->establishment->name }}</option>
                        @endforeach
                    </select>
                </fieldset>
            @else
                <fieldset class="form-group col">
                    <div class="alert alert-info" role="alert">
                        Para consulta el reporte, debes seleccionar una opción en el campo "Buscar por".
                    </div>
                </fieldset>
            @endif
        </div>
        <div class="form-row">
            <div class="col">
                <button type="button" class="btn btn-primary float-right" wire:click="showReport">
                    <i class="fas fa-search"></i> Ir
                </button>
            </div>
        </div>
    </div>

    @if($messageNotify != NULL)
        <div class="alert alert-info mt-2 mb-2" role="alert">
            {!! $messageNotify !!}
        </div>
    @endif

    @if($pendings && $pendings->count() > 0)
        <div class="row mt-2 mb-2">
            <div class="col-12 col-md-8">
                <p class="font-weight-lighter">Total de Registros: <b>{{ $pendings->count() }}</b></p>
            </div>
            @if($this->pendingsCount > 20 && $selectedSearch == 'ou')
                <div class="col-12 col-md-4">                
                    <button type="button" class="btn btn-primary btn-sm float-right" wire:click="sendNotificaction"><i class="fas fa-bell"></i> Enviar Notificación</button>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col">
                <table class="table table-sm table-striped table-bordered">
                    <thead class="text-center small">
                        <tr>
                            <th style="width: 3%">#</th>
                            <th style="width: 7%">N° Solicitud de Aprobación</th>
                            <th style="width: 12%">Fechas Creación</th>
                            <th>Estado / Unidad Organizacional</th>
                            <th>N° Solicitud</th>
                            <th>Nombre solicitud</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach($pendings as $pending)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $pending->id }}</td>
                            <td class="text-center">
                                {{ $pending->created_at->format('d-m-Y H:i:s') }} <br>
                                <small><b>Días de espera: {{ (int) $pending->created_at->diffInDays(Carbon\Carbon::now()) }} </small>
                            </td>
                            <td>
                                {{ $pending->StatusInWords }} <br>
                                <small><b>{{ $pending->sentToOu->name }}</b></small>
                            </td>
                            <td class="text-center">{{ $pending->approvable_id }}</td>
                            <td class="text-center">{{ $pending->approvable->name }}</td>
                            <td class="text-center">
                                <a href="{{ route('replacement_staff.request.technical_evaluation.edit', $pending->approvable) }}"
                                    class="btn btn-outline-secondary btn-sm" title="Evaluación Técnica" target="blank_">
                                    <i class="fas fa-edit fa-fw"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        
    @endif
</div>
