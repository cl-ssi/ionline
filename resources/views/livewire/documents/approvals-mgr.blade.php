<div>
    @section('title', "Solicitudes de aprobación")

    @include('layouts.bt5.partials.flash_message')

    <h3 class="mb-3">Solicitudes de aprobación</h3>

    <div class="row g-2 mb-3">
        <div class="form-group col-md-2">
            <label for="inputState">Estado</label>
            <select id="inputState" class="form-select" wire:model="filter.status">
                <option value="?">Pendientes</option>
                <option value="1">Aprobados</option>
                <option value="0">Rechazados</option>
                <option value="">Todos</option>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="inputModule">Módulo</label>
            <select id="inputModule" class="form-select" wire:model="filter.module">
                <option value="">Todos</option>
                @foreach($modules as $module)
                <option value="{{ $module }}">{{ $module }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-1">
            <label for="for_filter">&nbsp;</label>
            <button type="submit" class="btn btn-outline-secondary form-control" wire:click="getApprovals">
                <i class="fas fa-filter"></i>
            </button>
        </div>
        <!-- <div class="form-group col-md-2">
            <label for="for_filter">&nbsp;</label>
            <a href="{{ route('documents.approvals') }}" class="btn btn-outline-secondary form-control">
                Actualizar
            </a>
        </div> -->
    </div>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th width="42"></th>
                <th>Id</th>
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
                    @if($approval->status != true AND is_null($approval->callback_feedback_inputs))
                    <input class="form-check-input"
                        style="scale: 1.4;"
                        type="checkbox"
                        id="ids.{{$approval->id}}"
                        wire:model="ids.{{$approval->id}}">
                    @endif
                </td>
                <td class="text-center">
                    <small>{{ $approval->id }}</small>
                </td>
                <td class="small">
                    {{ $approval->created_at }}
                </td>
                <td nowrap>
                    @if( $approval->module_icon )
                    <i class="fa-fw {{$approval->module_icon}}"></i>
                    @endif
                    {{ $approval->module }}
                    <br>
                    ID: {{ $approval->approvable_id }}
                </td>
                <td>
                    {!! $approval->subject !!}
                </td>
                <td class="small">
                    {{ $approval->approver_at }}
                </td>
                <td>
                    {{ $approval->approver_observation }}
                </td>
                <td>

                    <a
                        class="btn btn-sm btn-outline-danger"
                        target="_blank"
                        @if($approval->digital_signature && $approval->status)
                            href="{{ route('documents.signed.approval.pdf', $approval) }}"
                        @else
                            @if($approval->document_pdf_path)
                                href="{{ route('documents.approvals.show-pdf', $approval) }}"
                            @else
                                href="{{ $approval->document_route_name ? route($approval->document_route_name, json_decode($approval->document_route_params, true)) : '' }}"
                            @endif
                        @endif
                    >
                        <i class="fas fa-fw fa-file-pdf"></i>
                    </a>

                    @include('documents.approvals.partials.button', [
                        'button_size' => 'btn-sm',
                        'button_text' => null,
                    ])

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $approvals->links() }}

    <div class="row">
        <div class="col-4">
            <div class="input-group">
                <input type="text" 
                    placeholder="OTP" 
                    class="form-control"
                    wire:model="otp">
                <button class="btn btn-success" wire:click="bulkProcess(true)" wire:loading.attr="disabled">
                    <i class="fa fa-spinner fa-spin" wire:loading></i>
                    <i class="fas fa-thumbs-up" wire:loading.class="d-none"></i> 
                    Aprobar seleccionados
                </button>
            </div>
            <div class="text-danger">
                {{ $message ?? '' }}
            </div>
        </div>
        <div class="col text-end">
            <button class="btn btn-danger" wire:click="bulkProcess(false)">
                <i class="fas fa-thumbs-down"></i>
                Rechazar seleccionados
            </button>
        </div>
    </div>

    <!-- Modal -->
    @include('documents.approvals.partials.modal')
</div>
