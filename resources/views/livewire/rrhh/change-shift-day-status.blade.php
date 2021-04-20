<button type="button" wire:click="editShiftDay({{$shiftDay->id}})">
    @if($shiftDay->working_day!="F")
        {{$shiftDay->working_day}} {{$count}}
    @else
        -
     @endif
</button>