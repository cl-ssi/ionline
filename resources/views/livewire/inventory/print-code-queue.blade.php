<div>
    <style>
        .bg-image-HAH {
            width: 340px;
            height: 340px;
            background-image: url('{{ asset('images/inventario_HAH_nuevo.png') }}');
            background-size: 340px;
        }

        .bg-image-SST {
            width: 340px;
            height: 340px;
            background-image: url('{{ asset('images/inventario_SST_nuevo.png') }}');
            background-size: 340px;
        }

        .qr {
            padding-top: 111px;
            padding-left: 6px;
        }

        .code {
            padding-top: 8px;
            text-align: center;
            font-size: 19px;
            font-weight: bold;
        }
    </style>

    @section('title', 'Inventario')

    @include('inventory.nav', [
        'establishment' => $establishment
    ])

    <div class="row d-print-none">
        <div class="col-8">
            <h4 class="mb-3">
                {{ $establishment->name }}: Inventario
            </h4>
        </div>
        <div class="col text-end">
            <button class="btn btn-success" wire:click="togglePrinted">
                <i class="bi bi-printer"></i> Marcar todos como impresos</button>
        </div>

    </div>

    @foreach($inventories as $inventory)
        <div class="bg-image-{{ $inventory->establishment->alias }} d-block">
            <div class="qr text-center">
                {!! $inventory->qr !!}
            </div>
            <div class="code">
                {{ $inventory->number }}
            </div>
        </div>
    @endforeach
</div>
