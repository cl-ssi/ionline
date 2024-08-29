<div>
    @include('rrhh.performance_report.partials.nav')
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <h3 class="mb-3">Informe de desempeño realizados</h3>
    <div class="mb-3">
        <label class="form-label" for="newField">Periodo</label>
        <select class="form-select" id="year" wire:model.live="year" required autocomplete="off">
            @for ($i = now()->year; $i >= 2024; $i--)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
    </div>

    <table class="table table-sm table-bordered">
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Unidad</th>
        @foreach($periods as $period)
            <th class="text-center {{ now()->greaterThan($period->end_at) ? 'table-primary' : '' }}">{{ $period->name }}</th>
        @endforeach
    </tr>
</thead>
<tbody>
    @forelse($users as $user)
        <tr>
            <td>{{ $user->short_name }}</td>
            <td>{{ $organizationalUnit }}</td>
            @foreach($periods as $period)
                <td class="text-center">
                @if(now()->greaterThanOrEqualTo($period->end_at))
                    @if($hasExistingReport = $this->hasExistingReport($user->id, $period->id))
                            <a href="#" wire:click.prevent="viewReport('{{ $user->id }}', '{{ $period->id }}')" data-bs-toggle="modal" data-bs-target="#reportModal" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('rrhh.performance-report.show', ['userId' => $user->id, 'periodId' => $period->id]) }}" class="btn btn-outline-primary btn-sm" title="Descargar PDF" target="_blank">
                                <i class="bi bi-file-pdf"></i>
                            </a>
                            <button class="btn btn-outline-danger btn-sm" wire:click="deleteReport('{{ $user->id }}', '{{ $period->id }}')" data-bs-toggle="tooltip" title="Borrar Informe">
                                <i class="bi bi-trash"></i>
                            </button>
                        @else
                            <a class="btn btn-outline-success btn-sm" wire:click="showForm('{{ $user->id }}', '{{ $period->id }}')">
                                <i class="bi bi-file-check"></i>
                            </a>
                        @endif
                    @else
                    <button class="btn btn-secondary btn-sm disabled"><i class="bi bi-file-check"></i></button>
                @endif
                </td>
            @endforeach
        </tr>
    @empty
        <tr>
            <td colspan="{{ count($periods) + 2 }}" class="text-center">No hay usuarios para mostrar</td>
        </tr>
    @endforelse
</tbody>

    </table>

    <br><br><br>

    @if($selectedUser)
        <h4 class="mb-3">Informe de desempeño</h4>
        <form wire:submit="saveReport">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Periodo</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" value="{{ $selectedPeriod->name }}"  readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label  class="col-sm-3 col-form-label">Nombre Funcionario</label>
                <div class="col-sm-9">
                <input type="text" class="form-control"  value="{{ $selectedUser->short_name }}"  readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Unidad organizacional</label>
                <div class="col-sm-9">
                <input type="text" class="form-control"  value="{{ $organizationalUnit }}" readonly>
                </div>
            </div>
            <h5 for="rend">1. Factor Rendimiento</h5>
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Cantidad de trabajo</label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="2" wire:model="cantidad_de_trabajo"></textarea>
                </div>
                @error('cantidad_de_trabajo') <span class="text-danger error small">{{ $message }}</span> @enderror
            </div>
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Calidad del trabajo</label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="2" wire:model="calidad_del_trabajo"></textarea>
                </div>
                @error('calidad_del_trabajo') <span class="text-danger error small">{{ $message }}</span> @enderror
            </div>
            <h5 for="rend">2. Factor Condiciones Personales</h5>
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Conocimiento del trabajo*</label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="2" wire:model="conocimiento_del_trabajo"></textarea>
                </div>
                @error('conocimiento_del_trabajo') <span class="text-danger error small">{{ $message }}</span> @enderror
            </div>
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Interés por el trabajo*</label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="2" wire:model="interes_por_el_trabajo"></textarea>
                </div>
                @error('interes_por_el_trabajo') <span class="text-danger error small">{{ $message }}</span> @enderror
            </div>
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Capacidad trabajo en grupo*</label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="2" wire:model="capacidad_trabajo_en_grupo"></textarea>
                </div>
                @error('capacidad_trabajo_en_grupo') <span class="text-danger error small">{{ $message }}</span> @enderror
            </div>
            <h5 for="rend">3. Factor Comportamiento Funcionario</h5>
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Asistencia*</label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="2" wire:model="asistencia"></textarea>
                </div>
                @error('asistencia') <span class="text-danger error small">{{ $message }}</span> @enderror
            </div>
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Puntualidad*</label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="2" wire:model="puntualidad"></textarea>
                </div>
                @error('puntualidad') <span class="text-danger error small">{{ $message }}</span> @enderror
            </div>
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Cumplimiento normas e instrucciones*</label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="2" wire:model="cumplimiento_normas_e_instrucciones"></textarea>
                </div>
                @error('cumplimiento_normas_e_instrucciones') <span class="text-danger error small">{{ $message }}</span> @enderror
            </div>
            <hr>
            <h5 for="rend">Observación</h5>
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Observación <small>(opcional)</small></label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="2" wire:model="creator_user_observation"></textarea>
                </div>
            </div>
            <div class="d-grid">
                <br>
                <button class="btn btn-success btn-lg" id="submitButton" type="submit">Finalizar</button>
            </div>
        </form>
    @endif


    <div wire:ignore.self class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Informe de Desempeño</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($reportDetails)
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Periodo</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{ $reportDetails->period?->name }}"  readonly>
                        </div>
                    </div>
                        <div class="row mb-3">
                        <label  class="col-sm-3 col-form-label">Nombre Funcionario</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control"  value="{{ $reportDetails->receivedUser?->short_name }}"  readonly>
                        </div>
                    </div>
                        <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Unidad organizacional</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control"  value="{{ $reportDetails->receivedOrganizationalUnit?->name }}" readonly>
                        </div>
                    </div>
                    <h5 for="rend">1. Factor Rendimiento</h5>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Cantidad de trabajo*</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" readonly>{{ $reportDetails->cantidad_de_trabajo }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Calidad del trabajo*</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" readonly>{{ $reportDetails->calidad_del_trabajo }}</textarea>
                        </div>
                    </div>
                    <h5 for="rend">2. Factor Condiciones Personales</h5>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Conocimiento del trabajo</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" readonly>{{ $reportDetails->conocimiento_del_trabajo }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Interés por el trabajo</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" readonly>{{ $reportDetails->interes_por_el_trabajo }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Capacidad trabajo en grupo</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" readonly>{{ $reportDetails->capacidad_trabajo_en_grupo }}</textarea>
                        </div>
                    </div>
                    <h5 for="rend">3. Factor Comportamiento Funcionario</h5>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Asistencia</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" readonly>{{ $reportDetails->asistencia }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Puntualidad</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" readonly>{{ $reportDetails->puntualidad }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Cumplimiento normas e instrucciones</label>
                        <div class="col-sm-9">
                            <textarea  class="form-control" rows="2" readonly>{{ $reportDetails->cumplimiento_normas_e_instrucciones }}</textarea>
                        </div>
                    </div>
                    <hr>
                    <h5 for="rend">Observación</h5>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Observación <small>(opcional)</small></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" readonly>{{ $reportDetails->creator_user_observation }}</textarea>
                        </div>
                    </div>
                    @else
                        <p>No hay detalles de informe disponibles.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</div>