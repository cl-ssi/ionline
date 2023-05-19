<div>
    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Nro.</th>
                    <th>Fecha</th>
                    <th class="text-center">Archivo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventory->dtes as $dte)
                    <tr>
                        <td>
                            {{ $dte->folio }}
                        </td>
                        <td>
                            {{ $dte->emision }}
                        </td>
                        <td class="text-center">
                            <a
                                href="{{ $dte->uri }}"
                                class="btn btn-sm btn-outline-secondary"
                                target="_blank"
                                title="Ver archivo"
                            >
                                <span class="fas fa-file" aria-hidden="true"></span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="3">
                            <em>No hay resultados</em>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
