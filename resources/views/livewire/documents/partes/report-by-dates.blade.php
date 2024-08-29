<div>
    @section('title', 'Partes')

    @include('documents.partes.partials.nav')

    <h3 class="mb-3">Buscar por fecha de ingreso</h3>

    @canany(['Partes: oficina'])
        <div class="form-row">
            <fieldset class="col-md-3 col-5">
                <label for="start_at" class="form-label">
                    {{ __('Fecha Inicio') }}
                </label>

                <input wire:model="start_at" type="date" id="start_at"
                    class="form-control @error('start_at') is-invalid @enderror"
                    value="{{ old('start_at')}}"
                    autocomplete="start_at" required>

                @error('start_at')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>

            <fieldset class="col-md-3 col-5">
                <label for="end_at" class="form-label">
                    {{ __('Fecha Término') }}
                </label>

                <input wire:model="end_at" type="date" id="end_at"
                    class="form-control @error('end_at') is-invalid @enderror"
                    value="{{ old('end_at') }}"
                    autocomplete="end_at" required>

                @error('end_at')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </fieldset>

            <fieldset class="col-md-1 col-1">
                <label for="btn-search">Buscar</label>
                <button class="btn btn-primary" wire:click="filter()">Buscar</button>
            </fieldset>
        </div>
    @endcanany

    <hr>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>id</th>
                <th>Ingreso</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Numero</th>
                <th>Origen</th>
                <th>Asunto</th>
                <th>Archivos</th>
            </tr>
        </thead>
        <tbody>
            @forelse($partes as $parte)
            <tr>
                <td>{{ $parte->correlative }}</td>
                <td>
                    <small title="{{ $parte->created_at }}">
                        {{ $parte->entered_at }}
                    </small>
                </td>
                <td>
                    {{ optional($parte->type)->name }}
                    @if($parte->important)
                        <i class="fas fa-exclamation" style="color: red;"></i>
                    @endif
                </td>
                <td>{{ optional($parte->date)->format('Y-m-d') }}</td>
                <td class="text-center">{{ $parte->number }}</td>
                <td>{{ $parte->origin }}</td>
                <td>{{ $parte->subject }}</td>
                <td>
                    @if($parte->files->count() > 0)
                        @foreach($parte->files as $file)
                            @if($file->signatureFile)
                                @if($file->signatureFile->HasAllFlowsSigned)
                                    <a href="{{ route('documents.signatures.showPdf',[$file->signatureFile->id, time()])}}"
                                        target="_blank" title="Documento firmado">
                                        <i class="fas fa-signature"></i>
                                    </a>

                                @else
                                    Firmas Pend.
                                @endif
                            @else
                                <a href="{{ route('documents.partes.download', $file->id) }}"
                                    target="_blank"
                                    data-toggle="tooltip" data-placement="top"
                                    data-original-title="{{ $file->name }} ">
                                    <i class="fas fa-paperclip"></i>
                                </a>
                            @endif
                        @endforeach
                    @endif

                    @if($parte->physical_format)
                        <i class="fas fa-folder" title="Parte requiere documento físico al derivar"></i>
                    @endif
                </td>
            </tr>
            @empty
            <tr class="text-center">
                <td colspan="8">No hay registros</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $partes->links() }}

</div>