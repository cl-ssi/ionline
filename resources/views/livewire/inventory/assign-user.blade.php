<div class="container my-4">
    <div class="row">
        <div class="col-md-12">
            @if ($userType === 'admin')
                @include('inventory.nav', ['establishment' => $establishment])
            @else
                @include('inventory.nav-user')
            @endif
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Detalles del Inventario</h2>
                </div>
                <div class="card-body">
                    @if(session()->has('message-error'))
                        <div class="alert alert-danger">
                            {{ session('message-error') }}
                        </div>
                    @endif

                    <p><strong>Nro. Inv.:</strong> {{ $inventory->number }}</p>
                    <p><strong>Nro. Ant.:</strong> {{ $inventory->old_number }}</p>
                    <p><strong>Producto/Especie.:</strong> {{ $inventory->old_number }}</p>
                    <p><strong>Std:</strong> {{ $inventory->description }}</p>
                    <p><strong>Bodega:</strong> </p>
                    <p><strong>Ubicación:</strong> {{ $inventory->location }}</p>
                    <p><strong>Fecha de Adquisición:</strong> {{ $inventory->acquisition_date }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Asignar Usuario al Producto</h3>
                </div>
                <div class="card-body">
                    <fieldset>
                        <label for="user-using-id" class="form-label">Usuario a Agregar para el Producto</label>
                        @livewire('users.search-user', [
                            'smallInput' => true,
                            'placeholder' => 'Ingrese un nombre',
                            'eventName' => 'setUserId',
                            'bt' => 5,
                        ])

                        <input class="form-control @error('user_using_id') is-invalid @enderror" type="hidden">

                        @error('user_using_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>

                    <button wire:click="assignUser" class="btn btn-primary mt-3">Asignar Usuario</button>
                </div>
            </div>
        </div>
    </div>
</div>
