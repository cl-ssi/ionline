<style type="text/css">

    .image {
        width: 70%;
        padding-bottom: 0px;
        padding-top: 0px;
        padding-top: 0px;
    }

    .wrapper-div {
        border: 1px solid #999;
        padding: 0.4rem;
        width: 200px;
    }

    .text {
        margin-bottom: 1px;
        margin-top: 1px;
    }

    .bold {
        font-weight: bold;
    }

    .small {
        font-size: 9px;
    }

    .big {
        font-size: 13px;
    }

</style>


<div class="wrapper-div">

    <p class="text small {{ $approval->color }}">
        @if( ! is_null($approval->status) )
            {{ strtoupper($approval->statusInWords) }} el 
            {{ $approval->approver_at->format('d-m-Y \a \l\a\s H:i') }} por:
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
    <p class="text small">{{ substr($approval->organizationalUnit?->name, 0, 50) }}</p>
</div>
<p class="text small center {{ $approval->color }}">{{ $approval->reject_observation }}</p>