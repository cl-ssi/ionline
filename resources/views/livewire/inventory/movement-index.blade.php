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

            @if($movement->usingUser)
                <li>
                    {{ $movement->created_at->format('Y-m-d') }}
                    - Usado por
                    <b>{{ $movement->usingUser->full_name }}</b>
                    en
                    <b>{{ $movement->place->location->name }}</b>
                    -
                    <b>{{ $movement->place->name }}</b>
                </li>
            @endif

            <li>
                {{ $movement->created_at->format('Y-m-d') }}
                - Entrega a responsable
                <b>{{ $movement->responsibleUser->full_name }}</b>
                en
                <b>{{ $movement->place->location->name }}</b>
                -
                <b>{{ $movement->place->name }}</b>

                @if($movement->reception_confirmation)
                    <ul>
                        @if($movement->reception_date)
                            <li>
                                {{ $movement->reception_date }}
                                - Confirmación recepción por responsable
                                <b>{{ $movement->responsibleUser->full_name }}</b>
                            </li>
                        @endif

                        @if($movement->observations)
                            <li>
                                {{ $movement->reception_date }}
                                -
                                Observación del responsable: {{ $movement->observations }}
                            </li>
                        @endif
                    </ul>
                @endif
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
            @include('layouts.partials.spinner')
        </div>
    </div>
</div>
