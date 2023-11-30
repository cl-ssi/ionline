<div>
    <h3 class="mb-3">Documentos pendientes de numerar</h3>
    @include('documents.partes.partials.nav')

    <div class="alert alert-info"
        role="alert">
        <b>Importante:</b>
        Sólo funcionarios que tengan firma electrónica con propósito "iOnline" pueden numerar un documento.
    </div>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>id</th>
                <th>Tipo</th>
                <th>Asunto</th>
                <th>Autor</th>
                <th>Doc</th>
                <th>Número</th>
                <th>Fecha</th>
                <th>Doc</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($numerations as $numeration)
                <tr>
                    <td>{{ $numeration->id }}</td>
                    <td>{{ $numeration->type?->name }}</td>
                    <td>{{ $numeration->subject }}</td>
                    <td>{{ $numeration->user?->shortName }}</td>
                    <td>
                        <a href="{{ route('documents.partes.numeration.show_original', $numeration) }}">
                            Doc
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

                    <td>
                        @if ($numeration->number)
                            <a href="{{ route('documents.partes.numeration.show_numerated', $numeration) }}">
                                Doc
                            </a>
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
