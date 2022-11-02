<div>
    <h6><i class="fas fa-paperclip"></i> Archivos Adjuntos</h6>
    <br>

    @if($allowance && $allowance->files->count() > 0)
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover">
                <thead>
                    <tr class="text-center">
                        <th style="width: 18%">Fecha Creación</th>
                        <th>Nombre</th>
                        <th>Adjunto por</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allowance->files as $file)
                    <tr>
                        <td>{{ $file->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $file->name }}</td>
                        <td>{{ $file->user->TinnyName }}</td>
                        <td style="width: 8%">
                            <a class="btn btn-primary form-control" href="{{ route('allowances.file.show', $file) }}" 
                                target="_blank"> <i class="fas fa-paperclip"></i>
                            </a>
                        </td>
                        <td style="width: 8%">
                            <a class="btn btn-danger form-control" 
                                wire:click="destroy({{ $file }})"
                                onclick="return confirm('¿Está seguro que desea eliminar el Archivo Adjunto? (Perderas todos los cambios no guardados)')">
                                    <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="form-row">
        <fieldset class="form-group">
            <label for="">&nbsp;</label>
            <button class="btn text-white btn-info float-right" wire:click.prevent="add({{ $i }})">Agregar <i class="fas fa-plus"></i></button>
        </fieldset>
    </div>

    @foreach($inputs as $key => $value)
        <div class="form-row">
            <fieldset class="form-group col mt">
                <fieldset class="form-group">
                    <label for="for_name">Nombre Archivo</label>
                    <input type="text" class="form-control" name="name[]" required>
                </fieldset>
            </fieldset>

            <fieldset class="form-group col mt">
                <div class="mb-3">
                    <label for="forFile" class="form-label"><br></label>
                    <input class="form-control" type="file" name="file[]" accept="application/pdf" required>
                </div>
            </fieldset>

            <fieldset class="form-group col-md-2">
                <label for="for_button"><br></label>
                <button class="btn btn-danger btn-block" wire:click.prevent="remove({{ $key }})">Remover</button>
            </fieldset>
        </div>
        <hr>
        @endforeach

    {{-- @if($count>0)
    <button type="submit" class="btn btn-primary float-right">Guardar</button>
    @endif --}}
</div>
