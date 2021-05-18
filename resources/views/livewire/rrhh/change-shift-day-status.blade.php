<style type="text/css">
	  #contextMenu {
        position: absolute;
        display:none;
        --mouse-x: 0;
        --mouse-y: 0;

         transform: translateX(min(var(--mouse-x), calc(5vw - 100%)))  translateY(min(var(--mouse-y), calc(5vh - 100%)));
        }
</style>
<div>

	@if(isset($shiftDay) && $shiftDay!="")
	
		
		<button type="button" data-toggle="modal" data-target="#updateModal"  data-keyboard= "false" data-backdrop= "static" wire:click.prevent="editShiftDay"  id="{{$shiftDay->id}}"  style="color:white;font-weight: bold;background-color:{{ $statusColors[$shiftDay->status] }}" class="btnShiftDay  btn-full" onmousedown="leftContextMenu(event)">
	    	@if($shiftDay->working_day!="F")
	        	{{$shiftDay->working_day}}
	    	@else
	        	-
	    	 @endif
		</button>
		<div wire:loading wire:target="editShiftDay">
        	  <i class="fas fa-spinner fa-pulse"></i>
    	</div>
    	<div wire:loading wire:target="actuallyColor">
        	  <i class="fas fa-spinner fa-pulse"></i>
    	</div>
		
	@else
		 <i data-toggle="modal" data-target="#newDatModal"  data-keyboard= "false" data-backdrop= "static"  style="color:green;font-weight: bold;font-size:20px" class="fa fa-plus btnShiftDay"> </i>
	@endif
	<p id="contextMenu"> aaa bbb cc</p>
	<script>
    
    	 document.addEventListener('livewire:load', function () { 
            var color = "{{ $actuallyColor }}";
            document.getElementById('{{$shiftDay->id}}').style.background = color; 

        })
    
    function leftContextMenu(event){
            if(event.button){
                
                // document.getElementById("contextMenu").style.left =  500;//event.pageX;
                // document.getElementById("contextMenu").style.top =  400;//event.pageY;
                document.getElementById("contextMenu").style.setProperty('--mouse-x', event.clientX + 'px')
                document.getElementById("contextMenu").style.setProperty('--mouse-y', event.clientY + 'px')
                document.getElementById("contextMenu").style.display = "block";
            }
         }
    </script>
        
</div>
