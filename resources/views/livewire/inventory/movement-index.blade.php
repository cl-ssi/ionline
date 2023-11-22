<div>
    <!-- START BASIC INFORMATION-->
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
        @elseif(isset($data_preview['request_form']))
            <li>
                <span class="badge rounded-pill text-bg-primary">
                    Nuevo
                </span>

                {{ Carbon\Carbon::parse($data_preview['request_form']['created_at'])->format('Y-m-d') }}
                - Formulario de solicitud de compra
                <a
                    href="{{ route('request_forms.show', $data_preview['request_form']['id']) }}"
                    target="_blank"
                >
                    #{{ $data_preview['request_form']['id'] }}
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
        @elseif(isset($data_preview['purchase_order']))
            <li>
                <span class="badge rounded-pill text-bg-primary">
                    Nuevo
                </span>

                {{ Carbon\Carbon::parse($data_preview['purchase_order']['date'])->format('Y-m-d') }}

                - Orden de compra <b>{{ $data_preview['purchase_order']['code'] }}</b>

                @if($data_preview['control'])
                    (Ingreso #{{ $data_preview['control']['id'] }})
                @endif
            </li>
        @endif

        @if($inventory->control)
            <li>
                {{ $inventory->control->date->format('Y-m-d') }}
                -
                @if($inventory->control->isConfirmed())
                    <a
                        href="{{ route('warehouse.control.pdf', [
                            'store' => $inventory->control->store,
                            'control' => $inventory->control,
                            'act_type' => 'reception'
                        ]) }}"
                        target="_blank"
                        title="Acta Recepción Técnica"
                    >
                    Recepción en bodega
                    </a>
                @endif
            </li>
        @elseif(isset($data_preview['control']))
        <li>
            <span class="badge rounded-pill text-bg-primary">
                Nuevo
            </span>

            {{ Carbon\Carbon::parse($data_preview['control']['date'])->format('Y-m-d') }}
            -
            @if($data_preview['control']['isConfirmed'])
                <a
                    href="{{ route('warehouse.control.pdf', [
                        'store' => $data_preview['control']['store']['id'],
                        'control' => $data_preview['control']['id'],
                        'act_type' => 'reception'
                    ]) }}"
                    target="_blank"
                    title="Acta Recepción Técnica"
                >
                Recepción en bodega
                </a>
            @endif
        </li>
        @endif

        <li>
            {{ $inventory->created_at->format('Y-m-d')}} - Ingreso a inventario
        </li>
        <!-- END BASIC INFORMATION-->


        <!-- START MOVEMENTS -->
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
                {{ isset($movement->place->location->name) ? $movement->place->location->name : 'Sin ubicación' }}
                -
                {{ isset($movement->place->name) ? $movement->place->name : 'Sin ubicación' }}

            </li>
        @endforeach
        <!-- START MOVEMENTS -->


        <!-- START OF DISCHARGE -->
        @if(isset($inventory->discharge_date) && isset($inventory->act_number))
            <li>
                {{ $inventory->discharge_date->format('Y-m-d') }}
                - De baja a través de acta
                <a
                    href="{{ route('inventories.discharge-document', $inventory)}}"
                    target="_blank"
                >
                    {{ $inventory->act_number }}
                </a>
            </li>
        @endif
        <!-- END OF DISCHARGE -->
    </ul>

    <!-- <div class="row text-center">
        <div class="col" wire:loading>
            @include('layouts.bt4.partials.spinner')
        </div>
    </div> -->
</div>
