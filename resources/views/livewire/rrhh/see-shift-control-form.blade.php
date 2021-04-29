<div style=" display: inline;">
    <button class="only-icon" wire:click="setJsFunc" data-toggle="modal" data-target="#shiftcontrolformmodal"  data-keyboard= "false" data-backdrop= "static" >
    	<i class="fa fa-eye" style="color:blue"></i>
    </button> 


<div   wire:ignore.self class="modal fade" id="shiftcontrolformmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document" >

       <div class="modal-content" >

            <div class="modal-header" style="background-color:#006cb7;color:white   ">

                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-clock"></i> Control de Turnos de personal </h5>

                <button type="button" class="close" data-dismiss="modal" wire:click.prevent="cancel()" aria-label="Close">

                    <span aria-hidden="true">×</span>

                </button>

            </div>

            <div class="modal-body">
                
                

            </div>

            <div class="modal-footer">

                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                <button type="button" wire:click.prevent="cancel()" class="btn btn-primary" data-dismiss="modal">Descargar <i class="fa fa-download "></i>
                </button>
            </div>

       </div>

    </div>

</div>	
	<script>
    	// Your JS here.
    	// dsocument.addEventListener('livewire:jsLiveWireTest', function () {

    	// });

  //   	document.addEventListener('livewire:load', function () {
  //   	// window.livewire.on('jsLiveWireTest', () => {
  //   		alert("alert desde livewire");
  //   		// lazyImagesInit();
		// });
	</script>
</div>
    	