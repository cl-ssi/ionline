<div>
	<button type="button" data-toggle="modal" data-target="#updateModal"  data-keyboard= "false"
  data-backdrop= "static" wire:click="editShiftDay">
	    @if($shiftDay->working_day!="F")
	        {{$shiftDay->working_day}}
	    @else
	        -
	     @endif
	</button>
</div>
