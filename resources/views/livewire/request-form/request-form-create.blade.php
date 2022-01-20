<div>
    <div class="card">
        <div class="card-header">
            </i> Formulario de Requerimiento</h6>
        </div>
        <div class="card-body">
            <div class="form-row">
                <fieldset class="form-group col-sm-4">
                    <label for="forRut">Nombre:</label>
                    <input wire:model.defer="name" name="name" class="form-control form-control-sm" type="text" value="">
                    {{-- @error('name') <span class="error">{{ $message }}</span> @enderror --}}
                </fieldset>

                <fieldset class="form-group col-sm-3">
                    <label>Administrador de Contrato:</label><br>
                    <select wire:model.defer="contractManagerId" name="contractManagerId" class="form-control form-control-sm" required>
                      <option>Seleccione...</option>
                      @foreach($users as $user)
                          <option value="{{ $user->id }}">{{ ucfirst(trans($user->FullName)) }}</option>
                      @endforeach
                    </select>
                </fieldset>

                <fieldset class="form-group col-sm-2">
                    <label>Tipo:</label><br>
                    <select wire:model.defer="subtype" name="subtype" class="form-control form-control-sm" required>
                        <option>Seleccione...</option>
                        <option value="compra inmediata">Compra inmediata</option>
                        <option value="suministros">Suministros</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-sm-3">
                    <label for="for_calidad_juridica">Autoriza Jefatura Superior</label>
                    <div class="mt-1 ml-4">
                        <input class="form-check-input" type="checkbox" value="1" wire:model="superiorChief" name="superiorChief">
                        <label class="form-check-label" for="flexCheckDefault">
                          Sí
                        </label>
                    </div>
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-sm-2">
                    <label>Mecanismo de Compra:</label><br>
                    <select wire:model="purchaseMechanism" name="purchaseMechanism" class="form-control form-control-sm" required>
                      <option>Seleccione...</option>
                      @foreach($lstPurchaseMechanism as $val)
                          <option value="{{$val->id}}">{{$val->name}}</option>
                      @endforeach
                    </select>
                </fieldset>

                <fieldset class="form-group col-sm-2">
                    <label for="for_type_of_currency">Tipo de Moneda:</label>
                    <select wire:model.defer="typeOfCurrency" name="typeOfCurrency" class="form-control form-control-sm" required>
                        <option value="">Seleccione...</option>
                        <option value="peso">Peso</option>
                        <option value="dolar">Dolar</option>
                        <option value="uf">U.F.</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col-sm-4">
                    <label for="forRut">Programa Asociado:</label>
                    <input wire:model.defer="program" name="program" class="form-control form-control-sm" type="text" value="">
                    {{-- @error('program') <span class="error">{{ $message }}</span> @enderror --}}
                </fieldset>

                <fieldset class="form-group col-sm-4">
                    <label for="for_fileRequests" class="form-label">Documento de Respaldo:</label>
                    <input class="form-control form-control-sm" wire:model.defer="fileRequests" type="file" style="padding:2px 0px 0px 2px;" name="fileRequests[]" multiple>
                </fieldset>
            </div>
            <div class="form-row">
                <fieldset class="form-group col-sm">
                    <label for="exampleFormControlTextarea1" class="form-label">Justificación de Adquisición:</label>
                    <textarea wire:model.defer="justify" name="justify" class="form-control form-control-sm" rows="3"></textarea>
                </fieldset>
            </div>
            <div class="form-row">
                <fieldset class="form-group col-sm">
                  @if (count($messagePM) > 0)
                      <label>Documentos que debe adjuntar:</label>
                      <div class="alert alert-warning mx-0 my-0 pt-2 pb-0 px-0" role="alert">
                        <ul>
                          @foreach ($messagePM as $val)
                            <li>{{ $val }}</li>
                          @endforeach
                        </ul>
                      </div>
                  @endif
                </fieldset>
            </div>
            @if($savedFiles && !$savedFiles->isEmpty())
            <div class="form-row">
                <fieldset class="form-group col-sm">
                      <label>Documentos adjuntados:</label>
                      
                        <ul class="list-group">
                          @foreach ($savedFiles as $file)
                            <li class="list-group-item py-2">
                                {{ $file->name }}
                                <a onclick="return confirm('¿Está seguro de eliminar archivo con nombre {{$file->name}}?') || event.stopImmediatePropagation()" wire:click="destroyFile({{$file->id}})"
                                    class="btn btn-link btn-sm float-right" title="Eliminar"><i class="far fa-trash-alt" style="color:red"></i></a>
                                <a href="{{ route('request_forms.show_file', $file->id) }}"
                                    class="btn btn-link btn-sm float-right" title="Ver"><i class="far fa-eye"></i></a> 
                            </li>
                          @endforeach
                        </ul>
                      
                </fieldset>
            </div>
            @endif
        </div>
    </div>

    <br>
    @if($isRFItems)
        @livewire('request-form.item.request-form-items', ['savedItems' => $requestForm->itemRequestForms ?? null])
    @else
        @livewire('request-form.passenger.passenger-request', ['savedPassengers' => $requestForm->passengers ?? null])
    @endif

    <div class="row justify-content-md-end mt-0">
        <!-- <div class="col-2">
            <button wire:click="btnCancelRequestForm"  class="btn btn-secondary btn-sm float-right">Cancelar</button>
        </div> -->
        <div class="col-2">
            <button wire:click="saveRequestForm"  class="btn btn-primary btn-sm float-right " type="button">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </div>

    @if (count($errors) > 0 and ($errors->has('purchaseMechanism') or $errors->has('program') or $errors->has('justify') or $errors->has('items')))
      <div class="row justify-content-around mt-0">
         <div class="alert alert-danger col-6 mt-1">
          <p>Corrige los siguientes errores:</p>
             <ul>
                 @foreach ($errors->all() as $message)
                     <li>{{ $message }}</li>
                 @endforeach
             </ul>
         </div>
      </div>
    @endif
</div>
