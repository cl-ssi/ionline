<div>
    <!-- Muestra como título el nombre de la OU y el selector de mes -->
    <div class="form-row mb-4">
        <div class="col-12 col-md-9">
            <h4>
                {{ $organizationalUnit->name }}
            </h4>
        </div>
        <div class="col-6 col-md-3">
            <input class="form-control" type="month" wire:model="monthSelection">
        </div>
    </div>

    <!-- Muestra el form para editar una autoridad -->
    @if($editForm)
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Editar autoridad para la fecha {{ $date }} y tipo {{ $type }}</h5>
            <div class="form-row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Usuario*</label>
                        <select name="subrogation" wire:model="user_id" class="form-control" required>
                            <option value="">Seleccionar Subrogante</option>
                            @foreach($subrogations as $subrogation)
                            <option value="{{ $subrogation->user_id }}">{{ $subrogation->user->tinnyName }} ({{$subrogation->type}})</option>
                            @endforeach
                        </select>
                        @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="">En representación de (opcional)</label>
                        <input type="text" class="form-control">
                        @error('xxx') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-4 col-md-2">
                    <div class="form-group">
                        <label for="">Desde*</label>
                        <input type="date" wire:model="startDate" class="form-control" disabled required>
                        @error('startDate') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-4 col-md-2">
                    <div class="form-group">
                        <label for="">Hasta*</label>
                        <input type="date" wire:model="endDate" class="form-control" required>
                        @error('endDate') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-4 col-md-3">
                    <div class="form-group">
                        <label for="Cargo">Cargo*</label>
                        <select wire:model="position" id="for_position" class="form-control" required>
                            <option value=""></option>
                            <option>Director</option>
                            <option>Directora</option>
                            <option>Director (S)</option>
                            <option>Directora (S)</option>
                            <option>Subdirector</option>
                            <option>Subdirectora</option>
                            <option>Subdirector (S)</option>
                            <option>Subdirectora (S)</option>
                            <option>Jefe</option>
                            <option>Jefa</option>
                            <option>Jefe (S)</option>
                            <option>Jefa (S)</option>
                            <option>Encargado</option>
                            <option>Encargada</option>
                            <option>Encargado (S)</option>
                            <option>Encargada (S)</option>
                            <option>Secretario</option>
                            <option>Secretaria</option>
                            <option>Secretario (S)</option>
                            <option>Secretaria (S)</option>
                        </select>
                        @error('position') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-12 col-md-12">
                    <div class="form-group">
                        <label for="">Decreto</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-primary form-control" wire:click="save()">
                            <i class="fas fa-save"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Mensaje de éxito -->
    @include('layouts.partials.flash_message')


    <!-- Muestra el nombre del mes seleccionado (Ej: Febrero 2023) -->
    <h5 clas="mb-3">
        {{ ucfirst($startOfMonth->monthName) }} de {{ $startOfMonth->year }}
    </h5>

    <!-- Rellena con cuadros en blanco para cuando el mes no comienza en el primer cuadro -->
    @for($i = 1; $i < $startOfMonth->dayOfWeek; $i++)
        <div class="dia_calendario small p-2 text-center border-white"></div>
    @endfor

    <!-- Muestra el calendario -->
    @foreach($data as $date => $authority)
        <div class="dia_calendario small p-2 text-center {{ ($today == $date) ? 'border-primary' : '' }}">

            <span class="{{ ($authority['holiday'] OR $authority['date']->dayOfWeek == 0) ? 'text-danger': '' }}">
                {{ $date }}
            </span>


            <hr class="mt-1 mb-1">
            {{ optional($authority['manager'])->tinnyName }}
            <a href="#" class="link-primary" wire:click="edit('{{ $date }}','manager')">
               <i class="fas fa-edit"></i>
            </a>
            <br>
            <em class="text-muted">{{ optional($authority['manager'])->position }}</em>


            <hr class="mt-1 mb-1">
            {{ optional($authority['secretary'])->tinnyName }}
            <a href="#" class="link-primary" wire:click="edit('{{ $date }}','secretary')">
               <i class="fas fa-edit"></i>
            </a>
            <br>
            <em class="text-muted">{{ optional($authority['secretary'])->position }}</em>

        </div>
    @endforeach


    <!-- CSS Custom para el calendario -->
    @section('custom_css')
    <style media="screen">
        .dia_calendario {
            display: inline-block;
            border: solid 1px rgb(0, 0, 0, 0.125);
            border-radius: 0.25rem;
            width: 13.9%;
            /* width: 154px; */
            text-align: center;
            margin-bottom: 5px;
        }
    </style>
    @endsection
</div>