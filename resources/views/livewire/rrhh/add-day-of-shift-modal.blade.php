<div class="modal fade "  wire:ignore.self id="addShiftDayModal" tabindex="-1" aria-labelledby="addShiftDayModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"  style="background-color:#006cb7;color:white   ">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Agregar Jornada a personal</h5>
        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close" wire:click.prevent="clearAddModal()">x</button>
      </div>
      <div class="modal-body">
        @if(isset($shiftDay)  )
            <b>Agregando día {{json_encode($day)}} a {{ $shiftDay->user->name }} {{ $shiftDay->user->fathers_family }}</b>
        @endif
        
        <div wire:loading >
            <i class="fas fa-spinner fa-pulse"></i>
        </div>
        
        <br>
        <label>Tipo de jornada a agregar:</label>
        <select class="form-control" wire:model="journalType">
            <option value="L">L - Largo</option>
            <option value="N">N - Noche</option>
            <option value="D">D - Diurno</option>
            <option value="F">F - Libre</option>
            <option value="MD">MD - Media Jornada Diurna</option>
            <option value="MN">MN - Media Jornada Nocturna</option>
        </select>
      </div>
      <div class="modal-footer">
        <button wire:click.prevent="clearAddModal()" type="button" class="btn" data-dismiss="modal" >Cerrar</button>
        <button type="button" class="btn btn-info" wire:click.prevent="confirmAddDay">Agregar</button>
      </div>
    </div>
  </div>
</div>
