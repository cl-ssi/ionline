<div>

    <h3 class="mb-3">Dtes de Cenabast</h3>

    <div class="form-row">
        <div class="col-md-4">
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="filter-by">
                        Filtrar por
                    </label>
                </div>
                <select wire:model.defer="filter_by" id="filter-by" class="custom-select" required>
                    <option value="all">Todos</option>
                    <option value="without-attached">Sin adjuntar acta</option>
                    <option value="with-attached">Con acta adjuntada</option>
                </select>
            </div>

        </div>
        <div class="col-md-4">
            <div class="input-group mb-4">
                <select wire:model.defer="filter_by_signature" id="filter-by" class="custom-select" required>
                    <option value="">Todos</option>
                    <option value="without-pharmacist">Pendiente Farmaceutico</option>
                    <option value="without-boss">Pendiente Jefe</option>
                    <option value="with-pharmacist-without-boss">Aprobado Farmaceutico Pendiente Jefe</option>
                </select>
            </div>
        </div>

        <div class="col-md-1">
            <input type="text" class="form-control" name="id" wire:model.defer="filter.id" placeholder="id"
                value="{{ old('id') }}" autocomplete="off">
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control" name="folio" wire:model.defer="filter.folio"
                placeholder="folio" value="{{ old('folio') }}" autocomplete="off">
        </div>
        <div class="col-md-1">
            <butoon class="btn btn-outline-secondary" wire:click="getCenabast">Buscar</button>
        </div>
    </div>

    <div class="text-center d-none" wire:loading.class.remove="d-none">
        <i class="fas fa-spinner fa-spin"></i>
    </div>

    <table class="table table-sm table-bordered" wire:loading.class="d-none">
        <thead>
            <tr>
                <th>
                    <input type="text" class="form-control" wire:model.defer="otp" placeholder="OTP"
                        width="100px">
                    <button class="btn btn-sm btn-primary btn-block" wire:click="signMultiple">
                        Firmar Varios
                    </button>
                </th>
                <th>ID</th>
                <th>Estb.</th>
                <th>Documento</th>
                <th>Bod</th>
                <th>Fecha Aceptación SII (días)</th>
                <th>Cargar Acta</th>
                <th class="text-center">Firma Farmaceutico</th>
                <th class="text-center">Firma Jefe</th>
                <th nowrap>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dtes as $dte)
                <tr>
                    <td width="120px" class="text-center">
                        @if (
                            (isset($dte->confirmation_signature_file) &&
                                !$dte->block_signature &&
                                !$dte->cenabast_signed_pharmacist &&
                                isset($dte->pharmacist) &&
                                $dte->pharmacist->id == auth()->id()) ||
                                (isset($dte->confirmation_signature_file) &&
                                    !$dte->block_signature &&
                                    $dte->cenabast_signed_pharmacist &&
                                    !$dte->cenabast_signed_boss &&
                                    isset($dte->boss) &&
                                    $dte->boss->id == auth()->id()))
                            <input type="checkbox" style="scale: 1.1;" id="selectedDte.{{ $dte->id }}"
                                wire:model.defer="selectedDte.{{ $dte->id }}">
                        @else
                            <input type="checkbox" style="scale: 1.1;" disabled>
                        @endif
                    </td>
                    <td>{{ $dte->id }}</td>
                    <td>{{ $dte->establishment->alias ?? '' }}</td>
                    <td>
                        @if ($dte->tipo_documento != 'boleta_honorarios')
                            <a href="http://dipres2303.acepta.com/ca4webv3/PdfView?url={{ $dte->uri }}"
                                target="_blank" class="btn btn-sm mb-1 btn-outline-secondary">
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
                            <a class="btn btn-sm btn-outline-primary"
                                href="{{ route('warehouse.control.show', $control) }}" target="_blank">
                                #{{ $control->id }}
                            </a>
                        @endforeach
                    </td>
                    <td>
                        {{ $dte->fecha_recepcion_sii ?? '' }} <br>
                        ({{ $dte->fecha_recepcion_sii ? $dte->fecha_recepcion_sii->diffInDays(now()) : '' }} días)
                    </td>
                    <td width="300">
                        @if (!isset($dte->confirmation_signature_file))
                            <form action="{{ route('warehouse.cenabast.saveFile', ['dte' => $dte->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="acta_{{ $dte->id }}" class="custom-file-input"
                                            id="for-file-{{ $dte->id }}" accept=".pdf">
                                        <label class="custom-file-label" for="for-file"
                                            wire:model.defer="formFile.{{ $dte->id }}"
                                            data-browse="Examinar"></label>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit" id="for-upload-button">
                                            <i class="fas fa-upload"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif

                        @canany(['be god', 'Payments: cenabast bypass'])
                        @if (($dte->confirmation_signature_file) and (!$dte->confirmation_status))
                            <form action="{{ route('warehouse.cenabast.bypass', ['dte' => $dte->id]) }}" method="POST">
                                @csrf
                                <button
                                    id="bypassButton"
                                    class="btn btn-warning"
                                    onclick="return confirm('¿Está seguro que desea omitir el proceso de firma?. Esto solamente deberá realizarlo con documentos que ya se encuentran firmados o con carga retroactiva')">
                                    Bypass
                                    Firma 
                                </button>
                            </form>
                        @endif
                        @endcanany

                    </td>
                    <td class="text-center" nowrap>
                        @if (isset($dte->confirmation_signature_file) &&
                                !$dte->block_signature &&
                                !$dte->cenabast_signed_pharmacist &&
                                isset($dte->pharmacist) &&
                                $dte->pharmacist->id == auth()->id())
                            @livewire(
                                'sign.sign-to-document',
                                [
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
                                        'cenabast_reception_file' => '/ionline/cenabast/signature/dte-' . $dte->id . '.pdf',
                                    ],
                                ],
                                $dte->id
                            )
                        @elseif($dte->cenabast_signed_pharmacist)
                            <i class="fas fa-check text-success"></i> Firmado
                        @else
                            Pendiente {{ $dte->pharmacist?->initials }}
                        @endif
                    </td>
                    <td class="text-center" nowrap>
                        @if (
                            $dte->cenabast_signed_pharmacist &&
                                !$dte->block_signature &&
                                !$dte->cenabast_signed_boss &&
                                isset($dte->boss) &&
                                $dte->boss->id == auth()->id())
                            @livewire(
                                'sign.sign-to-document',
                                [
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
                                        'cenabast_reception_file' => '/ionline/cenabast/signature/dte-' . $dte->id . '.pdf',
                                    ],
                                ],
                                key($dte->id)
                            )
                        @elseif($dte->cenabast_signed_boss)
                            <i class="fas fa-check text-success"></i> Firmado
                        @else
                            Pendiente {{ $dte->boss?->initials }}
                        @endif
                    </td>
                    <td class="text-center" nowrap>
                        @if (isset($dte->confirmation_signature_file) && !isset($dte->cenabast_reception_file))
                            <a href="{{ route('warehouse.cenabast.downloadFile', ['dte' => $dte->id]) }}"
                                class="btn btn-sm btn-outline-success" title="Descargar Acta Original">
                                <i class="fas fa-download"></i>
                            </a>
                        @elseif(isset($dte->cenabast_reception_file))
                            <a class="btn btn-sm btn-success"
                                href="{{ route('warehouse.cenabast.download.signed', $dte) }}"
                                title="Descargar Acta Firmada">
                                <i class="fas fa-download"></i>
                            </a>
                        @endif

                        @if ($dte->confirmation_signature_file && !$dte->cenabast_signed_pharmacist && !$dte->cenabast_signed_boss)
                            <button class="btn btn-sm btn-danger" wire:click="deleteFile({{ $dte }})"
                                title="Borrar Acta">
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

    @section('custom_js')
        <script>
            $('.custom-file-input').on('change', function(e) {
                //get the file name
                var fileName = e.target.files[0].name;
                //replace the "Choose a file" label
                $(this).next('.custom-file-label').html(fileName);
            })
        </script>
    @endsection

</div>
