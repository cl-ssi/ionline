<div>
    @include('welfare.nav')

    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    @if($showCreate)

        <h4>Nueva solicitud</h4>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="benefit_id">Beneficio:</label>
                    <select wire:model="benefit_id" class="form-control" id="benefit_id">
                        <option value="">Selecciona un beneficio</option>
                        @foreach($benefits as $benefit)
                            <option value="{{ $benefit->id }}">{{ $benefit->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="subsidy_id">Subsidio:</label>
                    <select wire:model="subsidy_id" class="form-control" id="subsidy_id">
                        <option value="">Selecciona un subsidio</option>
                        @foreach($subsidies as $subsidy_item)
                            <option value="{{ $subsidy_item->id }}">{{ $subsidy_item->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            @if($subsidy_id)
            <div class="col-md-12">
                <!-- Inputs bloqueados para mostrar los campos de Subsidy -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Descripción:</label>
                            <input type="text" class="form-control" id="description" wire:model="subsidy.description" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Tope anual:</label>
                            <input type="text" class="form-control" id="annual_cap" wire:model="subsidy.annual_cap" disabled>
                        </div>
                    </div>
                </div>

                @if($subsidy && $subsidy->percentage)
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="percentage">Porcentaje:</label>
                            <textarea name="" id="" cols="30" rows="5" class="form-control" id="percentage" 
                            wire:model="subsidy.percentage" 
                            disabled></textarea>
                        </div>
                    </div>
                </div>
                @endif

                <br>

                <hr>

                <h4>Requisitos / Documentación</h4>

                <ul>
                    @foreach($subsidy->documents as $key => $document)
                        @if($document->type == "Documentación")
                            <li>
                                <div wire:loading wire:target="files.{{ $key }}"><i class="fas fa-spinner fa-spin"></i> <b>Cargando...</b></div> {{$document->name}}
                                <input class="form-control" type="file" wire:model="files.{{ $key }}">
                            </li>
                        @endif
                    @endforeach
                </ul>

                <div wire:loading wire:target="saveRequest">
                    <i class="fas fa-spinner fa-spin"></i> Guardando...
                </div>

                <button wire:click="saveRequest" class="btn btn-success">Guardar</button>
            </div>
            @endif
        </div>

        <br>
        <hr>
    @endif

    @if($showUpdateBankAccounts)

    <h4>Información Bancaria/de Contacto</h4>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-5">
            <label>Banco</label>        
            <select wire:model.lazy="bank_id" class="form-control" required>
            <option value="">Seleccionar Banco</option>
            @foreach($banks as $bank)
            <option value="{{$bank->id}}">{{$bank->name}}</option>
            @endforeach
            </select>
            @error('bank_id') <span class="text-danger">{{ $message }}</span> @enderror
        </fieldset>
        

        <fieldset class="form-group col-12 col-md-3">
            <label>Número de Cuenta</label>
            <input type="number" wire:model.lazy="account_number" class="form-control" required>
            @error('account_number') <span class="text-danger">{{ $message }}</span> @enderror
        </fieldset>
        
        <fieldset class="form-group col-12 col-md-4">
            <label for="for_pay_method">Tipo de Pago</label>
            <select wire:model.lazy="pay_method" class="form-control">
            <option value="">Seleccionar Forma de Pago</option>
            <option value="01">CTA CORRIENTE / CTA VISTA</option>
            <option value="02">CTA AHORRO</option>
            <option value="30">CUENTA RUT</option>
            </select>
            @error('pay_method') <span class="text-danger">{{ $message }}</span> @enderror
        </fieldset>   
    </div><br>

    <button class="btn btn-primary" wire:click="saveBankAccount()" type="button">Guardar</button>
    
    <br><hr>
    @endif

    <h4>
        Mis solicitudes 
        <button wire:click="showCreateForm" class="btn btn-primary btn-sm ml-2">Crear</button>
        <button wire:click="updateBankAccounts" class="btn btn-success btn-sm ml-2">Actualizar mis datos bancarios</button>
    </h4>

    <table class="table table-bordered table-sm" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha solicitud</th>
                <th>Beneficio</th>
                <th>Adjunto</th>
                <th>Estado</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->created_at->format('Y-m-d') }}</td>
                    <td>{{ $request->subsidy->benefit->name }} - {{ $request->subsidy->name }}</td>
                    <td>
                        @if($request->files->count() > 0)
                            @foreach($request->files as $file)
                                <a href="#" wire:click="showFile({{ $file->id }})">
                                <span class="fas fa-download" aria-hidden="true"></span></a>
                            @endforeach
                        @endif
                    </td>
                    <td>{{ $request->status }}</td>
                    <td>{{ $request->status_update_observation }}</td>
                    <!-- <td>
                        <button wire:click="editRequest({{ $request->id }})" class="btn btn-primary btn-sm">Editar</button>
                        <button wire:click="deleteRequest({{ $request->id }})" class="btn btn-danger btn-sm">Eliminar</button>
                    </td> -->
                </tr>
            @endforeach
        </tbody>
    </table>

</div>