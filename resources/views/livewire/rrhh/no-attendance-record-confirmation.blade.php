<div>
    <div class="row">
        <div class="col">
            <h3 class="mb-3">Nuevo registro de marca de {{ $noAttendanceRecord->user->shortName }}</h3>
        </div>
        <div class="col-3 text-right">
            <a href="{{ route('rrhh.attendance.no-records.mgr') }}" class="btn btn-outline-secondary"> <i class="fas fa-arrow-left"></i> Bandeja </a>
        </div>
    </div>

    <p>El día: <strong>{{ $noAttendanceRecord->date }}</strong></p>
    <p>Fundamento: <strong>{{ $noAttendanceRecord->reason->name }}</strong> <span class="text-muted">{{ $noAttendanceRecord->observation }}</span></p><br>

    @if($noAttendanceRecord->authority->id == auth()->id())

        @if(is_null($noAttendanceRecord->status))
        <div class="form-row">
            <div class="input-group col-8 mb-3">
                <input type="text" class="form-control" wire:model.live="noAttendanceRecord.authority_observation" placeholder="Fundamento del rechazo" aria-label="Fundamento del rechazo">
                <div class="input-group-append">
                    <button class="btn btn-danger" type="button" wire:click="confirmation(false)">
                        <i class="fas fa-thumbs-down"></i> Rechazar
                    </button>
                </div>
            </div>

            <div class="col-3 text-right">
                <button class="btn btn-success" type="button" wire:click="confirmation(true)">
                    <i class="fas fa-thumbs-up"></i> Aprobar
                </button>
            </div>
        </div>
        @else
            Estado: <i class="fas {{ ($noAttendanceRecord->status == true) ? 'fa-thumbs-up text-success' : 'fa-thumbs-down text-danger' }}"></i>
            por <strong>{{ $noAttendanceRecord->authority->shortname}}</strong> <br>
            Fundamento: <strong>{{ $noAttendanceRecord->authority_observation }}</strong>
        @endif
    @else
        <h3 class="text-danger">Esta confirmación sólo puede ser aprobada por {{ $noAttendanceRecord->authority->shortName }}</h3>
    @endif

</div>
