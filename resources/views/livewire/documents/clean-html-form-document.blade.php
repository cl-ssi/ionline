<div>
    <button class="btn btn-sm btn-outline-warning" 
        wire:click="clean"  
        onclick="confirm('Guarde su documento antes de ejecutar esta opción, que limpiara el formato del documento y las tablas (el contenido del documento no será modificado)') || event.stopImmediatePropagation()"
        >Limpiar formato</button>
</div>
