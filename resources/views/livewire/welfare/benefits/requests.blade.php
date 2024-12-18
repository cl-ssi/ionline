<div>
    @include('welfare.nav')

    <div>
        @if (session()->has('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
        @endif
    </div>

    @if($showCreate)

        <h4>Nueva solicitud</h4>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="benefit_id">Categoría:</label>
                    <select wire:model.live="benefit_id" class="form-select" id="benefit_id">
                        <option value="">Selecciona una categoría</option>
                        @foreach($benefits as $benefit)
                            <option value="{{ $benefit->id }}">{{ $benefit->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="subsidy_id">Beneficio:</label>
                    <select wire:model.live="subsidy_id" class="form-select" id="subsidy_id">
                        <option value="">Selecciona un beneficio</option>
                        @foreach($subsidies as $subsidy_item)
                            <option value="{{ $subsidy_item->id }}">{{ $subsidy_item->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
            @if($subsidy_id && $showData)
            <br>
            <table class="table table-bordered table-sm" >
                <thead>
                    <tr>    
                        <th style="width: 40%">Descripción</th>
                        <th style="width: 45%">Documentos de respaldo</th>
                    </tr>
                </thead>
                <tbody>
                    <td><span class="valor" style="white-space: pre-wrap;">{{ $subsidy->description }}</span></td>
                    <td>
                        <ul>
                        @foreach($subsidy->documents as $key => $document)
                            @if($document->type == "Documentación")
                                <li>
                                    {{$document->name}}
                                </li>
                            @endif
                        @endforeach

                        <div id="fileInputs">
                            @foreach($files as $key => $file)
                                <div wire:loading wire:target="files.{{ $key }}">
                                    <i class="fas fa-spinner fa-spin"></i> <b>Cargando...</b>
                                </div>
                                <input type="file" wire:model.live="files.{{ $key }}" class="form-control mb-2" accept="application/pdf">
                                @error('files.' . $key) <span class="text-danger">{{ $message }}</span> @enderror
                            @endforeach
                        </div>

                        <div wire:loading wire:target="addFileInput">
                            <i class="fas fa-spinner fa-spin"></i> <b>Agregando input...</b>
                        </div>

                        <button wire:click.prevent="addFileInput" class="btn btn-primary btn-sm" wire:loading.attr="disabled">
                            Agregar Archivo
                        </button>

                        </ul>
                    </td>
                </tbody>
            </table>

            <div class="row g-2 mb-3">
                <div class="col-md-3">
                    <label>Funcionario</label>
                    @if(auth()->user()->can('be god') || auth()->user()->can('welfare: benefits'))
                        @livewire('search-select-user', ['selected_id' => 'user_id', 
                                                         'emit_name' => 'loadUserData',
                                                         'required' => 'required',
                                                         'user' => auth()->user()])
                    @else
                        <input type="hidden" wire:model.live="user_id">
                        <input type="text" class="form-control" disabled value="{{auth()->user()->tinyName}}">
                    @endif
                    @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-3">
                    <label>Monto solicitado</label>        
                    <input type="number" wire:model.blur="requested_amount" class="form-control" required>
                    @error('requested_amount') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            {{--
            <!-- <div class="row g-2 mb-3">
                <div class="col-md-3">
                    <label>Correo electrónico</label>
                    <input type="text" wire:model.blur="email" class="form-control" required>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-3">
                    <label>Banco</label>        
                    <select wire:model.blur="bank_id" class="form-select" required>
                    <option value="">Seleccionar Banco</option>
                    @foreach($banks as $bank)
                    <option value="{{$bank->id}}">{{$bank->name}}</option>
                    @endforeach
                    </select>
                    @error('bank_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-3">
                    <label for="for_pay_method">Tipo de Cuenta</label>
                    <select wire:model.blur="pay_method" class="form-select">
                    <option value="">Seleccionar Forma de Pago</option>
                    <option value="01">CTA CORRIENTE / CTA VISTA</option>
                    <option value="02">CTA AHORRO</option>
                    <option value="30">CUENTA RUT</option>
                    </select>
                    @error('pay_method') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-3">
                    <label>Número de Cuenta</label>
                    <input type="number" wire:model.blur="account_number" class="form-control" required>
                    @error('account_number') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div> -->
            --}}

            <div wire:loading>
                <i class="fas fa-spinner fa-spin"></i> Espere...
            </div>

            <div wire:loading.remove>
                <button wire:click="saveRequest" wire:loading.attr="disabled" class="btn btn-success">Guardar</button>
            </div>
            

            @endif

        <br>
        <hr>
    @endif

    <h4>
        Mis solicitudes
        <button wire:click="showCreateForm" class="btn btn-primary btn-sm ml-2">Crear</button>
    </h4>

    <table class="table table-bordered table-sm" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha solicitud</th>
                <th>Beneficio</th>
                <th>Monto solicitado</th>
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
                    <td>
                        @if($request->subsidy->benefit) {{ $request->subsidy->benefit->name }} - {{ $request->subsidy->name }} @endif
                        @if($request->accepted_amount)
                        <br><b>MONTO APROBADO: </b> ${{ money($request->accepted_amount) }}
                        @endif
                        @if($request->status_update_observation)
                        <br><b>OBSERVACIONES: </b> {{ $request->status_update_observation }}
                        @endif
                        @if($request->payed_date)
                            <li> 
                                Transferido: {{ $request->payed_date->format('Y-m-d')}} - <b>${{ money($request->payed_amount) }}
                            </li>
                        @endif

                    </td>
                    <td>${{ money($request->requested_amount) }}</td>
                    <td>
                        <div class="d-flex align-items-center flex-wrap" style="gap: 10px;">
                            @if($request->files->count() > 0)
                                @foreach($request->files as $file)
                                    <div wire:key="file-{{ $file->id }}" class="d-flex align-items-center" style="gap: 5px;">
                                        <a href="{{ route('welfare.download', $file->id) }}" target="_blank" style="margin-right: 5px;">
                                            <i class="fas fa-paperclip"></i>
                                        </a>
                                        @if($request->status == "En revisión")
                                            <button wire:click.prevent="deleteFile({{ $file->id }})" class="btn btn-danger btn-sm" style="padding: 2px 5px; font-size: 12px;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <div wire:loading wire:target="deleteFile({{ $file->id }})" style="margin-left: 5px;">
                                                <i class="fas fa-spinner fa-spin"></i> <b>Eliminando...</b>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif

                            @if($request->status == "En revisión")
                                <div id="fileInputs" class="d-flex align-items-center" style="gap: 10px;">
                                    @foreach($files as $key => $file)
                                        <div wire:loading wire:target="files.{{ $key }}">
                                            <i class="fas fa-spinner fa-spin"></i> <b>Cargando...</b>
                                        </div>
                                        <input type="file" wire:model.live="files.{{ $key }}" class="form-control mb-2" accept="application/pdf" style="max-width: 200px;">
                                        @error('files.' . $key) <span class="text-danger">{{ $message }}</span> @enderror
                                    @endforeach
                                </div>

                                @if($showFileInput)
                                    <div class="d-flex align-items-center" style="gap: 10px;">
                                        <input type="file" wire:model.live="newFile" class="form-control mb-2" accept="application/pdf" style="max-width: 200px;">
                                        <div wire:loading wire:target="newFile">
                                            <i class="fas fa-spinner fa-spin"></i> <b>Cargando...</b>
                                        </div>
                                        <div wire:loading wire:target="saveFile">
                                            <i class="fas fa-spinner fa-spin"></i> <b>Cargando...</b>
                                        </div>
                                        
                                        <div wire:loading.remove>
                                            <button wire:click.prevent="saveFile({{ $request->id }})" class="btn btn-primary btn-sm" style="padding: 2px 5px; font-size: 12px;" wire:loading.attr="disabled">
                                                Guardar
                                            </button>
                                        </div>
                                    </div>
                                    @error('newFile') <span class="text-danger">{{ $message }}</span> @enderror
                                @else
                                    <button wire:click.prevent="enableFileInput" class="btn btn-primary btn-sm" style="padding: 2px 5px; font-size: 12px;">
                                        Agregar Archivo
                                    </button>
                                @endif
                            @endif
                        </div>
                    </td>

                    <td>{{ $request->status }}</td>
                    <td>{{ $request->status_update_observation }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <div class="jumbotron mt-3">
        <h3>Digitalizar documentación de respaldo</h3>
        <p>Al momento de hacer una solictud, para adjuntar los documentos de respaldo te recomendamos hacerlo de la siguiente manera.</p>
        <div class="row">
            <fieldset class="form-group col-12 col-md-2"></fieldset>
            <fieldset class="form-group col-12 col-md-8">
                <iframe width="100%" height="315" src="https://www.youtube.com/embed/iHWq_kfOFUM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </fieldset>
            <fieldset class="form-group col-12 col-md-2"></fieldset>
        </div>
    </div>
</div>
