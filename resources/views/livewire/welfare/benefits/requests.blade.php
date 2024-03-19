<div>
    @include('welfare.nav')

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
                    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Tipo:</label>
                            <input type="text" class="form-control" id="type" wire:model="subsidy.type" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="value">Valor:</label>
                            <input type="text" class="form-control" id="value" wire:model="subsidy.value" disabled>
                        </div>
                    </div> -->
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
                <!-- <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="recipient">Beneficiario:</label>
                            <input type="text" class="form-control" id="recipient" wire:model="subsidy.recipient" disabled>
                        </div>
                    </div>
                </div> -->

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

                <div>
                @if (session()->has('message'))
                    <div class="alert alert-danger">
                        {{ session('message') }}
                    </div>
                @endif
                </div>

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

    <h4>
        Mis solicitudes <button wire:click="showCreateForm" class="btn btn-primary btn-sm ml-2">Crear</button>
    </h4>

    <table class="table table-bordered table-sm" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha solicitud</th>
                <th>Beneficio</th>
                <th>Adjunto</th>
                <th>Estado</th>
                <!-- <th>Acciones</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->created_at }}</td>
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
                    <!-- <td>
                        <button wire:click="editRequest({{ $request->id }})" class="btn btn-primary btn-sm">Editar</button>
                        <button wire:click="deleteRequest({{ $request->id }})" class="btn btn-danger btn-sm">Eliminar</button>
                    </td> -->
                </tr>
            @endforeach
        </tbody>
    </table>

</div>