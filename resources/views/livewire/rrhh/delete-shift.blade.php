<div class="modal fade "  wire:ignore.self id="deleteShiftModal" tabindex="-1" aria-labelledby="deleteShiftModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"  style="background-color:#006cb7;color:white   ">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar personal de turno actual</h5>
        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close" wire:click.prevent="clearDeleteModal()">x</button>
      </div>
      <div class="modal-body">
       
        <div class="row">
            <div class="col-md-6" style="font-size:10px;">Rut: 
                @if(isset($rutUser) && $rutUser!="") 
                    {{$rutUser}}
                @else
                    <i class="fas fa-spinner fa-pulse"></i>
                @endif
            </div>
            <div class="col-md-6" style="font-size:10px;">Nombre: 
            @if(isset($userName) && $userName!="") 
                {{$userName}}
            @else
                <i class="fas fa-spinner fa-pulse"></i>
            @endif
             </div>
        </div>
        
        <div class="row">

            <div class="col-md-6" style="font-size:10px;">Tipo de turno:
            @if(isset($actuallyShift) && $actuallyShift!="")
                {{$actuallyShift["name"]}}
            @else
                <i class="fas fa-spinner fa-pulse"></i>
            @endif
            </div>
            <div class="col-md-6" style="font-size:10px;">grupo: 
            @if(isset($actuallyGroup))
                {{(isset($actuallyGroup) && $actuallyGroup !="")?$actuallyGroup:"Sin Grupo"}}
            @else
                <i class="fas fa-spinner fa-pulse"></i>
            @endif    
            
            </div>

        </div>
        <br>
        @if($deleteAll == 0)
        <div class="row">
            <div class="col-md-6">
                Eliminar días desde:  
            </div>
            <div class="col-md-6">
                <input type="date" wire:model="startdate" class="form-control">
            </div>
           
        </div>
        <div class="row">
             <div class="col-md-6">
            Eliminar días hasta:
            </div>
            <div class="col-md-6">
                <input type="date" wire:model="enddate" class="form-control">
                
            </div>
        </div>
        @endif
         <div class="row">
            <div class="col-md-6">
                Eliminar turno completo
            </div>
            <div class="col-md-6">
                <input type="checkbox" wire:model="deleteAll">
            </div>
        </div>
        <div class="row">
             <div class="col-md-6">

           <b> TOTAL: </b><i>{{$cantDaysToDelete}}</i>      Días a eliminar
        </div>
        </div>

      </div>
      <div class="modal-footer">
        <button wire:click.prevent="clearDeleteModal()" type="button" class="btn btn-warning" data-dismiss="modal" >Cerrar</button>
        <button type="button" class="btn btn-danger">Confirmar</button>
      </div>
    </div>
  </div>
</div>