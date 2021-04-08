<div>
    {{-- Success is as dangerous as failure. --}}
    Ingrese Data - Delay 1 seg.
    <br>
    <input wire:model.debounce.1ms="valor1" type="text">
    <h3>{{$valor1}}</h3>
    <input wire:model.debounce.1ms="valor2" type="text">
    <h3>{{$valor2}}</h3>
    <h3>Resultado: {{$suma}}</h3>
    <br>
</div>
