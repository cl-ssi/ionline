<div style=" display: inline;">
    <button class="only-icon" wire:click="setJsFunc">
    	<i class="fa fa-eye" style="color:blue"></i>
    </button> 
	<script>
    	// Your JS here.
    	// dsocument.addEventListener('livewire:jsLiveWireTest', function () {

    	// });
    	document.addEventListener('livewire:load', function () {
    	// window.livewire.on('jsLiveWireTest', () => {
    		alert("alert desde livewire");
    		// lazyImagesInit();
		});
	</script>
</div>
    	

