<div>
    <button class="btn btn-sm btn-warning mb-2" 
        wire:click="clean"  
        onclick="confirm('Guarde su documento antes de ejecutar esta opción, que limpiara el formato del documento y las tablas (el contenido del documento no será modificado)') || event.stopImmediatePropagation()"
        >Limpiar formatos</button>

        <span class="d-inline text-danger"><strong> Guarde su documento antes de presionar este botón</strong></span>
</div>
