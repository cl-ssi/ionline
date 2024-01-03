<div>

    <style>
        body {
            font-family: Verdana, sans-serif;
        }

        .box {
            padding: var(--b);
            /* space for the border */

            position: relative;
            /*Irrelevant code*/
            box-sizing: border-box;
            padding: 6px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .box::before {
            content: "";
            position: absolute;
            inset: 0;
            background: var(--c, red);
            padding: var(--b);
            border-radius: var(--r);
            -webkit-mask:
                linear-gradient(0deg, #000 calc(2*var(--b)), #0000 0) 50% var(--b)/calc(100% - 2*var(--w)) 100% repeat-y,
                linear-gradient(-90deg, #000 calc(2*var(--b)), #0000 0) var(--b) 50%/100% calc(100% - 2*var(--w)) repeat-x,
                linear-gradient(#000 0 0) content-box,
                linear-gradient(#000 0 0);
            -webkit-mask-composite: destination-out;
            mask-composite: exclude;
        }

        .contenedor {}

        .qr-content {
            width: 150px;
            height: 140px;
            margin-right: 25px;
            display: inline-block;
            text-align: center;
            /* border: 1px solid grey; */
        }


        #outer-circle {
            border-radius: 50%;
            width: 140px;
            height: 140px;
            margin-left: 5px;
            position: relative;
            box-shadow: 0 0 0 1px #441F23;
        }

        .logo {
            margin-top: 7px;
            width: 60px;
        }

        .establecimiento {
            font-size: 6px;
        }

        .qr-number {
            font-size: 10px;
            margin-top: -1px;
        }

        .small-text {
            font-size: 5px;
            margin-top: -2px;
        }

        .contenedor .whatsapp-number {
            font-size: 5px;
        }

        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }
        }
    </style>
    <button class="no-print"
        wire:click="togglePrinted">
        Marcar todos como impresos</button>

    <div class="contenedor">
        @foreach ($inventories as $inventory)
            <div class="qr-content">
                <div id="outer-circle">
                    <img class="logo"
                        src="{{ asset('images/inventario_' . auth()->user()->organizationalUnit->establishment->alias . '_small.png') }}"
                        alt="Logo">
                    <br>
                    <div class="box"
                        style="--c:repeating-linear-gradient(45deg,#FD9D2D 0 2px);--w:calc(50% - 20px);--b:3px;--r:10px">
                        {!! $inventory->qrSmall !!}
                    </div>

                    <div class="qr-number">{{ $inventory->number }}</div>

                    <div class="small-text">
                        En caso de extravío informar al
                    </div>
                    <div class="whatsapp-number">
                        📞+56965887867
                    </div>
                </div>
            </div>

            @if ($loop->iteration % 2 == 0)
                <br>
                <br>
            @endif
        @endforeach
    </div>

</div>
