<div>
    <h3 class="mb-3">Listado de Solicitudes para el Colegio {{$school->name}}</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Solicitud N°</th>
                <th>Run</th>
                <th>Nombre Completo</th>
                <th>Cargo</th>
                <th>Correo</th>
                <th>Certificado de Inhabilidades</th>
                <th>Estado</th>
                <th>Descargar Certificado<br> <small>(En caso que estado sea "aprobado" y no salga para descargar, significa que está en proceso de firma electrónica)</small></th>
            </tr>
        </thead>
        <tbody>
            @forelse($school->psirequests as $psirequest)
                @livewire('suitability.school-request-row', ['psirequest' => $psirequest], key('request-'.$psirequest->id))            
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            No hay solicitudes creadas
                        </td>
                    </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Central Modal -->
    @if($showModal)
        <!-- Modal -->
        <div class="modal fade show" tabindex="-1" style="display: block;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Inhabilidades</h5>
                        <button type="button" class="btn-close" 
                                wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="saveInhability">
                            <div class="mb-3">
                                <label class="form-label">Status:</label>
                                <select class="form-select" wire:model="selectedInhability">
                                    <option value="">Select status</option>
                                    <option value="none" disabled>No Certificate</option>
                                    <option value="in_progress" disabled>In Progress</option>
                                    <option value="enabled">No Inhabilidades</option>
                                    <option value="disabled" disabled>Disabled</option>
                                </select>
                                @error('selectedInhability')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" 
                                wire:click="closeModal">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-primary" 
                                wire:click="saveInhability"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>Save</span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm"></span>
                                Saving...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Backdrop -->
        <div class="modal-backdrop fade show" wire:click="closeModal"></div>
    @endif

</div>
