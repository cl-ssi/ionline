<div>
@include('welfare.nav')

    <h5>Turnos</h5>

    <div class="container">
        <div class="row">
            <div class="col-md">
                    <label class="form-label">Funcionario</label>
                    @livewire('search-select-user', ['selected_id' => 'user_id', 
                                                     'emit_name' => 'emit_user_id',
                                                     'required' => 'required'])
            </div>
            <div class="col-md-2">
                <label class="form-label">Año</label>
                <select class="form-control" wire:model.live="year" required>
                    <option value=""></option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                </select>
                @error('year') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-2">
                <label class="form-label">Mes</label>
                <select class="form-control" wire:model.live="month" required>
                    <option value=""></option>
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
                @error('month') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col">
                <label class="form-label">Cantidad</label>
                <input type="text" class="form-control" wire:model.live="quantity" required>
                @error('quantity') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col">
                <labe class="form-label">Observación</label>
                <input type="text" class="form-control" wire:model.live="observation">
                @error('observation') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col-1">
                <label class="form-label"><br></label>
                <button class="form-control btn btn-primary" type="button" wire:click="save()">
                        <i class="fas fa-save"></i>
                </button>
            </div>
        </div>
    </div>

    <hr>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <table class="table table-bordered table-sm" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>#</th>
                <th>Run</th>
                <th>Nombre</th>
                <th>Año</th>
                <th>Mes</th>
                <th>Cantidad</th>
                <th>Observación</th>
            </tr>
        </thead>
        <tbody>
            @if($shifts)
                @foreach ($shifts as $shift)
                <tr>
                    <td>{{ $shift->id}}</td>
                    <td>{{ $shift->user->runFormat }}</td>
                    <td>{{ $shift->user->shortName }}</td>
                    <td>{{ $shift->year }}</td>
                    <td>{{ $shift->monthName() }}</td>
                    <td>{{ $shift->quantity }}</td>
                    <td>{{ $shift->observation }}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" type="button" wire:click="delete({{$shift}})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    
</div>
