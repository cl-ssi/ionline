<!-- Si es una firma digital y fue aprobada, entonces no muestro el include ya que se mostrará la imagen de la firma -->
@if (!($approval->digital_signature == true and $approval->status == true))
    <style type="text/css">
        .wrapper-endorse {
            border: 0.01em solid #CCC;
            padding: 0.1rem;
        }

        .text {
            margin-bottom: 1px;
            margin-top: 1px;
        }

        .bold {
            font-weight: bold;
        }

        .big {
            font-size: 11px;
        }
    </style>

    <div class="wrapper-endorse">
        <p class="text big bold {{ $approval->color }}">
            @switch($approval->status)
                @case('1')
                    {{ $approval->approver->initials }}
                @break

                @case('0')
                    {{ $approval->approver->shortName }}
                @break

                @default
                    <span style="color: #ccc"><i>PEN</i></span>
                @break
            @endswitch
        </p>
    </div>
@endif
