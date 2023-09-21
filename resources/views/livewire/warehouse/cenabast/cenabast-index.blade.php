<div>

    <div class="row">
        <div class="col-md-9">
            <h3>Dtes de Cenabast</h3>
        </div>
        <div class="col-md-3 text-right">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Filtrar por</label>
                </div>
                <select wire:model="filter_by" id="filter-by" class="custom-select" required>
                    <option value="all">Todos</option>
                    <option value="without-attached">Sin adjuntar acta</option>
                    <option value="with-attached">Con acta adjuntada</option>
                </select>
            </div>
        </div>
    </div>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>
                    <input
                        type="text"
                        class="form-control"
                        wire:model.defer="otp"
                        placeholder="OTP"
                        width="100px"
                    >
                    <button
                        class="btn btn-sm btn-primary btn-block"
                        wire:click="signMultiple"
                    >
                        Firmar Varios
                    </button>
                </th>
                <th>ID</th>
                <th>Documento</th>
                <th>Bod</th>
                <th>Fecha Aceptación SII (días)</th>
                <th>Establecimiento</th>
                <th>Cargar Acta</th>
                <th class="text-center">Firma Farmaceutico</th>
                <th class="text-center">Firma Jefe</th>
                <th nowrap></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dtes as $dte)
                <tr>
                    <td width="120px" class="text-center">
                        @if(isset($dte->confirmation_signature_file) && !$dte->block_signature && !$dte->cenabast_signed_pharmacist && isset($dte->pharmacist) && $dte->pharmacist->id == auth()->id()

                        || isset($dte->confirmation_signature_file) && !$dte->block_signature && $dte->cenabast_signed_pharmacist && !$dte->cenabast_signed_boss && isset($dte->boss) && $dte->boss->id == auth()->id())
                            <input
                                type="checkbox"
                                style="scale: 1.1;"
                                id="selectedDte.{{ $dte->id }}"
                                wire:model.defer="selectedDte.{{ $dte->id }}"
                            >
                        @else
                            <input
                                type="checkbox"
                                style="scale: 1.1;"
                                disabled
                            >
                        @endif
                    </td>
                    <td>{{ $dte->id }}</td>
                    <td>
                        @if ($dte->tipo_documento != 'boleta_honorarios')
                            <a
                                href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $dte->uri }}"
                                target="_blank"
                                class="btn btn-sm mb-1 btn-outline-secondary"
                            >
                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                            </a>
                        @else
                            <a href="{{ $dte->uri }}" target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
                                <i class="fas fa-file-pdf text-danger"></i> {{ $dte->folio }}
                            </a>
                        @endif
                        <br>
                        {{ $dte->tipo_documento }}
                        <br>
                        {{ $dte->emisor }}
                    </td>
                    <td class="small">
                        @foreach ($dte->controls as $control)
                            <a
                                class="btn btn-sm btn-outline-primary"
                                href="{{ route('warehouse.control.show', $control) }}"
                                target="_blank"
                            >
                                #{{ $control->id }}
                            </a>
                        @endforeach
                    </td>
                    <td>
                        {{ $dte->fecha_recepcion_sii ?? '' }} <br>
                        ({{ $dte->fecha_recepcion_sii ? $dte->fecha_recepcion_sii->diffInDays(now()) : '' }} días)
                    </td>
                    <td>{{ $dte->establishment->name ?? '' }}</td>
                    <td>
                        @if(!isset($dte->confirmation_signature_file))
                            <form
                                action="{{ route('warehouse.cenabast.saveFile', ['dte' => $dte->id]) }}"
                                method="POST"
                                enctype="multipart/form-data"
                                class="form-control"
                            >
                                @csrf
                                <input type="file" name="acta_{{ $dte->id }}">
                                <button class="btn btn-primary btn-sm">Guardar</button>
                            </form>
                        @endif
                    </td>
                    <td class="text-center" nowrap>
                        @if(isset($dte->confirmation_signature_file) && !$dte->block_signature && !$dte->cenabast_signed_pharmacist && isset($dte->pharmacist) && $dte->pharmacist->id == auth()->id())
                            @livewire('sign.sign-to-document', [
                                'btn_title' => 'Firmar',
                                'btn_class' => 'btn btn-sm btn-success',
                                'btn_icon' => 'fas fa-signature',

                                'fileLink' => $dte->confirmation_signature_file_url,

                                'signer' => auth()->user(),
                                'position' => 'left',

                                'filename' => '/ionline/cenabast/signature/dte-' . $dte->id,

                                'callback' => 'warehouse.cenabast.callback',
                                'callbackParams' => [
                                    'dte' => $dte->id,
                                    'is_pharmacist' => true,
                                    'is_boss' => false,
                                    'cenabast_reception_file' => '/ionline/cenabast/signature/dte-' . $dte->id . '.pdf'
                                ],
                            ], $dte->id)
                        @elseif($dte->cenabast_signed_pharmacist)
                            <i class="fas fa-check text-success"></i> Firmado
                        @endif
                    </td>
                    <td class="text-center" nowrap>
                        @if($dte->cenabast_signed_pharmacist && !$dte->block_signature && !$dte->cenabast_signed_boss && isset($dte->boss) && $dte->boss->id == auth()->id())
                            @livewire('sign.sign-to-document', [
                                'btn_title' => 'Firmar',
                                'btn_class' => 'btn btn-sm btn-success',
                                'btn_icon' => 'fas fa-signature',

                                'fileLink' => $dte->cenabast_reception_file_url,

                                'signer' => auth()->user(),
                                'position' => 'right',

                                'filename' => '/ionline/cenabast/signature/dte-' . $dte->id,

                                'callback' => 'warehouse.cenabast.callback',
                                'callbackParams' => [
                                    'dte' => $dte->id,
                                    'is_pharmacist' => false,
                                    'is_boss' => true,
                                    'cenabast_reception_file' => '/ionline/cenabast/signature/dte-' . $dte->id . '.pdf'
                                ],
                            ], $dte->id)
                        @elseif($dte->cenabast_signed_boss)
                            <i class="fas fa-check text-success"></i> Firmado
                        @endif
                    </td>
                    <td class="text-center" nowrap>
                        @if (isset($dte->confirmation_signature_file) && !isset($dte->cenabast_reception_file))
                            <a
                                href="{{ route('warehouse.cenabast.downloadFile', ['dte' => $dte->id]) }}"
                                class="btn btn-sm btn-outline-success"
                                title="Descargar Acta Original"
                            >
                                <i class="fas fa-download"></i>
                            </a>
                        @elseif(isset($dte->cenabast_reception_file))
                            <a
                                class="btn btn-sm btn-success"
                                href="{{ route('warehouse.cenabast.download.signed', $dte) }}"
                                title="Descargar Acta Firmada"
                            >
                                <i class="fas fa-download"></i>
                            </a>
                        @endif

                        @if ($dte->confirmation_signature_file && !$dte->cenabast_signed_pharmacist && !$dte->cenabast_signed_boss)
                            <button
                                class="btn btn-sm btn-danger"
                                wire:click="deleteFile({{ $dte }})"
                                title="Borrar Acta"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="10">
                        <em>
                            No hay DTE que mostrar
                        </em>
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>

    {{ $dtes->links() }}

</div>
