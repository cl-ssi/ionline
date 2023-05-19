<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-comment mt-2"></i> Canal de Comunicación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" class="form-horizontal" action="{{ route('job_position_profile.message.store', $jobPositionProfile) }}" enctype="multipart/form-data"/>
            @csrf
            @method('POST')
            <div class="modal-body">
                @livewire('job-position-profile.create-messages', [
                    'jobPositionProfile'    => $jobPositionProfile
                ])
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary btn-sm">Enviar Mensaje</button>
            </div>
            </form>
        </div>
    </div>
</div>