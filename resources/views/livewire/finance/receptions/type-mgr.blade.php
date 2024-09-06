<div>
    @section('title', 'Tipo de Actas')


    @include('finance.receptions.partials.nav')

    @if (session()->has('message'))
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
    @endif






    @if ($formActive )
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
                <button class="btn btn-success float-right" wire:click="showForm()">
                    <i class="fas fa-plus"></i> Nuevo Tipo de Acta
                </button>
            </div>
        </div>
        <br>

        @include('finance.receptions.type.index')
    @endif
</div>
