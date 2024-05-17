<div>
    <h3 class="mb-3">Documentos pendientes de numerar</h3>
    @include('documents.partes.partials.nav')

    <div class="alert alert-info"
        role="alert">
        <b>Importante:</b> Acá encontrará documentos generados por sistema que necesiten ser numerados. <br>
        Sólo funcionarios que tengan firma electrónica con propósito "iOnline" pueden numerar un documento.
    </div>

    @if($error_msg)
    <div class="alert alert-danger"
        role="alert">
        {{ $error_msg }}
    </div>
    @endif


    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>id</th>
                <th>Tipo</th>
                <th>Asunto</th>
                <th>Autor</th>
                <th>Original</th>
                <th>Número</th>
                <th>Fecha</th>
                <th>Numerado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($numerations as $numeration)
                <tr>
                    <td>{{ $numeration->id }}</td>
                    <td>{{ $numeration->type?->name }} {{ $numeration->numerable?->id }}</td>
                    <td>{{ $numeration->subject }}</td>
                    <td>{{ $numeration->user?->shortName }}</td>
                    <td class="text-center">
                        <a href="{{ route('documents.partes.numeration.show_original', $numeration) }}" target="_blank">
                            <i class="bi bi-filetype-pdf"></i>
                        </a>
                    </td>

                    <td>
                        @if ($numeration->number)
                            {{ $numeration->number }}
                        @else
                            <button class="btn btn-primary"  wire:loading.attr="disabled"
                                wire:click="numerate( {{ $numeration->id }} )">
                                <i class="fa fa-spinner fa-spin" wire:loading></i>
                                <i class="bi bi-123" wire:loading.class="d-none"></i> 
                            </button>
                        @endif
                    </td>

                    <td>{{ $numeration->date }}</td>

                    <td class="text-center">
                        @if ($numeration->number)
                            <a href="{{ route('documents.partes.numeration.show_numerated', $numeration) }}" target="_blank">
                                <i class="bi bi-file-pdf"></i> 
                            </a>
                        @endif
                    </td>
                    <td>
                        {{ $numeration->numerator?->initials }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $numerations->links()}}
</div>
