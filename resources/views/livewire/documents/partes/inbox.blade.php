<div>
    @section('title', 'Bandeja de entrada')

    @include('documents.partes.partials.nav')

    <h3 class="mb-3">Bandeja de entrada</h3>

    <div class="form-row">
        <fieldset class="form-group col-1">
            <label for="for_id">ID</label>
            <input type="number" class="form-control" id="for_id" wire:model.defer="parte_id" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_type">Tipo</label>
            <select wire:model.defer="parte_type" id="for_type" class="form-control">
                <option></option>
                <option value="Carta">Carta</option>
                <option value="Circular">Circular</option>
                <option value="Decreto">Decreto</option>
                <option value="Demanda">Demanda</option>
                <option value="Informe">Informe</option>
                <option value="Memo">Memo</option>
                <option value="Oficio">Oficio</option>
                <option value="Ordinario">Ordinario</option>
                <option value="Otro">Otro</option>
                <option value="Permiso Gremial">Permiso Gremial</option>
                <option value="Reservado">Reservado</option>
                <option value="Resolucion">Resolución</option>
            </select>
        </fieldset>


        <fieldset class="form-group col-1">
            <label for="for_number">Número</label>
            <input type="number" class="form-control" id="for_number" wire:model.defer="parte_number" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_origin">Origen {{ session('parte_origin') }}</label>
            <input type="text" class="form-control" id="for_origin" wire:model.defer="parte_origin">
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_subject">Asunto</label>
            <input type="text" class="form-control" id="for_subject" wire:model.defer="parte_subject">
        </fieldset>

        <fieldset>
            <label for="">&nbsp;</label>
            <button type="submit" class="btn btn-primary form-control" wire:click="search">
                <i class="fas fa-search"></i>
            </button>
        </fieldset>

    </div>
    <div class="form-row">
        <div class="form-check">
            <label class="form-check-label">&nbsp;</label>
            <input type="checkbox" class="form-check-input" wire:model.defer="parte_without_sgr">
            Solo aquellos sin derivación
        </div>

        <div class="form-check">
            <label class="form-check-label">&nbsp;</label>
            <input type="checkbox" class="form-check-input" wire:model.defer="parte_important">
            Marcados como urgentes
        </div>
    </div>

    <h5 class="mt-3">
        @foreach(array('parte_id','parte_type','parte_number','parte_origin','parte_subject') as $filter)
            @if( session($filter) )
            <a href="#" class="badge badge-secondary" wire:click="removeFilter('{{$filter}}')">
                {{ session($filter) }} <i class="fas fa-trash text-light small"></i>
            </a>
            @endif
        @endforeach
        @if(session('parte_without_sgr'))
            <a href="#" class="badge badge-secondary" wire:click="removeFilter('parte_without_sgr')">
                Sin serivación <i class="fas fa-trash text-light small"></i>
            </a>
        @endif
        @if(session('parte_important'))
            <a href="#" class="badge badge-secondary" wire:click="removeFilter('parte_important')">
                Marcados como urgentes <i class="fas fa-trash text-light small"></i>
            </a>
        @endif
    </h5>

    <table class="table table-sm table-bordered table-striped" wire:loading.class="d-none">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ingreso</th>
                <th>Tipo</th>
                <th nowrap>Fecha Doc.</th>
                <th>Número</th>
                <th>Origen</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($partes as $parte)
            <tr>
                <td rowspan="2" class="text-center">{{ $parte->id }}</td>
                <td data-toggle="tooltip" data-placement="top"
                    data-original-title="{{ $parte->created_at }}">
                    <small>{{ $parte->entered_at }}</small>
                </td>
                <td>
                    {{ $parte->type }}
                    @if($parte->important)
                        <i class="fas fa-exclamation" style="color: red;"></i>
                    @endif
                </td>
                <td nowrap>{{ $parte->CreationParteDate }}</td>
                <td class="text-center">{{ $parte->number }}</td>
                <td>{{ $parte->origin }}</td>
                <td nowrap class="text-right">
                    @can('Partes: oficina')
                        @if($parte->created_at->diffInDays('now') <= 7)
                        <a class="btn btn-sm btn-primary" href="{{ route('documents.partes.edit', $parte) }}"
                            data-toggle="tooltip" data-placement="top"
                            data-original-title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endif
                    @endcan

                    @can('Partes: director')
                        <a class="btn btn-sm btn-{{ ($parte->requirements->count() >= 1)?'outline-':'' }}primary"
                            href="{{ route('requirements.create_requirement', $parte) }}"
                            data-toggle="tooltip" data-placement="top"
                            data-original-title="Crear Requerimiento (SGR)">
                            <i class="fas fa-rocket"></i>
                        </a>

                        @if($parte->viewed_at)
                            <button class="btn btn-sm btn-outline-dark"
                                data-toggle="tooltip" data-placement="top" readonly
                                data-original-title="{{ $parte->viewed_at }}">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        @else
                            <a class="btn btn-sm btn-primary" href="{{ route('documents.partes.view',$parte) }}"
                                data-toggle="tooltip" data-placement="top"
                                data-original-title="Visto">
                                <i class="fas fa-eye"></i></a>
                        @endif
                    @endcan
                </td>

            </tr>
            <tr>
                <td colspan="5" class="pb-3">{{ $parte->subject }}</td>
                <td class="text-center" nowrap>

                    @foreach( $parte->requirements as $req)
                        @if( Auth::user()->can('Partes: director'))
                        <a href="{{ route('requirements.show', $req) }}"
                            data-toggle="tooltip" data-placement="top"
                            data-original-title="N°: {{ $req->id }}">
                            <i class="fas fa-rocket"></i>
                        </a>

                        @elseif( Auth::user()->can('Partes: oficina'))
                            @if($req->events->count() > 0)

                                <span  data-toggle="tooltip" data-placement="top"
                                data-original-title="{{ optional($req->events->where('status', '<>', 'en copia')->first())->to_user_id }}
                                                    {{ ($req->events->where('status', '<>', 'en copia')->first()->to_user->fullname)??''}}
                                                    {{ optional($req->events->where('status', '<>', 'en copia')->first())->CreationDate }}">


                                <i class="fas fa-rocket"></i>
                                </span>
                            @endif
                        @endif
                    @endforeach

                    @if($parte->files->count()>0)
                        @foreach($parte->files as $file)
                        @if($file->signatureFile)
                        @if($file->signatureFile->HasAllFlowsSigned)
                            {{--<a href="https://storage.googleapis.com/{{env('APP_ENV') === 'production' ? 'saludiquique-storage' : 'saludiquique-dev'}}/{{$file->signatureFile->signed_file}}"  target="_blank" title="Documento Firmado">
                            <i class="fas fa-signature"></i>
                            </a>--}}

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
                <td colspan="7">
                    <em>
                        No se encontraron partes con los filtros selecionados
                    </em>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $partes->appends(request()->query())->links() }}

</div>
