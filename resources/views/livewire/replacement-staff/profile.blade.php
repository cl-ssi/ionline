<div>
@if($replacementStaff)
    <div class="form-row">
        <fieldset class="form-group">
            <label for="">&nbsp;</label>
            <button class="btn text-white btn-info float-right" wire:click.prevent="add({{$i}})" @if($count>0) disabled @endif>Agregar <i class="fas fa-plus"></i></button>
        </fieldset>
    </div>

    <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.profile.store', $replacementStaff) }}" enctype="multipart/form-data">
        @csrf
        @method('POST')
        @foreach($inputs as $key => $value)
            <div class="form-row" wire:key="input-{{ $key }}">
                <fieldset class="form-group col mt">
                    <label for="for_profile">Estamento</label>
                    <select name="profile" class="form-control" wire:model.live="profileSelected" required>
                        <option value="">Seleccione</option>
                        @foreach($profiles as $profile)
                            <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                        @endforeach
                    </select>
                </fieldset>

                @if(!is_null($professions))
                <fieldset class="form-group col mt">
                    <label for="for_profession">Profesión</label>
                    <select name="profession" class="form-control" required>
                        <option value="" selected {{-- ($selectstate == '') ? 'selected':'' --}}>Seleccione</option>
                        @foreach($professions as $profession)
                            <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                        @endforeach
                    </select>
                </fieldset>
                @else
                <fieldset class="form-group col mt">
                    <label for="for_profession">Profesión</label>
                    <select name="profession" class="form-control" disabled required>
                        <option value="">Seleccione</option>
                    </select>
                </fieldset>
                @endif

                <fieldset class="form-group col mt">
                    <label for="for_profession">Experiencia</label>
                    <select name="experience" class="form-control" required {{ $selectstate }}>
                        <option value="" {{ ($selectstate == '')?'selected':'' }}>Seleccione</option>
                        <option value="managerial">Directivo</option>
                        <option value="administrative management">Gestión administrativa</option>
                        <option value="healthcare">Asistencial (clínica u hospitalaria)</option>
                        <option value="operations">Operaciones</option>
                    </select>
                </fieldset>
            </div>

            <div class="form-row" wire:key="input-{{ $key }}">
                <fieldset class="form-group col-sm-3">
                    <label for="for_degree_date">Fecha de Titulación</label>
                    <input type="date" class="form-control" min="1900-01-01" max="{{Carbon\Carbon::now()->toDateString()}}"
                        name="degree_date" required>
                </fieldset>

                <fieldset class="form-group col mt">
                    <div class="mb-3">
                      <label for="forFile" class="form-label">Título o Certificado de Escolaridad</label>
                      <input class="form-control" type="file" name="file"
                          accept="application/pdf" required>
                    </div>
                </fieldset>

                <fieldset class="form-group col-md-2">
                    <label for="for_button"><br></label>
                    <button class="btn btn-danger btn-block" wire:click.prevent="remove({{$key}})">Remover</button>
                </fieldset>

            </div>
            <hr>
        @endforeach
        
        @if($count>0)
            <button type="submit" class="btn btn-primary float-right">Guardar</button>
        @endif
    </form>
@else
    <div class="form-row">
        <fieldset class="form-group col mt">
            <label for="for_profile">Estamento</label>
            <select name="profile" class="form-control" wire:model.live="profileSelected" required>
                <option value="">Seleccione</option>
                @foreach($profiles as $profile)
                    <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                @endforeach
            </select>
        </fieldset>

        @if(!is_null($professions))
        <fieldset class="form-group col mt">
            <label for="for_profession">Profesión</label>
            <select name="profession" class="form-control" required>
                <option value="" selected>Seleccione</option>
                @foreach($professions as $profession)
                    <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                @endforeach
            </select>
        </fieldset>
        @else
        <fieldset class="form-group col mt">
            <label for="for_profession">Profesión</label>
            <select name="profession" class="form-control" required>
                <option value="">Seleccione</option>
            </select>
        </fieldset>
        @endif

        <fieldset class="form-group col mt">
            <label for="for_profession">Experiencia</label>
            <select name="experience" class="form-control" required {{ $selectstate }}>
                <option value="" {{ ($selectstate == '') ? 'selected':'' }}>Seleccione</option>
                <option value="managerial">Directivo</option>
                <option value="administrative management">Gestión administrativa</option>
                <option value="healthcare">Asistencial (clínica u hospitalaria)</option>
                <option value="operations">Operaciones</option>
            </select>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-sm-3">
            <label for="for_degree_date">Fecha de Titulación</label>
            <input type="date" class="form-control" min="1900-01-01" max="{{Carbon\Carbon::now()->toDateString()}}"
                name="degree_date" required>
        </fieldset>

        <fieldset class="form-group col mt">
            <div class="mb-3">
              <label for="forFile" class="form-label">Título o Certificado de Escolaridad</label>
              <input class="form-control" type="file" name="file"
                  accept="application/pdf" required>
            </div>
        </fieldset>
    </div>
@endif
</div>
