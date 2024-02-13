<div>
    @include('documents.partials.nav')

    <h3 class="mb-3">
        <div class="doc-digital">&nbsp;</div> DocDigital - Creados ({{ $count }})
    </h3>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Folio</th>
                <th>Materia</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Destinatarios</th>
                <th>Creador</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documents as $document)
            <tr>
                <td> {{ $document['documento_principal']['documento_id'] }} </td>
                <td> {{ $document['documento_principal']['folio'] }} </td>
                <td> {{ $document['documento_principal']['materia'] }} </td>
                <td> {{ $document['documento_principal']['tipo'] }} </td>
                <td> {{ $document['documento_principal']['fechaCreacion'] }} </td>
                <td>
                    <ul>
                        @if(is_array($document['destinatarios']['usuarios_destinatarios']) )
                            @foreach ($document['destinatarios']['usuarios_destinatarios'] as $destinatario)
                            <li>{{ $destinatario['usuario_nombre'] }}</li>
                            @endforeach
                        @endif
                    </ul>
                </td>
                <td>
                    {{ $document['info_creador']['usuario_nombre'] }}
                </td>
                <td>
                    <a href="{{ route('documents.docdigital.documentos.archivo', [$document['documento_principal']['documento_id'], $document['documento_principal']['id']]) }}" target="_blank">
                        <i class="bi bi-link"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-danger text-center">
        {{ $this->error }}
    </div>
</div>
