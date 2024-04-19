<div>
    <button class="btn btn-sm btn-outline-warning" 
        wire:click="clean"  
        onclick="confirm('Esto limpiara el formato del documento y las tablas (el contenido del documento no será modificado)') || event.stopImmediatePropagation()"
        >Limpiar formato</button>
</div>
