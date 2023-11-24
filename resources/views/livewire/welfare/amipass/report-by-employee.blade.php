<div>
    @include('welfare.nav')

    <h4>Reporte Amipass por funcionario</h4>

    <div class="form-row">
        <div class="form-group col-3">
            <label for="text11">Funcionario</label>
            
        </div>
        <div class="form-group">
            <label for="text12"><br></label>
            <div wire:loading.remove>
                <button wire:click="search" type="button" class="form-control btn btn-primary">Generar</button>
            </div>
            <div wire:loading.delay class="z-50 static flex fixed left-0 top-0 bottom-0 w-full bg-gray-400 bg-opacity-50">
                <img src="https://paladins-draft.com/img/circle_loading.gif" width="64" height="64" class="m-auto mt-1/4">
            </div>

        </div>
    </div>

</div>
