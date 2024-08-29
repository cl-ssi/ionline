<div class="form-row mt-3">
    <fieldset class="form-group col-md-5">
        <label for="name">Nombre</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
            wire:model.live.debounce.1000ms="name" placeholder="Ingresa el nombre"
            value="{{ old('name', optional($program)->name) }}" required>
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-3">
        <label for="alias">Alias</label>
        <input type="text" class="form-control @error('alias') is-invalid @enderror" id="alias"
            wire:model.live.debounce.1000ms="alias" placeholder="Ingresa el alias o nombre corto"
            value="{{ old('alias', optional($program)->alias) }}" required>
        @error('alias')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-2">
        <label for="period">Período</label>
        <select wire:model.live="period" id="period" class="form-control @error('period') is-invalid @enderror">
            <option></option>
            <option>{{ date('Y') }}</option>
            <option>{{ date('Y') + 1 }}</option>
            <option>{{ date('Y') - 1 }}</option>
        </select>
        @error('period')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-2">
        <label for="is_program">&nbsp;</label>
        <div class="form-check mt-2">
            <input class="form-check-input" type="checkbox" value="" id="is_program" wire:model.live="is_program">
            <label class="form-check-label" for="is_program">
                ¿Es programa?
            </label>
        </div>
    </fieldset>

    <!--fieldset class="form-group col-md-2">
        <label for="start-date">Fecha Inicio</label>
        <input
            type="date"
            class="form-control @error('start_date') is-invalid @enderror"
            id="start-date"
            wire:model.live.debounce.1000ms="start_date"
            value="{{ old('start_date', optional($program)->start_date) }}"
            required
        >
        @error('start_date')
    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
@enderror
    </fieldset-->

    <!--fieldset class="form-group col-md-2">
        <label for="end-date">Fecha Fin</label>
        <input
            type="date"
            class="form-control @error('end_date') is-invalid @enderror"
            id="end-date"
            wire:model.live.debounce.1000ms="end_date"
            value="{{ old('end_date', optional($program)->end_date) }}"
            required
        >
        @error('end_date')
    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
@enderror
    </fieldset-->
</div>
<div class="form-row">
    <fieldset class="form-group col-md-12">
        <label for="description">Descripción</label>
        <input type="text" class="form-control @error('description') is-invalid @enderror" id="description"
            wire:model.live.debounce.1000ms="description" value="{{ old('description', optional($program)->description) }}"
            required>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<hr>
<h5>Finanzas</h5>

<div class="form-row">
    <fieldset class="form-group col-md-4">
        <label for="alias_finance">Nombre en finanzas</label>
        <input type="text" class="form-control @error('alias_finance') is-invalid @enderror" id="alias_finance"
            wire:model.live.debounce.1000ms="alias_finance" placeholder="Nombre de finanzas"
            value="{{ old('alias_finance', optional($program)->alias_finance) }}" required>
        @error('alias_finance')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-2">
        <label for="subtitle_id">Sub</label>
        <select class="form-control @error('subtitle_id') is-invalid @enderror" id="subtitle_id"
            wire:model.live.debounce.1000ms="subtitle_id" required>
            <option></option>
            @foreach ($subtitles as $id => $subtitle)
                <option value="{{ $id }}">{{ $subtitle }}</option>
            @endforeach
        </select>
        @error('subtitle_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-3">
        <label for="financial_type">Tipo Financiamiento</label>
        <input type="text" class="form-control @error('financial_type') is-invalid @enderror" id="financial_type"
            wire:model.live.debounce.1000ms="financial_type" placeholder="Ingresa tipo de financiamiento"
            value="{{ old('financial_type', optional($program)->financial_type) }}" required>
        @error('financial_type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-1">
        <label for="folio">Folio</label>
        <input type="text" class="form-control @error('folio') is-invalid @enderror" id="folio"
            wire:model.live.debounce.1000ms="folio" placeholder="Nº folio"
            value="{{ old('folio', optional($program)->folio) }}" required>
        @error('folio')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-2">
        <label for="budget">Presupuesto</label>
        <input type="text" class="form-control @error('budget') is-invalid @enderror" id="budget"
            wire:model.live.debounce.1000ms="budget" placeholder=""
            value="{{ old('budget', optional($program)->budget) }}" required>
        @error('budget')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

</div>


<br><br>

@if($program && $program->audits())
    <hr />
    <div style="height: 300px; overflow-y: scroll;">
        @include('partials.audit', ['audits' => $program->audits()])    
    </div>
@endif

