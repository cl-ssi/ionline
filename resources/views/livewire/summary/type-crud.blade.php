<div>
    @include('summary.nav')

    <div class="row">
        <div class="col">
            <h3 class="mb-3">Listado de Tipos de Procesos</h3>
        </div>
        <div class="col text-end">
            <button wire:click="create()" class="btn btn-success">Crear Nuevo Proceso</button>
        </div>
    </div>

    @if ($isOpen)
        @include('livewire.summary.create')
    @endif

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($types as $type)
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>{{ $type->name }}</td>
                    <td>
                        <button wire:click="edit({{ $type->id }})" class="btn btn-sm btn-primary">Editar</button>
                        <button wire:click="delete({{ $type->id }})" class="btn btn-sm btn-danger">Borrar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @push('scripts')
        <script>
            document.addEventListener('livewire:init', function() {
                Livewire.on('openModal', () => {
                    var myModal = new bootstrap.Modal(document.getElementById('formModal'), {
                        keyboard: false // Desactiva cerrar el modal con la tecla Esc
                    });
                    myModal.show();
                });

                Livewire.on('closeModal', () => {
                    var myModalEl = document.getElementById('formModal');
                    var modal = bootstrap.Modal.getInstance(myModalEl);
                    if (modal) {
                        modal.hide();
                    }
                });
            });
        </script>
    @endpush

</div>
