<div>
    @section('title', 'Bandeja de entrada')

    @include('documents.partes.partials.nav')

    <h3 class="mb-3">Bandeja de entrada</h3>

    <div class="form-row">        

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_correlative">Correlativo</label>
            <input type="number" class="form-control" id="for_correlative" wire:model="parte_correlative" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_type_id">Tipo</label>
            <select wire:model="parte_type_id" id="for_type_id" class="form-control">
                <option></option>
                @foreach($types as $id => $type)
                    <option value="{{ $id }}">{{ $type }}</option>
                @endforeach
            </select>
        </fieldset>


        <fieldset class="form-group col-6 col-md-2">
            <label for="for_number">Número</label>
            <input type="number" class="form-control" id="for_number" wire:model="parte_number" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_origin">Origen {{ session('parte_origin') }}</label>
            <input type="text" class="form-control" id="for_origin" wire:model="parte_origin">
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_subject">Asunto</label>
            <input type="text" class="form-control" id="for_subject" wire:model="parte_subject">
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
            <input type="checkbox" class="form-check-input" wire:model="parte_without_sgr">
            Solo aquellos sin derivación
        </div>

        <div class="form-check">
            <label class="form-check-label">&nbsp;</label>
            <input type="checkbox" class="form-check-input" wire:model="parte_important">
            Marcados como urgentes
        </div>
    </div>

    <h5 class="mt-3">
        @foreach(array('parte_correlative','parte_type','parte_number','parte_origin','parte_subject') as $filter)
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

    <div class="text-center" wire:loading>
        <i class="fas fa-spinner fa-spin fa-2x"></i>
    </div>

    <table class="table table-sm table-bordered table-striped" wire:loading.class="d-none">
        <thead>
            <tr>
                <th>Correlativo</th>
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
                <td rowspan="2" class="text-center">{{ $parte->correlative??'' }}</td>
                <td data-toggle="tooltip" data-placement="top"
                    data-original-title="{{ $parte->created_at }}">
                    <small>{{ $parte->entered_at }}</small>
                </td>
                <td>
                    @if($parte->reserved)
                        <i class="fas fa-user-secret"></i>
                    @endif
                    @if($parte->important)
                        <i class="fas fa-exclamation"></i>
                    @endif
                    {{ $parte->type->name }}
                </td>
                <td nowrap>{{ optional($parte->date)->format('d-m-Y') }}</td>
                <td class="text-center">{{ $parte->number }}</td>
                <td>{{ $parte->origin }}</td>
                <td nowrap class="text-right">
                    @can('Partes: oficina')
                        @if($parte->created_at->diffInDays(now()) <= 7)
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

                        @if( auth()->user()->can('Partes: director'))

                            @if($req->unreadedEvents)
                                <a href="{{ route('requirements.show',$req->id) }}" 
                                    class="btn btn-sm {{ $req->unreadedEvents ? 'btn-success':'btn-outline-primary' }}"
                                    data-toggle="tooltip" data-placement="top"
                                    data-original-title="N°: {{ $req->id }}">
                                    @if($req->unreadedEvents)
                                    <i class="fas fa-fw fa-envelope"></i> <span class='badge badge-secondary'>{{ $req->unreadedEvents }}</span>
                                    @else
                                    <i class="fas fa-fw fa-edit"></i>
                                    @endif
                                </a>
                            @else
                                <a href="{{ route('requirements.show', $req) }}"
                                    data-toggle="tooltip" data-placement="top"
                                    data-original-title="N°: {{ $req->id }}">
                                    <i class="fas fa-rocket"></i>
                                </a>
                            @endif

                        @elseif( auth()->user()->can('Partes: oficina'))
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

                    @if($parte->signaturesFile)

                        <a href="{{ route('documents.signatures.showPdf',[$parte->signatures_file_id, time()])}}"
                            target="_blank" title="Documento firmado">
                            <i class="fas fa-signature"></i>
                        </a>

                    @endif

                    @if($parte->files->count()>0)
                        @foreach($parte->files as $file)
                        
                            <a href="{{ route('documents.partes.download', $file->id) }}"
                                target="_blank"
                                data-toggle="tooltip" data-placement="top"
                                data-original-title="{{ $file->name }} ">
                                <i class="fas fa-paperclip"></i>
                            </a>

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

    <div wire:loading.class="d-none">
        {{ $partes->appends(request()->query())->links() }}
    </div>

</div>
