<div>
    <h6 class="small mb-4"><b>1. Descripción</b></h6>
    
    <div class="row g-3 mb-3">
        <fieldset class="form-group col-4">
            <label for="for_user_responsible_id">Funcionario Responsable</label>
            @livewire('search-select-user', [
                'selected_id'   => 'user_responsible_id',
                'required'      => 'required',
                'emit_name'     => 'searchedUser',
                'user'          => $purchasePlanToEdit->userResponsible ?? null,
                'disabled'      => $disabled
            ])
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_telephone">Teléfono</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="telephone" {{$disabled}}>
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_email">Correo Electrónico</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="email" {{$disabled}}>
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_position">Cargo / Función</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="position" {{$disabled}}>
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-4">
            <label for="for_user_allowance_id">Unidad Organizacional</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="organizationalUnit" {{ $readonly }} {{$disabled}} >
        </fieldset>

        <fieldset class="form-group col-sm-2">
            <label for="year">Año</label>
            <select class="form-select" id="for_year" name="year" wire:model.live="period">
                <option value="">Selección...</option>
                <option value="2025">2025</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
            </select>
            @error('selectedYear') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_program">Programa</label>
            @livewire('search-select-program',[
                'emit_name' => 'searchedProgram',
                    'program'   => $purchasePlanToEdit->programName ?? null,
                    'disabled'  => $disabled,
                    'year'      => $period ?? null
            ])
            @error('selectedProgram') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-6">
            <label for="for_user_allowance_id">Asunto</label>
            <input class="form-control" type="text" autocomplete="off" wire:model="subject" {{$disabled}}>
        </fieldset>
    </div>

    <div class="row g-3">
        <div class="form-group col-6">
            <label for="for_description">Descripción general del proyecto o adquisición</label>
            <textarea class="form-control" rows="3" autocomplete="off" wire:model="description" {{$disabled}}></textarea>
        </div>
        <div class="form-group col-6">
            <label for="for_purpose">Propósito general del proyecto o adquisición</label>
            <textarea class="form-control" rows="3" autocomplete="off" wire:model="purpose" {{$disabled}}></textarea>
        </div>
    </div>
    
    <br>
    <hr>

    <h6 class="small"><b>2. Ítems a comprar</b></h6> <br>
    
    @livewire('request-form.item.request-form-items', [
            'savedItems'            => $purchasePlanToEdit->purchasePlanItems ?? null,
            'savedTypeOfCurrency'   => null,
            'bootstrap'             => 'v5',
            'form'                  => 'purchase_plan'       
    ])
    <br>

    @if(count($errors) > 0 && $validateMessage == "description")
        <div class="alert alert-danger">
            <p>Corrige los siguientes errores:</p>
            <ul>
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row mt-3"> 
        <div class="col-12 col-md-2">
            <h6><i class="fas fa-paperclip mt-2"></i> Adjuntos</h6>
        </div>
    </div>
    
    <form wire:submit="addFile">
        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <fieldset class="form-group">
                    <label for="for_file_name">Nombre Archivo</label>
                    <input class="form-control" 
                        type="text" 
                        autocomplete="off" 
                        id="for_file_name"
                        wire:model="fileName" 
                        {{ $disabled }}>
                </fieldset>
            </div>
            
            <div class="col-md-5">
                <fieldset class="form-group mt-4">
                    <input class="form-control" 
                        type="file" 
                        wire:model="fileAttached" 
                        id="for_file_attached">
                    <div wire:loading wire:target="fileAttached">Cargando archivo...</div>
                </fieldset>
            </div>

            <div class="form-group col-12 col-md-1">
                <label for="for_button"><br></label>
                <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">Agregar</button>
            </div>
        </div>
    </form>
    
    @if(count($errors) > 0 && $validateMessage == "file")
        <div class="alert alert-danger mt-3">
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
        @if($deleteFileMessage)
            <div class="alert alert-danger" role="alert">
                {{ $deleteFileMessage }}
            </div>
        @endif

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
                            @if($file['id'] != '')
                                <a class="btn btn-secondary btn-sm" 
                                    title="Abrir" 
                                    wire:click="showFile({{ $key }})" 
                                    target="_blank">
                                    <i class="fas fa-file"></i>
                                </a>
                            @else
                                <a class="btn btn-secondary btn-sm disabled">
                                    <i class="fas fa-file"></i>
                                </a>
                            @endif
                        </td>
                        <td width="5%" class="text-center">
                            <a class="btn btn-danger btn-sm" 
                                id="upload{{ $iterationFileClean }}" 
                                title="Eliminar" 
                                wire:click="deleteFile({{ $key }})">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="row g-3 mt-3">
        <div class="col-12">
            <button wire:click="savePurchasePlan('save')" class="btn btn-primary float-end" type="button">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </div>
    
    @if($purchasePlanToEdit && $purchasePlanToEdit->trashedApprovals)
        <div class="row mt-3"> 
            <div class="col">
                <h6><i class="fas fa-info-circle"></i> Historial de Ciclos de Aprobaciones</h6>
            </div>
        </div>

        <div class="accordion mb-5" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <h6><i class="fas fa-info-circle"></i> Ciclos</h6>
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <table class="table table-bordered table-sm small">
                            <thead>
                                <tr class="text-center">
                                    <th width="" class="table-secondary">Fecha Creación</th>
                                    <th width="" class="table-secondary">Unidad Organizacional</th>
                                    <th width="" class="table-secondary">Usuario</th>
                                    <th width="" class="table-secondary">Fecha Aprobación</th>
                                    <th width="" class="table-secondary">Estado</th>
                                    <th width="" class="table-secondary">Fecha Eliminación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchasePlanToEdit->trashedApprovals as $approval)
                                    <tr class="text-center table-{{ $approval->getColorAttribute() }} {{ ($approval->deleted_at != NULL) ? 'table-danger' : '' }}">
                                        <td width="9%">{{ ($approval->created_at) ?  $approval->created_at->format('d-m-Y H:i:s') : '' }}</td>
                                        <td>{{ $approval->sentToOu->name }}</td>
                                        <td>{{ ($approval->approver) ? $approval->approver->name : '' }}</td>
                                        <td width="9%">{{ ($approval->approver_at) ?  $approval->approver_at->format('d-m-Y H:i:s') : '' }}</td>
                                        <td>{{ $approval->StatusInWords }}</td>
                                        <td width="9%">{{ ($approval->deleted_at) ?  $approval->deleted_at->format('d-m-Y H:i:s') : '' }}</td>     
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
