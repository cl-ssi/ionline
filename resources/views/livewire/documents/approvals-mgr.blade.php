<div>
    @section('title', "Solicitudes de aprobación")

    @include('layouts.bt5.partials.flash_message')

    <h3 class="mb-3">Solicitudes de aprobación</h3>

    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputState">Estado</label>
            <select id="inputState" class="form-control" wire:model.defer="filter.status">
                <option value="?">Pendientes</option>
                <option value="1">Aprobados</option>
                <option value="0">Rechazados</option>
                <option value="">Todos</option>
            </select>
        </div>
        <div class="form-group col-md-1">
            <label for="for_filter">&nbsp;</label>
            <button type="submit" class="btn btn-outline-secondary form-control" wire:click="getApprovals">
                <i class="fas fa-filter"></i>
            </button>
        </div>
        <div class="form-group col-md-2">
            <label for="for_filter">&nbsp;</label>
            <a href="{{ route('documents.approvals') }}" class="btn btn-outline-secondary form-control">
                Actualizar
            </a>
        </div>
    </div>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th width="35px"></th>
                <th width="86px">Fecha Solicitud</th>
                <th>Módulo</th>
                <th>Asunto</th>
                <th width="86px">Fecha Acción</th>
                <th>Observación</th>
                <th width="110px"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($approvals as $approval)
            <tr class="table-{{ $approval->color }}">
                <td class="text-center">
                    <div class="form-check">
                        <input class="form-check-input position-static"
                            style="scale: 1.5;"
                            type="checkbox"
                            id="ids.{{$approval->id}}"
                            wire:model.defer="ids.{{$approval->id}}"
                            @disabled(! is_null($approval->status) )>
                    </div>
                </td>
                <td class="small">
                    {{ $approval->created_at }}
                </td>
                <td nowrap>
                    @if( $approval->module_icon )
                    <i class="fa-fw {{$approval->module_icon}}"></i>
                    @endif
                    {{ $approval->module }}
                </td>
                <td>
                    {{ $approval->subject }}
                </td>
                <td class="small">
                    {{ $approval->approver_at }}
                </td>
                <td>
                    {{ $approval->reject_observation }}
                </td>
                <td>

                    <a
                        class="btn btn-sm btn-outline-danger"
                        target="_blank"
                        @if($approval->digital_signature && $approval->status)
                            href="{{ route('documents.signed.approval.pdf', $approval) }}"
                        @else
                            href="{{ route($approval->document_route_name, json_decode($approval->document_route_params, true)) }}"
                        @endif
                    >
                        <i class="fas fa-fw fa-file-pdf"></i>
                    </a>
                    <button
                        class="btn btn-primary btn-sm"
                        wire:click='show({{ $approval }})'
                    >
                        <i class="fas fa-fw fa-eye"></i>
                        <i class="fas fa-fw {{ $approval->approver_ou_id ? 'fa-chess-king' : 'fa-user' }}"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $approvals->links() }}

    <div class="row">
        <div class="col">
            <button class="btn btn-success" wire:click="bulkProcess(true)">
                <i class="fas fa-thumbs-up"></i>
                Aprobar seleccionados
            </button>
        </div>
        <div class="col text-right">
            <button class="btn btn-danger" wire:click="bulkProcess(false)">
                <i class="fas fa-thumbs-down"></i>
                Rechazar seleccionados
            </button>
        </div>
    </div>



    @if($showModal)
        <!-- Modal -->
        <div class="modal {{ $showModal }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="container">
                            <div class="row">

                                <div class="col-5 text-left">
                                    <h6 class="modal-title">
                                        Aprobará como
                                        <i class="fas fa-fw {{ $approvalSelected->approver_ou_id ? 'fa-chess-king' : 'fa-user' }}"></i>
                                        @if($approvalSelected->approver_ou_id)
                                            de {{ $approvalSelected->organizationalUnit->name }}
                                        @else
                                            {{ auth()->user()->tinnyName }}
                                        @endif
                                    </h6>
                                </div>

                                <div class="col-7">
                                    <div class="row text-right">
                                        <div class="col-4 text-right">
                                            @if( is_null($approvalSelected->status) )
                                            <div class="input-group mb-3">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="OTP"
                                                    aria-label="OTP"
                                                    aria-describedby="button-addon"
                                                    wire:model.defer="otp"
                                                >
                                                <div class="input-group-append">
                                                    <button
                                                        class="btn btn-success"
                                                        wire:loading.attr="disabled"
                                                        wire:click="approveOrReject({{ $approvalSelected }}, true)"
                                                    >
                                                        <span
                                                            wire:loading.remove
                                                            wire:target="otp"
                                                        >
                                                            <i class="fas fa-thumbs-up"></i>
                                                        </span>

                                                        <span
                                                            class="spinner-border spinner-border-sm"
                                                            role="status"
                                                            wire:loading
                                                            wire:target="otp"
                                                            aria-hidden="true"
                                                        >
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="text-left mt-1" style="line-height: 15px; font-height: 10px">
                                                @if(isset($message))
                                                    <small id="otp" class="text-danger">
                                                        {{ $message }}
                                                    </small>
                                                @endif
                                            </div>
                                            @endif
                                        </div>

                                        <div class="col-6 text-right">
                                            @if( is_null($approvalSelected->status) )
                                            <div class="input-group mb-3">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Motivo rechazo"
                                                    aria-label="Motivo de rechazo"
                                                    aria-describedby="button-addon"
                                                    wire:model.defer="reject_observation"
                                                    value="{{ $approvalSelected->reject_observation }}"
                                                >
                                                <div class="input-group-append">
                                                    <button
                                                        class="btn btn-danger"
                                                        type="button"
                                                        id="button-addon"
                                                        wire:click="approveOrReject({{ $approvalSelected }}, false)"
                                                    >
                                                        <i class="fas fa-thumbs-down"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @else
                                                <div class="text-{{ $approvalSelected->color }}">
                                                    El documento se encuentra {{ $approvalSelected->status ? 'Aprobado' : 'Rechazado' }}
                                                    <br> <i> <small>{{ $approvalSelected->reject_observation }}</small> </i>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-1 text-right">
                                            <button
                                                type="button"
                                                class="close text-right"
                                                data-dismiss="modal"
                                                aria-label="Close"
                                                wire:click="dismiss"
                                            >
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <object
                            @if($approvalSelected->digital_signature && $approvalSelected->status)
                                data="{{ $approvalSelected->filename_link }}"
                            @else
                                data="{{ route($approvalSelected->document_route_name, json_decode($approvalSelected->document_route_params, true)) }}"
                            @endif
                            type="application/pdf"
                            width="100%"
                            height="700px"
                        >

                            <p>No se puede mostrar el PDF.
                                <a
                                    target="_blank"
                                    @if($approvalSelected->digital_signature && $approvalSelected->status)
                                        href="{{ $approvalSelected->filename_link }}"
                                    @else
                                        href="{{ route($approvalSelected->document_route_name, json_decode($approvalSelected->document_route_params, true)) }}"
                                    @endif
                                >Descargar
                                </a>.
                            </p>
                        </object>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
    @endif
</div>
