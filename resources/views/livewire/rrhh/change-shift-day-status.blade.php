<div>

	@if(isset($shiftDay) && $shiftDay!="")
	
		
		<button type="button" data-toggle="modal" data-target="#updateModal"  data-keyboard= "false" data-backdrop= "static" wire:click.prevent="editShiftDay"  id="{{$shiftDay->id}}"  wire:key="{{$shiftDay->id}}" style="color:white;font-weight: bold;background-color:{{ $statusColors[$shiftDay->status] }}" class="btnShiftDay  btn-full">
	    	@if($shiftDay->working_day!="F")
	        	{{$shiftDay->working_day}}
	    	@else
	        	-
	    	 @endif
		</button>
		<div wire:loading wire:target="editShiftDay">
        	  <i class="fas fa-spinner fa-pulse"></i>
    	</div>
		
	@else
		 <i data-toggle="modal" data-target="#newDatModal"  data-keyboard= "false" data-backdrop= "static"  style="color:green;font-weight: bold;font-size:20px" class="fa fa-plus btnShiftDay"> </i>
	@endif
	
	<script>
        document.addEventListener('livewire:load', function () {
            var color = "{{ $actuallyColor }}";
            document.getElementById('{{$shiftDay->id}}').style.background = color; 

        })
    </script>
        
</div>
