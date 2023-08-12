<div>
    @if(is_null($dte->confirmation_send_at))
        <button type="button" class="btn btn-sm btn-primary" wire:click="sendConfirmation()">
            <i class="fas fa-paper-plane"></i>
        </button>
    @else
    <i class="fas fa-paper-plane"></i> {{ $dte->confirmation_send_at }}
        <br>
        @switch($dte->confirmation_status)
            @case('0')
                <i class="fas fa-fw fa-thumbs-down text-danger"></i>
                @break
            @case('1')
                <i class="fas fa-fw fa-thumbs-up text-success"></i>
                @break
            @case(null)
                <i class="fas fa-fw fa-hourglass-start"></i>
                @break
        @endswitch
        @if($dte->confirmation_at)
            {{ $dte->confirmation_at }}
        @else
            <a href="{{ route('finance.dtes.confirmation',$dte) }}">Link confirmación</a>
        @endif
    @endif
</div>
