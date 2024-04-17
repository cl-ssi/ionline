<!-- Si es una firma digital y fue aprobada, entonces no muestro el include ya que se mostrará la imagen de la firma -->
@if( ! ($approval->digital_signature == true AND $approval->status == true) )

    <style type="text/css">

        .image {
            width: 70%;
            padding-bottom: 0px;
            padding-top: 0px;
            padding-top: 0px;
        }

        .wrapper-div {
            border: 0.01em solid #CCC;
            padding: 0.1rem;
            width: 204px;
            height: 43px;
        }

        .text {
            margin-bottom: 1px;
            margin-top: 1px;
        }

        .bold {
            font-weight: bold;
        }

        .small {
            font-size: 6px;
        }

        .normal {
            font-size: 7px;
        }

        .big {
            font-size: 11px;
        }

    </style>

    <div class="wrapper-div">
        <p class="text small {{ $approval->color }}">
            @if( ! is_null($approval->status) )
                @if($approval->position == 'left')
                    Creado el
                @elseif($approval->position == 'right')
                    Toma de Conocimiento del Funcionario

                @endif
                
                {{ $approval->approver_at->format('Y-m-d \a \l\a\s H:i') }}
            @else
                &nbsp;
            @endif
        </p>
        <p class="text big bold {{ $approval->color }}">
            @switch($approval->status)
                @case('1')
                    {{ $approval->approver->shortName }}
                @break
                @case('0')
                    {{ $approval->approver->shortName }}
                @break
                @default
                    <span style="color: #ccc"><i>PENDIENTE </i></span>
                @break
            @endswitch
        </p>
        <p class="text normal">
            @if($approval->sent_to_ou_id)
                {{ substr($approval->sentToOu->name, 0, 60) }}
            @else
                {{ substr($approval->approverOu?->name, 0, 60) }}
            @endif
        </p>
        <p class="text normal">
            @if($approval->sent_to_ou_id)
                {{ $approval->sentToOu->establishment->name }}
            @else
                {{ $approval->approverOu?->establishment->name }}
            @endif
        </p>
    </div>
@endif