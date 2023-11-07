<div>
    <ul wire:loading.remove>
        @if($inventory->requestForm)
            <li>
                {{ $inventory->requestForm->created_at->format('Y-m-d') }}
                - Formulario de solicitud de compra
                <a
                    href="{{ route('request_forms.show', $inventory->requestForm) }}"
                    target="_blank"
                >
                    #{{ $inventory->request_form_id }}
                </a>
            </li>
        @endif

        @if($inventory->purchaseOrder)
            <li>
                {{ $inventory->purchaseOrder->date->format('Y-m-d') }}
                - Orden de compra <b>{{ $inventory->purchaseOrder->code }}</b>
                @if($inventory->control)
                    (Ingreso #{{ $inventory->control->id }})
                @endif
            </li>
        @endif

        @if($inventory->control)
            <li>
                {{ $inventory->control->date->format('Y-m-d') }}
                -
                <a href="{{ route('warehouse.controls.edit', [
                        'store' => $inventory->control->store,
                        'control' => $inventory->control
                    ]) }}"
                >
                    Recepción en bodega
                </a>
            </li>
        @endif

        <li>
            {{ $inventory->created_at->format('Y-m-d')}} - Ingreso a inventario
        </li>

        @foreach($inventory->movements as $movement)
            @if($movement->installation_date)
                <li>
                    {{ $movement->installation_date->format('Y-m-d') }} - Instalación del producto
                </li>
            @endif

            <li>
                {{ $movement->created_at->format('Y-m-d') }} 
                - 
                @if($movement->reception_confirmation)
                    <a
                        href="{{ route('inventories.act-transfer', $movement) }}"
                        target="_blank"
                        title="Acta de Traspaso"
                    >
                        Acta de recepción
                    </a>
                @endif
                        
                <br>
                - Responsable: 
                <b>{{ optional($movement->responsibleUser)->shortName }}</b>

                - Recepción:
                @if($movement->reception_confirmation)
                    @if($movement->reception_date)
                        <b>{{ $movement->reception_date }}</b>
                    @endif
                @else
                    <span class="text-danger">Pendiente</span>
                @endif

                @if($movement->usingUser)
                    - Usuario: 
                    {{ $movement->usingUser->shortName }}
                @endif
                <br>

                @if($movement->observations)
                    - Observación: {{ $movement->observations }}
                    <br>
                @endif

                - Ubicación: 
                {{ $movement->place->location->name }}
                -
                {{ $movement->place->name }}


            </li>
        @endforeach

        @if($inventory->discharge_date)
            <li>
                {{ $inventory->discharge_date->format('Y-m-d') }}
                - De baja a través de acta
                <a href="#">
                    {{ $inventory->act_number }}
                </a>
            </li>
        @endif
    </ul>

    <div class="row text-center">
        <div class="col" wire:loading>
            @include('layouts.bt4.partials.spinner')
        </div>
    </div>
</div>
