<div class="form-row mb-3">
    <fieldset class="col-md-2">
        <label for="code" class="form-label">
            Código
        </label>
        <input
            type="text"
            class="form-control"
            id="code"
            value="{{ $inventory->unspscProduct->code }}"
            disabled
            readonly
        >
    </fieldset>

    <fieldset class="col-md-3">
        <label for="product" class="form-label">
            Producto <small>(Artículo)</small>
        </label>
        <input
            type="text"
            class="form-control"
            id="product"
            value="{{ $inventory->unspscProduct->name }}"
            disabled
            readonly
        >
    </fieldset>

    <fieldset class="col-md-7">
        <label for="description" class="form-label">
            Descripción <small>(especificación técnica)</small>
        </label>
        <input
            type="text"
            class="form-control"
            id="description"
            value="{{ $inventory->product ? $inventory->product->name : $inventory->description }}"
            disabled
            readonly
        >
    </fieldset>
</div>

<div class="form-row g-2 mb-2">
    <fieldset class="col">
        <label for="user" class="form-label">
            Usuario
        </label>
        <input
            type="text"
            class="form-control"
            id="user"
            value="{{ optional($inventory->using)->full_name }}"
            readonly
        >
    </fieldset>
    <fieldset class="col">
        <label for="responsible" class="form-label">
            Responsable
        </label>
        <input
            type="text"
            class="form-control"
            id="responsible"
            value="{{ optional($inventory->responsible)->full_name }}"
            readonly
        >
    </fieldset>
</div>

<div class="form-row g-2 mb-2">
    <fieldset class="col">
        <label for="location" class="form-label">
            Lugar
        </label>
        <input
            type="text"
            class="form-control"
            id="location"
            value="{{ $inventory->location }}"
            readonly
        >
    </fieldset>
</div>

