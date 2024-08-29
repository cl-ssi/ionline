<div>
    @if($identifyNeedToEdit && $identifyNeedToEdit->learningGoals->count() > 0)
        <div class="form-row ms-2">
            <div class="col">
                <h6><i class="fas fa-list-ol"></i> Listado de Obejtivos de Aprendizaje</h6> 
            </div>
        </div>
        <div class="table-responsive ms-2">
            <table class="table table-sm table-striped table-bordered small">
                <thead>
                    <tr class="text-center table-info">
                        <th width="7%">#</th>
                        <th>Descripción</th>
                        <th width="14%" colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($learningGoals as $learningGoal)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td class="text-start">
                            @if($editLearningGoalIdRender != $learningGoal->id)
                                {{ $learningGoal->description }}
                            @else
                            <div class="row">
                                <!-- <div class="col"> -->
                                <fieldset class="form-group col-md-8">
                                    <input type="text" class="form-control form-control-sm" name="description" id="for_description" wire:model.live="description" required>
                                </fieldset>
                                <fieldset class="form-group col-md-2">
                                    <a class="btn btn-primary btn-sm" wire:click="saveEditRole({{ $learningGoal }})"><i class="fas fa-save"></i></a>
                                </fieldset>
                                <fieldset class="form-group col-md-2">
                                    <a class="btn btn-danger btn-sm" wire:click="cancelEdit()">Cancelar</a>
                                </fieldset>
                                <!-- </div> -->
                            </div>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-secondary btn-sm"
                                wire:click="editRole({{ $learningGoal }})">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-danger btn-sm"
                                wire:click="deleteRole({{ $learningGoal }})"
                                onclick="return confirm('¿Está seguro que desea eliminar la función?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @foreach($inputs as $key => $value)
        <div class="row mt-3">
            <div class="col-md-10 col-12">
                <input type="text" class="form-control" wire:model.live.debounce.700ms="learningGoalsDescriptions.{{ $key }}" id="for_description" wire:key="value-{{ $value }}" placeholder="" required>
            </div>
            <div class="col-md-2 col-12">
                <button class="btn btn-danger" wire:click.prevent="remove({{$key}})">Eliminar</button>
            </div>
        </div>
    @endforeach

    <div class="form-row mt-3">
        <div class="col-12">
            <button 
                class="btn btn-sm text-white btn-primary float-end" 
                wire:click.prevent="add({{$i}})">
                <i class="fas fa-plus"></i> Agregar
            </button>

            <button 
                class="btn btn-sm text-white btn-primary float-end me-2" 
                wire:click.prevent="save()">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </div>
</div>
