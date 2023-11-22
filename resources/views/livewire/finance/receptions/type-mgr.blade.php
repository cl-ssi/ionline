<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    @section('title', 'Tipo de Actas')
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ active('finance.receptions.create') }}"
                aria-current="page"
                href="{{ route('finance.receptions.create') }}">Con Orden de Compra</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
                href="#">Sin Orden de Compra</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ active('finance.receptions.type') }}"
                href="{{ route('finance.receptions.type') }}">Tipos de Acta</a>
        </li>
    </ul>



    @if ($form)
        <h3>{{ $type->id ? 'Editar' : 'Crear' }} Tipo de Acta</h3>
        @include('finance.receptions.type.form')
        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="button" class="btn btn-success" wire:click="save()">Guardar</button>
                <button type="button" class="btn btn-outline-secondary" wire:click="index()">Cancelar</button>
            </div>
        </div>

    @else

        <div class="form-row">
            <div class="col">
                <h3 class="mb-3">Listado de Tipo de Acta</h3>
            </div>
            <div class="col text-end">
                <button class="btn btn-success float-right" wire:click="form()">
                    <i class="fas fa-plus"></i> Nuevo Tipo de Acta
                </button>
            </div>
        </div>
        <br>

        @include('finance.receptions.type.index')
    @endif
</div>