<div class="form-row mb-3">
    <fieldset class="col-md-2">
        <label for="number-inventory" class="form-label">
            *Nro. Inventario
        </label>
        <input
            type="text"
            class="form-control @error('number_inventory') is-invalid @enderror"
            id="number-inventory"
            wire:model.live.debounce.1500ms="number_inventory"
        >
        @error('number_inventory')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="col-md-2">
        <label for="status" class="form-label">
            Estado
        </label>
        <select
            class="form-control @error('status') is-invalid @enderror"
            id="status"
            wire:model.live.debounce.1500ms="status"
        >
            <option value="">Seleccione un estado</option>
            <option value="1">Bueno</option>
            <option value="0">Regular</option>
            <option value="-1">Malo</option>
        </select>
        @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="col-md-8">
        <label for="observations" class="form-label">
            Observaciones
        </label>
        <input
            type="text"
            class="form-control @error('observations') is-invalid @enderror"
            id="observations"
            wire:model.live.debounce.1500ms="observations"
        >
        @error('observations')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<div class="form-row mb-3">
    <fieldset class="col-md-4">
        <label for="i-brand" class="form-label">
            *Marca
        </label>
        <input
            type="text"
            class="form-control @if($computer && !$computer->isMerged()) is-valid @endif @error('inventory_brand') is-invalid @enderror"
            id="i-brand"
            wire:model.live.debounce.1500ms="inventory_brand"
        >
        @error('inventory_brand')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="col-md-4">
        <label for="i-model" class="form-label">
           *Modelo
        </label>
        <input
            type="text"
            class="form-control @if($computer && !$computer->isMerged()) is-valid @endif @error('inventory_model') is-invalid @enderror"
            id="i-model"
            wire:model.live.debounce.1500ms="inventory_model"
        >
        @error('inventory_model')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="col-md-4">
        <label for="i-serial-number" class="form-label">
            *Número de Serie
        </label>
        <input
            type="text"
            class="form-control @if($computer && !$computer->isMerged()) is-valid @endif @error('inventory_serial_number') is-invalid @enderror"
            id="i-serial-number"
            wire:model.live.debounce.1500ms="inventory_serial_number"
        >
        @error('inventory_serial_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<h4>
    Computadora
</h4>

<div class="form-row">
    @if($computer && !$computer->isMerged())
        <fieldset class="form-group col">
            <label for="c-brand">Marca</label>
            <input
                type="text"
                class="form-control is-invalid @error('computer_brand') is-invalid @enderror"
                id="c-brand"
                wire:model.live.debounce.1500ms="computer_brand"
            >
            @error('computer_brand')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col">
            <label for="c-model">Modelo</label>
            <input
                type="text"
                class="form-control is-invalid @error('computer_model') is-invalid @enderror"
                id="c-model"
                wire:model.live.debounce.1500ms="computer_model"
            >
            @error('computer_model')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col">
            <label for="c-serial-number">Serial</label>
            <input
                type="text"
                class="form-control is-invalid @error('computer_serial_number') is-invalid @enderror"
                id="c-serial-number"
                wire:model.live.debounce.1500ms="computer_serial_number"
            >
            @error('computer_serial_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    @endif
</div>

<div class="form-row">
    <fieldset class="form-group col">
        <label for="for-hostname">Hostname</label>
        <input
            type="text"
            class="form-control @error('hostname') is-invalid @enderror"
            id="for-hostname"
            wire:model.live.debounce.1500ms="hostname"
        >
        @error('hostname')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col">
        <label for="domain">Dominio</label>
        <input
            type="text"
            class="form-control @error('domain') is-invalid @enderror"
            id="domain"
            wire:model.live.debounce.1500ms="domain"
        >
        @error('domain')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col">
        <label for="ip">*Número IP</label>
        <input
            type="IP"
            class="form-control @error('ip') is-invalid @enderror"
            id="ip"
            placeholder="10.x.x.x"
            wire:model.live.debounce.1500ms="ip"
        >
        @error('ip')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col">
        <label for="mac-address">*Dirección MAC</label>
        <input
            type="text"
            class="form-control @error('mac_address') is-invalid @enderror"
            id="mac-address"
            placeholder="00:1B:2C:3D:xx:xx"
            wire:model.live.debounce.1500ms="mac_address"
        >
        @error('mac_address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<div class="form-row">
    <fieldset class="form-group col">
        <label for="ip-group">*Grupo IP</label>
        <select
            name="ip_group"
            id="ip-group"
            class="form-control @error('ip_group') is-invalid @enderror"
            wire:model.live.debounce.1500ms="ip_group"
        >
            <option value="">Seleccione un grupo</option>
            <option value="standard">
                Estándar
            </option>
            <option value="journalist">
                Periodista
            </option>
            <option value="server">
                Servidor
            </option>
        </select>
        @error('ip_group')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col">
        <label for="rack">Rack</label>
        <input
            type="text"
            class="form-control @error('rack') is-invalid @enderror"
            id="rack"
            wire:model.live.debounce.1500ms="rack"
        >
        @error('rack')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col">
        <label for="vlan">VLAN</label>
        <input
            type="IP"
            class="form-control @error('vlan') is-invalid @enderror"
            id="vlan"
            wire:model.live.debounce.1500ms="vlan"
        >
        @error('vlan')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col">
        <label for="network-segment">Segmento de Red</label>
        <input
            type="text"
            class="form-control @error('network_segment') is-invalid @enderror"
            id="network-segment"
            placeholder="x.x.x.0"
            wire:model.live.debounce.1500ms="network_segment"
        >
        @error('network_segment')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<div class="form-row">
    <fieldset class="form-group col">
        <label for="operating-system">*Sistema Operativo</label>
        <input
            type="text"
            class="form-control @error('operating_system') is-invalid @enderror"
            id="operating-system"
            placeholder="Ej: Windows 7, Windows 10, Linux, etc."
            wire:model.live.debounce.1500ms="operating_system"
        >
        @error('operating_system')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col">
        <label for="processor">*Procesador</label>
        <input
            type="integer"
            class="form-control @error('processor') is-invalid @enderror"
            id="processor"
            placeholder="Ej: I7 3.6GHz"
            wire:model.live.debounce.1500ms="processor"
        >
        @error('processor')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col">
        <label for="ram">*RAM</label>
        <input
            type="text"
            class="form-control @error('ram') is-invalid @enderror"
            id="ram"
            placeholder="Ej: 8GB"
            wire:model.live.debounce.1500ms="ram"
        >
        @error('ram')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col">
        <label for="hard-disk">*Disco Duro</label>
        <input
            type="text"
            class="form-control @error('hard_disk') is-invalid @enderror"
            id="hard-disk"
            placeholder="Ej: 1TB"
            wire:model.live.debounce.1500ms="hard_disk"
        >
        @error('hard_disk')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<div class="form-row">
    <fieldset class="form-group col">
        <label for="intesis-id">ID Intesis</label>
        <input
            type="text"
            class="form-control @error('intesis_id') is-invalid @enderror"
            id="intesis-id"
            wire:model.live.debounce.1500ms="intesis_id"
        >
        @error('intesis_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col">
        <label for="comment">Comentario</label>
        <input
            type="text"
            class="form-control @error('comment') is-invalid @enderror"
            id="comment"
            wire:model.live.debounce.1500ms="comment"
        >
        @error('comment')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col">
        <label for="active-type">*Tipo de Activo</label>
        <select
            class="form-control @error('active_type') is-invalid @enderror"
            id="active-type"
            wire:model.live.debounce.1500ms="active_type"
        >
            <option value="">Seleccione un tipo</option>
            <option value="leased">
                Arrendado
            </option>
            <option value="own">
                Propio
            </option>
            <option value="user">
                Usuario
            </option>
        </select>
        @error('active_type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<div class="form-row">
    <fieldset class="form-group col">
        <label for="office-serial">Licencia Office</label>
        <input
            type="text"
            class="form-control @error('office_serial') is-invalid @enderror"
            id="office-serial"
            wire:model.live.debounce.1500ms="office_serial"
        >
        @error('office_serial')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col">
        <label for="windows-serial">Licencia Windows</label>
        <input
            type="text"
            class="form-control @error('windows_serial') is-invalid @enderror"
            id="windows-serial"
            wire:model.live.debounce.1500ms="windows_serial"
        >
        @error('windows_serial')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<div class="form-row">
    <fieldset class="form-group col-md-6">
        <label for="label-id">Etiquetas</label>
        @livewire('inventory.search-labels', [
            'placeholder' => 'Ingrese el nombre de una etiqueta',
            'eventName' => 'myLabelId',
            'tagId' => 'label-id',
            'module' => 'computers',
            'selectedLabels' => $computer ? $computer->labels : null
        ])
    </fieldset>
</div>
