<div>
	<button type="button" wire:click="editShiftDay">
	    @if($shiftDay->working_day!="F")
	        {{$shiftDay->working_day}}
	    @else
	        -
	     @endif
	</button>
</div>
