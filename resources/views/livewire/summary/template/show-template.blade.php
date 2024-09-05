<div>
    <div class="d-print-none">

        @foreach($template->fields as $name => $type)
        <div class="form-group">
            <label for="exampleInputEmail1">{{ $name }}</label>
            <input type="text" 
            class="form-control" 
            id="for-{{$name}}"
            wire:model="template.{{$name}}">
        </div>
        @endforeach
        <button class="btn btn-secondary" wire:click="generate" >Generar</button>
        <button class="btn btn-secondary" onclick="window.print()" >Imprimir</button>
        
        <hr>
    </div>

    @include('summary.templates.'.$template->name)
</div>
