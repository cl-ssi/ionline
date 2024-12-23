<div>
    <div class="card">
        <div class="card-header bg-primary text-white">
            {{ $title }}
        </div>
        <div class="card-body">
            <div class="form-row">
                <fieldset class="form-group col-sm-5">
                    <label for="for_userAuthority">Responsable:</label>
                    <input wire:model.live="userAuthority" name="userAuthority" class="form-control form-control-sm" type="text" readonly>
                </fieldset>

                <fieldset class="form-group col-sm-2">
                    <label>Cargo:</label><br>
                    <input wire:model.live="position" name="position" class="form-control form-control-sm" type="text" readonly>
                </fieldset>

                <fieldset class="form-group col-sm-5">
                    <label for="forRut">Unidad Organizacional:</label>
                    <input wire:model.live="organizationalUnit" name="organizationalUnit" class="form-control form-control-sm" type="text" readonly>
                </fieldset>
            </div>
            @if($eventType=='finance_event')
            <div class="form-row">
                {{--<fieldset class="form-group col-sm-6">
                    <label>Programa Asociado:</label><br>
                    <input wire:model.live.debounce.50ms="program" name="program" class="form-control form-control-sm" type="text">
                </fieldset>--}}

                <fieldset class="form-group col-sm-5">
                    <label>Programa Asociado:</label><br>
                    <select wire:model.live="program_id" name="program_id" class="form-control form-control-sm " required>
                        <option value="">Seleccione...</option>
                        @foreach($lstProgram as $val)
                            <option value="{{$val->id}}">{{$val->alias_finance}} {{$val->period}} - Subtítulo {{$val->Subtitle->name}}</option>
                        @endforeach
                    </select>
                    @error('program_id') <span class="text-danger small">{{ $message }}</span> @enderror
                </fieldset>

                <fieldset class="form-group col-sm-2">
                        <label for="forRut">Folio SIGFE:</label>
                        <input wire:model.live="sigfe" name="sigfe" wire:click="resetError" class="form-control form-control-sm" type="text" readonly>
                    </fieldset>

                    <fieldset class="form-group col-sm-2">
                        <label for="forRut">Financiamiento</label>
                        <input wire:model.live="financial_type" name="financial_type" wire:click="resetError" class="form-control form-control-sm" type="text" readonly>
                    </fieldset>
            </div>
            @endif

            @if($eventType=='supply_event')
            <div class="form-row">
                <fieldset class="form-group col-sm">
                    <label>Comprador:</label><br>
                    <select wire:model="supervisorUser" wire:click="resetError" name="supervisorUser" class="form-control form-control-sm" required>
                        <option value="">Seleccione...</option>
                        @foreach($lstSupervisorUser as $user)
                        <option value="{{$user->id}}">{{ $user->tinyName }}</option>
                        @endforeach
                    </select>
                    @error('supervisorUser') <span class="error text-danger">{{ $message }}</span> @enderror
                </fieldset>

                <fieldset class="form-group col-sm">
                    <label>Mecanismo de Compra:</label><br>
                    <select wire:model.live="purchaseMechanism" name="purchaseMechanism" wire:change="changePurchaseMechanism" class="form-control form-control-sm" required>
                        <option value="">Seleccione...</option>
                        @foreach($lstPurchaseMechanism as $val)
                        <option value="{{$val->id}}">{{$val->name}}</option>
                        @endforeach
                    </select>
                    @error('purchaseMechanism') <span class="error text-danger">{{ $message }}</span> @enderror
                </fieldset>

                <fieldset class="form-group col-sm">
                    <label>Tipo de Compra:</label><br>
                    <select wire:model="purchaseType" wire:click="resetError" name="purchaseType" class="form-control form-control-sm" required>
                        <option value="">Seleccione...</option>
                        @foreach($lstPurchaseType as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                    @error('purchaseType') <span class="error text-danger">{{ $message }}</span> @enderror
                </fieldset>

                <fieldset class="form-group col-sm">
                    <label>Unidad de Compra:</label><br>
                    <select wire:model="purchaseUnit" wire:click="resetError" name="purchaseUnit" class="form-control form-control-sm" required>
                        <option value="">Seleccione...</option>
                        @foreach($lstPurchaseUnit as $unit)
                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                        @endforeach
                    </select>
                    @error('purchaseUnit') <span class="error text-danger">{{ $message }}</span> @enderror
                </fieldset>
            </div>
            @endif

            @if(in_array($eventType, ['pre_budget_event', 'pre_finance_budget_event', 'budget_event']))
            <div class="form-row">
                <fieldset class="form-group col-sm">
                    <label>Presupuesto actual:</label><br>
                    <input wire:model.live="estimated_expense" name="estimated_expense" class="form-control form-control-sm text-right" type="text" readonly>
                    @error('estimated_expense') <span class="error text-danger">{{ $message }}</span> @enderror
                </fieldset>

                <fieldset class="form-group col-sm">
                    <label>Presupuesto nuevo:</label><br>
                    <input wire:model.live="new_estimated_expense" name="new_estimated_expense" class="form-control form-control-sm text-right" type="text" readonly>
                    @error('new_estimated_expense') <span class="error text-danger">{{ $message }}</span> @enderror
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-sm">
                    <label for="for_purchaser_observation">Observación Comprador:</label>
                    <textarea wire:model="purchaser_observation" wire:click="resetError" name="purchaser_observation" class="form-control form-control-sm" rows="3" readonly></textarea>
                    @error('purchaser_observation') <span class="error text-danger">{{ $message }}</span> @enderror
                </fieldset>
            </div>
            @endif

            <div class="form-row">
                <fieldset class="form-group col-sm">
                    <label for="for_comment">Observación:</label>
                    <textarea wire:model.live="comment" wire:click="resetError" name="comment" class="form-control form-control-sm" rows="3"></textarea>
                    @error('comment') <span class="error text-danger">{{ $message }}</span> @enderror
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group col-sm">
                    <label for="">Adjuntos</label>
                    @if($files)
                        @foreach($files as $file)
                            <a href="{{ route('request_forms.event.show_file', $file) }}" class="list-group-item list-group-item-action py-2 small" target="_blank">
                                <i class="fas fa-file"></i> {{ $file->name }} -
                                <i class="fas fa-calendar-day"></i> {{ $file->created_at->format('d-m-Y H:i') }}</a>
                        @endforeach
                    @endif

                </fieldset>
            </div>

            <div class="row justify-content-md-end mt-0">
                @if(in_array($eventType, ['finance_event', 'budget_event']))
                <div class="col-2">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#exampleModal">
                        Autorizar
                    </button>
                </div>
                @include('request_form.partials.modals.finance_sign')
                @else
                <div class="col-2">
                    <button type="button" wire:click="acceptRequestForm" class="btn btn-primary btn-sm float-right">Autorizar</button>
                </div>
                @endif
                <div class="col-1">
                    <button type="button" wire:click="rejectRequestForm" class="btn btn-secondary btn-sm float-right">Rechazar</button>
                </div>
            </div>
        </div>
    </div>
</div>
