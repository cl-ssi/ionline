<div>
    <style>
        .bg-image {
            width: 340px;
            height: 340px;
            border: 2px solid #ccc;
            background-image: url('{{ asset('images/inventario_HAH.png') }}');
            background-size: 340px;
        }
        .qr {
            padding-top: 111px;
            padding-left: 6px;
        }
        .code {
            padding-top: 16px;
            padding-left: 6px;
            font-size: 9px;
        }
    </style>

    <div class="bg-image">
        <div class="qr text-center">
            {!! $inventory->qr !!}
        </div>
        <div class="code text-center">
            {{ $inventory->number }}
        </div>
    </div>
    
    Acá se verá la información del inventario de este item
    <hr>
</div>
