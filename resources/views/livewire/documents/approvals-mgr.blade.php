<div>
    <h3 class="mb-3">Aprobaciones pendientes</h3>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Módulo</th>
                <th>Asunto</th>
                <th>Documento</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($approvals as $approval)
            <tr class="table-{{ $approval->color }}">
                <td>{{ $approval->id }}</td>
                <td>
                    @if( $approval->module_icon )
                    <i class="fas fa-{{$approval->module_icon}}"></i>
                    @endif
                    {{ $approval->module }}
                </td>
                <td>{{ $approval->subject }}</td>
                <td>
                    <a target="_blank" href="{{ route($approval->document_route_name,json_decode($approval->document_route_params)) }}">Documento</a>
                </td>
                <td>
                    <button class="btn btn-success" wire:click="approveOrReject({{$approval}},true)">
                        <i class="fas fa-thumbs-up"></i>
                    </button>
                </td>
                <td>
                <div class="input-group mb-3">
                    <input type="text" 
                        class="form-control" placeholder="Motivo rechazo" 
                        aria-label="Motivod e rechazo" aria-describedby="button-addon"
                        wire:model.defer="reject_observation"
                        value="{{ $approval->reject_observation}}">
                        <div class="input-group-append">
                            <button class="btn btn-danger" type="button" id="button-addon" 
                                wire:click="approveOrReject({{$approval}},false)">
                                <i class="fas fa-thumbs-down"></i>
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
