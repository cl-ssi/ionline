<div>
	<button type="button" data-toggle="modal" data-target="#updateModal"  data-keyboard= "false"
  data-backdrop= "static" wire:click="editShiftDay" style="color:white;font-weight: bold;background-color:{{ $statusColors[$shiftDay->status] }}">
	    @if($shiftDay->working_day!="F")
	        {{$shiftDay->working_day}}
	    @else
	        -
	     @endif
	</button>
</div>
