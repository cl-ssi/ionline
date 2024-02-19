<div>

    <div class="form-row mb-3">
        <div class="col">
            <h4 class="card-title">
                Contrato id: <a href="{{ route('rrhh.service-request.edit', $serviceRequest) }}">{{ $serviceRequest->id }}</a>
            </h4>
        </div>
        <div class="col-1">

        </div>
        <div class="col-2"></div>

        <div class="col-2">
        <button class="btn btn-danger" wire:click="deleteRequest({{$serviceRequest}})" 
            onclick="confirm('¿Está seguro de eliminar la solicitud?') || event.stopImmediatePropagation()"
            @disabled(!auth()->user()->can('Service Request: fulfillments rrhh'))>
            Eliminar solicitud
        </button>
        </div>
    </div>

    

    <div class="form-row mb-3">
        <div class="col-md-3">
            <label for="validationDefault02">Programa</label>
            <select name="" id="" class="form-control bg-success text-white" disabled>
                <option value="">{{ $serviceRequest->programm_name }}</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="validationDefault01">Fuente de financiamiento</label>
            <select name="" id="" class="form-control bg-success text-white" disabled>
                <option value="">{{ $serviceRequest->type }}</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="validationDefault02">Responsable</label>
            @if ($serviceRequest->SignatureFlows->isNotEmpty())
                <input type="text" disabled class="form-control" id="validationDefault02"
                    value="{{ optional(optional($serviceRequest->SignatureFlows->where('sign_position', 1)->first())->user)->shortName }}">
            @endif
        </div>
        <div class="col-md-3">
            <label for="validationDefault02">Supervisor</label>
            <input type="text" disabled class="form-control" id="validationDefault02"
                value="{{ optional(optional($serviceRequest->SignatureFlows->where('sign_position', 2)->first())->user)->shortName }}">
        </div>
    </div>

    <div class="form-row mb-3">
        <div class="col-md-2">
            <label for="validationDefault02">Estamento</label>
            <select name="" id="" class="form-control" disabled>
                <option value="">
                    {{ $serviceRequest->profession ? $serviceRequest->profession->estamento : $serviceRequest->estate }}
                </option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="validationDefault02">Profesión</label>
            <select name="" id="" class="form-control" disabled>
                <option value="">{{ optional($serviceRequest->profession)->name }}</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="validationDefault02">Tipo de contrato</label>
            <input type="text" class="form-control" disabled id="validationDefault02"
                value="{{ $serviceRequest->program_contract_type }}">
        </div>
        <div class="col-md-4">
            <label for="validationDefault02">Jornada de trabajo</label>
            <input type="text" class="form-control" disabled id="validationDefault02"
                value="{{ $serviceRequest->working_day_type }}">
        </div>
    </div>

    <div class="form-row mb-3">
        <div class="col-md-6">
            <label for="validationDefault02">Establecimiento</label>
            <select name="" id="" class="form-control" disabled>
                <option value="">{{ $serviceRequest->establishment->name }}</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="validationDefault02">Unidad Organizacional</label>
            <select name="" id="" class="form-control bg-info text-white" disabled>
                <option value="">{{ $serviceRequest->responsabilityCenter->name }}</option>

            </select>
        </div>

    </div>
</div>
