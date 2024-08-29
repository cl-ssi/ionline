<div>

    <h3>Ley 19.813</h3>

    <div class="mb-3">
        <label for="number" class="form-label">Meta Nº</label>
        <input
            type="text"
            class="form-control"
            wire:model="number"
            id="number"
            placeholder="META N: Ej: 1"
        />
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input
            type="text"
            class="form-control"
            wire:model="name"
            id="name"
            placeholder="INDICADOR"
        />
    </div>
    <div class="mb-3">
        <label for="numerator" class="form-label">Numerador</label>
        <input
            type="text"
            class="form-control"
            wire:model="numerator"
            id="numerator"
            placeholder="FORMULA NUMERADOR"
        />
    </div>
    <div class="mb-3">
        <label for="denominator" class="form-label">Denominator</label>
        <input
            type="text"
            class="form-control"
            wire:model="denominator"
            id="denominator"
            placeholder="FORMULA NUMERADOR"
        />
    </div>
    <div class="mb-3">
        <label for="numerator_source" class="form-label">numerator_source</label>
        <input
            type="text"
            class="form-control"
            wire:model="numerator_source"
            id="numerator_source"
            placeholder="EJ: REM A03, sección A.2 Celdas J25 + K25 + L25 + M25 + J27 + K27 + L27 + M27"
        />
    </div>
    <div class="mb-3">
        <label for="denominator_source" class="form-label">denominator_source</label>
        <input
            type="text"
            class="form-control"
            wire:model="denominator_source"
            id="denominator_source"
            placeholder="VERIFICADOR DENOMINADOR EJ: REM A03, Sección A.2 Celdas (J22 + K22 + L22 + M22) - (J36 + K36 + L36 + M36) - (J39 - K39 - L39 - M39)"
        />
    </div>
    <div class="mb-3">
        <label for="numerator_cods" class="form-label">numerator_cods</label>
        <input
            type="text"
            class="form-control"
            wire:model="numerator_cods"
            id="numerator_cods"
            placeholder="CODIGOS DEL VERIFICADOR EJ: 02010420,03500366"
        />
    </div>
    <div class="mb-3">
        <label for="denominator_cods" class="form-label">denominator_cods</label>
        <input
            type="text"
            class="form-control"
            wire:model="denominator_cods"
            id="denominator_cods"
            placeholder="CODIGOS DEL DENOMINADOR. EJ: 02010321,-03500334,-03500331"
        />
    </div>


    <div class="mb-3">
        <label for="numerator_cols" class="form-label">numerator_cols</label>
        <input
            type="text"
            class="form-control"
            wire:model="numerator_cols"
            id="numerator_cols"
            placeholder="COLUMNAS DEL NUMERADOR EJ: Col08,Col09,Col10,Col11"
        />
    </div>
    <div class="mb-3">
        <label for="denominator_cols" class="form-label">denominator_cols</label>
        <input
            type="text"
            class="form-control"
            wire:model="denominator_cols"
            id="denominator_cols"
            placeholder="COLUMNAS DEL DENOMINADOR EJ: Col08,Col09,Col10,Col11"
        />
    </div>
    <div class="mb-3">
        <label for="goal" class="form-label">META</label>
        <input
            type="text"
            class="form-control"
            wire:model="goal"
            id="goal"
            placeholder="Por coumunas EJ: 60%,60%,55%,50%,70%,60%,40%"
        />
    </div>
    
    <button class="btn btn-primary" wire:click="process">Generar</button>
    {!! $formatedQuery !!}
    <hr>
    {!! $query !!}

</div>
