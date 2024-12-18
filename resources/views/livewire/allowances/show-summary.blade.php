<div>
    <div class="row">
        <div class="col-12 col-sm-2">
            <h6 class="mt-1"><i class="fas fa-dollar-sign"></i> Resumen</h6>
        </div>
        <div class="col-12 col-sm-10">
            @if($allowance->HalfDaysOnlyValue == 'No' && ($allowance->creator_user_id == auth()->id() || $allowance->user_allowance_id == auth()->id()))
                <button type="button" class="btn btn-outline-primary btn-sm" wire:click="editFormSummary('edit')" {{ $editDisabled }}><i class="fas fa-edit"></i> Editar</button>
            @endif 
            @if($editForm == 'edit')
                <button type="button" class="btn btn-outline-danger btn-sm" wire:click="editFormSummary('cancel')"><i class="far fa-window-close"></i> Cancelar</button>
            @endif        
        </div>
    </div>
    
    <br>

    @if($editForm == 'edit')
        Editar aquí
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover small">
                <tbody>
                    <tr class="text-center">
                        <th width="20%">Viático</th>
                        <th width="20%">%</th>
                        <th width="20%">Valor</th>
                        <th width="20%">N° Días</th>
                        <th width="20%">Valor Total $</th>
                    </tr>
                    <tr>
                        <td><b>1. DIARIO</b></td>
                        <td class="text-center">100%</td>
                        <td class="text-right">
                            ${{ ($allowance->day_value) ? number_format($allowance->day_value, 0, ",", ".") : number_format($allowance->allowanceValue->value, 0, ",", ".") }}
                        </td>
                        <td class="text-center"> 
                            <fieldset class="form-group col-12">
                                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live.debounce.250ms="totalDays">
                                {{-- @error('reason') <span class="text-danger error small">{{ $message }}</span> @enderror --}}
                            </fieldset>
                        </td>
                        <td class="text-right">
                            {{-- ($allowance->total_days >= 1) ? number_format(($allowance->day_value * intval($allowance->total_days)), 0, ",", ".") : '0' --}}
                            <fieldset class="form-group col-12">
                                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="totalDaysValue" {{ $editDisabled }}>
                                {{-- @error('reason') <span class="text-danger error small">{{ $message }}</span> @enderror --}}
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td><b>2. PARCIAL</b></td>
                        <td class="text-center">40%</td>
                        <td class="text-right">
                            ${{ ($allowance->half_day_value) ? number_format($allowance->half_day_value, 0, ",", ".") : '0' }}
                        </td>
                        <td class="text-center">
                            {{ ($allowance->total_half_days) ? intval($allowance->total_half_days) : 0 }}

                            @if($allowance->total_half_days && $allowance->total_half_days > 1)
                                medios días
                            @elseif($allowance->total_half_days && $allowance->total_half_days == 1)
                                medio día
                            @else

                            @endif
                        </td>
                        <td class="text-right">
                            ${{ ($allowance->half_day_value) ? number_format($allowance->half_day_value * $allowance->total_half_days, 0, ",", ".") : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td><b>3. PARCIAL</b></td>
                        <td class="text-center">50%</td>
                        <td class="text-right">
                            ${{ ($allowance->fifty_percent_day_value) ? number_format($allowance->fifty_percent_day_value, 0, ",", ".") : '0' }}
                        </td>
                        <td class="text-center">
                            <fieldset class="form-group col-12">
                                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="fiftyPercentTotalDays">
                            </fieldset>
                        </td>
                        <td class="text-right">
                            <fieldset class="form-group col-12">
                                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="fiftyPercentTotalDaysValue" {{ $editDisabled }}>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td><b>4. PARCIAL</b></td>
                        <td class="text-center">60%</td>
                        <td class="text-right">
                            ${{ ($allowance->sixty_percent_day_value) ? number_format($allowance->sixty_percent_day_value, 0, ",", ".") : '0' }}
                        </td>
                        <td class="text-center">
                            <fieldset class="form-group col-12">
                                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="sixtyPercentTotalDays">
                            </fieldset>
                        </td>
                        <td class="text-right">
                            <fieldset class="form-group col-12">
                                <input class="form-control form-control-sm" type="number" autocomplete="off" wire:model.live="sixtyPercentTotalDaysValue" {{ $editDisabled }}>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>                    
                        <td class="text-center"></td>
                        <td class="text-center">
                            <b>Total</b>
                            {{--
                            @if($allowance->HalfDaysOnlyValue == 'Sí')
                                {{ ($allowance->total_half_days) ? intval($allowance->total_half_days) : 0 }}

                                @if($allowance->total_half_days && $allowance->total_half_days > 1)
                                    medios días
                                @elseif($allowance->total_half_days && $allowance->total_half_days == 1)
                                    medio día
                                @else

                                @endif
                            @else
                                @if($totalEditSummaryDays > 1)
                                    {{ $totalEditSummaryDays }} y medio días
                                @else
                                {{ $totalEditSummaryDays }} y medio día
                                @endif
                            @endif
                            --}}
                        </td>
                        <td class="text-right">
                            ${{ number_format($totalEditSummaryDaysValue, 0, ",", ".") }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="form-row">
            <fieldset class="form-group col-12 col-md-12">
                <label for="for_reason">Motivo</label>
                <textarea class="form-control" id="for_reason" wire:model.live="reason" rows="3"></textarea>
                @error('reason') <span class="text-danger error small">{{ $message }}</span> @enderror
            </fieldset>
        </div>

        @if($summaryDaysErrorMessage != null)
            <div class="alert alert-danger" role="alert">
                {{ $summaryDaysErrorMessage }}
            </div>
        @endif

        <button type="button" class="btn btn-success btn-sm float-right" wire:click="saveEditSummary"><i class="fas fa-save"></i> Guardar</button>
    @else
        @if($correctionMessage != null)
            <div class="alert alert-success" role="alert">
                {{ $correctionMessage }}
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover small">
                <tbody>
                    <tr class="text-center">
                        <th>Viático</th>
                        <th>%</th>
                        <th>Valor</th>
                        <th>N° Días</th>
                        <th>Valor Total</th>
                    </tr>
                    <tr>
                        <td><b>1. DIARIO</b></td>
                        <td class="text-center">100%</td>
                        <td class="text-right">
                            ${{ ($allowance->day_value) ? number_format($allowance->day_value, 0, ",", ".") : number_format($allowance->allowanceValue->value, 0, ",", ".") }}
                        </td>
                        <td class="text-center"> 
                            {{ ($allowance->total_days) ? intval($allowance->total_days) : 0 }}
                        </td>
                        <td class="text-right">
                            ${{ ($allowance->total_days >= 1) ? number_format(($allowance->day_value * intval($allowance->total_days)), 0, ",", ".") : '0' }}
                        </td>
                    </tr>
                    <tr>
                        <td><b>2. PARCIAL</b></td>
                        <td class="text-center">40%</td>
                        <td class="text-right">
                            ${{ ($allowance->half_day_value) ? number_format($allowance->half_day_value, 0, ",", ".") : '0' }}
                        </td>
                        <td class="text-center">
                            {{ ($allowance->total_half_days) ? intval($allowance->total_half_days) : 0 }}

                            @if($allowance->total_half_days && $allowance->total_half_days > 1)
                                medios días
                            @elseif($allowance->total_half_days && $allowance->total_half_days == 1)
                                medio día
                            @else

                            @endif
                        </td>
                        <td class="text-right">
                            ${{ ($allowance->half_day_value) ? number_format($allowance->half_day_value * $allowance->total_half_days, 0, ",", ".") : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td><b>3. PARCIAL</b></td>
                        <td class="text-center">50%</td>
                        <td class="text-right">
                            ${{ ($allowance->fifty_percent_day_value) ? number_format($allowance->fifty_percent_day_value, 0, ",", ".") : '0' }}
                        </td>
                        <td class="text-center">
                            {{ ($allowance->fifty_percent_total_days) ? intval($allowance->fifty_percent_total_days) : 0 }}
                        </td>
                        <td class="text-right">
                            ${{ ($allowance->fifty_percent_day_value) ? number_format($allowance->fifty_percent_day_value * $allowance->fifty_percent_total_days, 0, ",", ".") : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td><b>4. PARCIAL</b></td>
                        <td class="text-center">60%</td>
                        <td class="text-right">
                            ${{ ($allowance->sixty_percent_day_value) ? number_format($allowance->sixty_percent_day_value, 0, ",", ".") : '0' }}
                        </td>
                        <td class="text-center">
                            {{ ($allowance->sixty_percent_total_days) ? intval($allowance->sixty_percent_total_days) : 0 }}
                        </td>
                        <td class="text-right">
                            ${{ ($allowance->sixty_percent_day_value) ? number_format($allowance->sixty_percent_day_value * $allowance->sixty_percent_total_days, 0, ",", ".") : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>                    
                        <td class="text-center"></td>
                        <td class="text-center">
                            <b>Total</b>
                            {{--
                            @if($allowance->HalfDaysOnlyValue == 'Sí')
                                {{ ($allowance->total_half_days) ? intval($allowance->total_half_days) : 0 }}

                                @if($allowance->total_half_days && $allowance->total_half_days > 1)
                                    medios días
                                @elseif($allowance->total_half_days && $allowance->total_half_days == 1)
                                    medio día
                                @else

                                @endif
                            @else
                                @if($allowance->total_days + $allowance->fifty_percent_total_days + $allowance->sixty_percent_total_days > 1)
                                    {{ $allowance->total_days + $allowance->fifty_percent_total_days + $allowance->sixty_percent_total_days }} y medio días
                                @else
                                {{ $allowance->total_days + $allowance->fifty_percent_total_days + $allowance->sixty_percent_total_days }} y medio día
                                @endif
                            @endif
                            --}}
                        </td>
                        <td class="text-right">
                            ${{ number_format($allowance->total_value, 0, ",", ".") }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if($corrections->count() > 0)
        <br>
        <h6><i class="fas fa-info-circle"></i> Correciones Registradas</h6>

        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover small">
                <thead class="">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Fecha Corrección</th>
                        <th>Motivo</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                @foreach($corrections as $correction)
                    <tbody>
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $correction->created_at->format('d-m-Y H:i:s') }}</td>
                            <td>{{ $correction->reason }}</td>
                            <td class="text-center">{{ $correction->user->fullName }}</td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
        </div>
    @endif
    @endif
</div>
